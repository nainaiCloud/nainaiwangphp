<?php
/**
 * User: weipinglee
 * Date: 2018/7/11
 * Time: 11:05
 */

namespace nainai\user;

use \Library\M;
use \Library\tool;
class UserPaylog
{

    protected $tabalName = 'user_pay_log';

    protected $subjects = array();//�����ȡֵ

    protected $bankObj = null;

    public $subject = '';
    public $subject_id = 0;
    public $user_id  = 0;



    public function __construct()
    {
        $this->subjects = array('jingjia');
        $this->bankObj = new \nainai\fund\js();
    }

    public function __set($name, $value)
    {
       switch($name){
           case 'bankObj' : $this->bankObj = $value;
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
     * ��Ʒ��֤����
     * @var array
     */
    protected $rules = array(
        array('user_id','number','�û�id����������'),
        array('subject','/^[a-zA-Z0-9_]+$/','֧����¼���������Ӣ����ĸ������'),
       // array('acc_bank','require','�˺��������б���'),
        array('acc_no','require','�˺ű���'),
        array('subject_id', 'number', '����id����������')
    );


    public function createMatchLog($startDate,$endDate='',$amount){
        $where = array('subject'=>$this->subject,'subject_id'=>$this->subject_id,'user_id'=>$this->user_id);
        $log = $this->getOneLog($where);
        if(!empty($log) && $log['bank_flow']!=''){//�Ѿ�������ˮ�ţ������ٴι���
            return tool::getSuccInfo(0,'��Ҫ�ظ�����');
        }
        //��ȡ�ȶԵ��˺�
        $compareData = $this->getCompareAcc($this->user_id);

        if(empty($compareData)){
            return tool::getSuccInfo(0,'���ȿ���');
        }

        $matchFlow = $this->findMatchFlow($startDate,$endDate,$compareData['acc_no'],$amount);

        if($matchFlow['acc_no']){//��ƥ�����ˮ
            $where = array('subject'=>'jingjia','subject_id'=>$this->subject_id,'user_id'=>$this->user_id);
            $res = $this->existUpdateElseInsert($matchFlow,$where);
            if($res){
                return tool::getSuccInfo();
            }else{
                return tool::getSuccInfo(0,'ƥ��ʧ��');
            }
        }else{
            return tool::getSuccInfo(0,'û��ƥ��ĽɷѼ�¼');
        }
    }
    /**
     * ���������id��ȡһ��֧����¼
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
     * ��ȡ�ȶԵ��˻���Ϣ,������Ϣ�е��˺�
     * @param $user_id
     * @return array
     */
    private function getCompareAcc($user_id){
        $userBankObj = new \nainai\user\UserBank();
        $bankData = $userBankObj->getActiveBankInfo($user_id);
        if(empty($bankData)){
            return array();
        }
        $compareData['acc_no'] = $bankData['card_no'];

        return $compareData;
    }


    /**
     * ��ȡʱ����ڵ�������ˮ
     * @param $startDate
     * @param string $endDate
     * @return array|string
     */
    private function bankFlow($startDate,$endDate=''){
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
     * ������һ��ʱ��������˻������ƥ�����ˮ
     * @param $startDate
     * @param string $endDate
     * @param $acc_no
     * @param $amount
     * @return array
     */
    public function findMatchFlow($startDate,$endDate='',$acc_no,$amount){
        $flow = $this->bankFlow($startDate,$endDate);
        $res = array(
            'acc_no'=>'',
            'acc_name'=>'',
            'pay_total'=>0,
            'bank_flow'=>'',
            'pay_time'=>''
        );
        if(!empty($flow)){
            foreach($flow as $item){
                //����˻��뽻�׽����ṩ���˺Ž��ƥ��
                $tempAccNo = $item['OP_ACCT_NO_32'];
                $tempAmount = $item['TX_AMT'];
                $tempAccName = $item['OP_CUST_NAME'];
                $tempFlow = $item['TX_LOG_NO'];
                $tempPayTime = substr($item['TX_DT'].$item['TX_TM'],0,-3);
                if($tempAccNo==$acc_no && bccomp($amount,$tempAmount,2)==0){
                    //Ȼ�����ж������ˮ��pay_log�����Ƿ���ڣ��Ѵ�������ʹ��
                    $res = $this->getOneLog(array('bank_flow'=>$tempFlow))->getObj();
                    if(empty($res)){//���Ϊ�գ�����ˮ����
                        $res['acc_no'] = $acc_no;
                        $res['acc_name'] = $tempAccName;
                        $res['pay_total'] = $amount;
                        $res['bank_flow'] = $tempFlow;
                        //ת��ʱ���ʽ
                        $dateObj = new \DateTime($tempPayTime);
                        $dateObj->createFromFormat('YmdHis',$tempPayTime);
                        $res['pay_time'] = $dateObj->format('Y-m-d H:i:s');
                        $res['status'] = 1;//��ʾ�ѽ���

                    }
                }
            }
        }
        return $res;

    }

    /**
     * where�����ļ�¼��������£������������
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




}