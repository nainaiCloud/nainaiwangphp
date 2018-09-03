<?php
/**
 * User: weipinglee
 * Date: 2018/7/11
 * Time: 11:05
 */

namespace nainai\user;

use \Library\M;
use \Library\tool;
use \nainai\syslog;
class UserPaylog
{

    protected $tabalName = 'user_pay_log';

    protected $subjects = array();//主题的取值

    public $bankObj = null;

    public $subject = '';
    public $subject_id = 0;
    public $user_id  = 0;
    public $userBankObj = null;


    public function __construct($userBankObj=null)
    {
        $this->subjects = array('jingjia');
        $this->userBankObj = $userBankObj==null ? new \nainai\user\UserBank() : $userBankObj;

    }

    public function __set($name, $value)
    {
       switch($name){
           case 'bankObj' : $this->bankObj = $value;
           break;
           case 'userBankObj' : $this->userBankObj=$value;
           break;
           case 'subject' : $this->subject = $value;
           break;
           case 'subject_id': $this->subject_id = $value;
           break;
           case 'user_id' : $this->user_id = $value;
           break;

       }
    }


    /**
     * 商品验证规则
     * @var array
     */
    protected $rules = array(
        array('user_id','number','用户id必须是数字'),
        array('subject','/^[a-zA-Z0-9_]+$/','支付记录主题必须是英文字母或数字'),
       // array('acc_bank','require','账号所属银行必填'),
        array('acc_no','require','账号必填'),
        array('subject_id', 'number', '主题id必须是数字')
    );


    public function createMatchLog($startDate,$endDate='',$amount){
        $where = array('subject'=>$this->subject,'subject_id'=>$this->subject_id,'user_id'=>$this->user_id);
        $log = $this->getOneLog($where);
        if(!empty($log) && $log['bank_flow']!=''){//已经关联流水号，不能再次关联
            syslog::info("用户".$this->user_id."重复匹配竞价保证金，竞价id".$this->subject_id);
            return tool::getSuccInfo(1,'当前竞价已支付保证金');
        }
        //获取比对的账号
        $graphql = new \nainai\graphqls();

        $query = '{ user(id:'.$this->user_id.')
                        {
                        id,type,true_name,
                         bank(status:1){
                           bank_name,card_no,true_name
                         },
                        }
                   }';

        $graData = $graphql->query($query);
        if($graData['data']['user']==null){
            return tool::getSuccInfo(0,"用户不存在");
        }

        if($graData['data']['user']['type']==0 && empty($graData['data']['user']['bank'])){
            return tool::getSuccInfo(0,'个人用户请先开户');
        }


        $matchFlow = $this->findMatchFlow($startDate,$endDate,$graData['data']['user'],$amount);

        if($matchFlow['acc_no'] && $matchFlow['status']==1){//有匹配的流水
            syslog::info("找到可用流水，流水号：".$matchFlow['bank_flow']);
            $where = array('subject'=>'jingjia','subject_id'=>$this->subject_id,'user_id'=>$this->user_id);
            $res = $this->existUpdateElseInsert($matchFlow,$where);
            if($res){
                return tool::getSuccInfo();
            }else{
                return tool::getSuccInfo(0,'匹配失败');
            }
        }elseif($matchFlow['acc_no'] && $matchFlow['status']==2){
            return tool::getSuccInfo(4,'匹配到保证金，但金额不符合');
        }else{
            syslog::info("用户".$this->user_id."，竞价id".$this->subject_id.'的竞价没有找到保证金支付记录');
            return tool::getSuccInfo(0,'没有匹配的缴费记录');
        }
    }
    /**
     * 根据主题和id获取一条支付记录
     * @param $subject
     * @param $id
     * @return array
     */
    public function getOneLog($where){
        $obj = new M($this->tabalName);
        $data = $obj->where($where)->getObj();
        return $data;
    }

    /**
     * 获取比对的账户信息,开户信息中的账号
     * @param $user_id
     * @return array
     */
    private function getCompareAcc($user_id){
        $userBankObj = $this->userBankObj;
        $bankData = $userBankObj->getActiveBankInfo($user_id);
        if(empty($bankData)){
            return array();
        }
        $compareData['acc_no'] = $bankData['card_no'];

        return $compareData;
    }


    /**
     * 获取时间段内的银行流水
     * @param $startDate
     * @param string $endDate
     * @return array|string
     */
    private function bankFlow($startDate,$endDate=''){
        $this->bankObj = $this->bankObj==null ? new \nainai\fund\js() : $this->bankObj;
        try {
            $date = new \DateTime($startDate);
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit(1);
        }
        $startDate = $date->format('Ymd');
        if($endDate){
            try {
                $date = new \DateTime($endDate);
            } catch (\Exception $e) {
                echo $e->getMessage();
                exit(1);
            }
            $endDate = $date->format('Ymd');
        }
        $flow = $this->bankObj->marketFlow(array('start'=>$startDate,'end'=>$endDate));
        return $flow;
    }


    /**
     * 返回在一个时间段内与账户、金额匹配的流水
     * @param $startDate
     * @param string $endDate
     * @param array $matchData 匹配数据
     * @param $amount
     * @return array
     */
    public function findMatchFlow($startDate,$endDate='',$matchData,$amount){
        $flow = $this->bankFlow($startDate,$endDate);
        $acc_no = isset($matchData['bank']['card_no']) ? $matchData['bank']['card_no'] : '';
        syslog::info("用户寻找流水记录，账号：".$acc_no.',金额：'.$amount.'用户id:'.$matchData['id']);
        $resData = array(
            'acc_no'=>'',
            'acc_name'=>'',
            'pay_total'=>0,
            'bank_flow'=>'',
            'pay_time'=>''
        );
        if(!empty($flow)){
            foreach($flow as $item){
                //如果账户与交易金额和提供的账号金额匹配
                $tempAccNo = $item['OP_ACCT_NO_32'];
                $tempAmount = $item['TX_AMT'];
                $tempAccName = $item['OP_CUST_NAME'];
                $tempFlow = $item['TX_LOG_NO'];
                $tempPayTime = substr($item['TX_DT'].$item['TX_TM'],0,-3);
                if( $matchData['type']==0 && $tempAccNo==$acc_no || ($matchData['type']==1 && $tempAccName==$matchData['true_name']) ){
                    //然后再判断这个流水在pay_log表中是否存在，已存在则不能使用

                    $res = $this->getOneLog(array('bank_flow'=>$tempFlow));

                    if(empty($res)){//如果为空，该流水可用
                        $resData['acc_no'] = $acc_no;
                        $resData['acc_name'] = $tempAccName;
                        $resData['pay_total'] = $amount;
                        $resData['bank_flow'] = $tempFlow;
                        if( bccomp($amount,$tempAmount,2)==0){
                            //转换时间格式
                            $dateObj = new \DateTime($tempPayTime);
                            $dateObj->createFromFormat('YmdHis',$tempPayTime);
                            $resData['pay_time'] = $dateObj->format('Y-m-d H:i:s');
                            $resData['status'] = 1;//表示已缴纳
                            break;
                        }else{
                            $resData['status'] = 2;//表示金额不等
                        }


                    }
                }
            }
        }
        return $resData;

    }

    /**
     * where条件的记录存在则更新，不存在则插入
     * @param $data
     * @param $where
     */
    public function existUpdateElseInsert($data,$where){
        $obj = new M($this->tabalName);
        $insert = array_merge($data,$where);
        $insert['create_time'] = \Library\time::getDateTime();
        $res = $obj->insertUpdate($insert,array_merge($data,$where));
        return $res;
    }

    /**
     * 检查某个用户某个主题下的某个主题是否有支付记录
     * @param $subject
     * @param $subject_id
     * @param $user_id
     * @return bool true:已支付
     */
    public function existPayLog($subject,$subject_id,$user_id){
        $where = array('subject'=>$subject,'subject_id'=>$subject_id,'user_id'=>$user_id,'status'=>1);
        if(empty($this->getOneLog($where))){
            return false;
        }else{
            return true;
        }
    }




}