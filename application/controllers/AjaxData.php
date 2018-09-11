<?php
/**
 * 交易中心不需要登录的控制器公共类
 */
use \Library\url;
use \Library\safe;
use \Library\tool;
use \Library\json;
class AjaxDataController extends \Yaf\Controller_Abstract{

     public $login;

     private $offer;
     private $order;
     public function init(){
          $this->offer = new offersModel();
          $right = new \Library\checkRight();
          $isLogin = $right->checkLogin();
          if($isLogin){
               $this->login = \Library\session::get('login');
          }
     }

     private function offerList($pid='',$type=1,$mode=0,$page=1,$order='',$area='',$search=''){
         //获取这个分类下对应的产品信息
         $condition = array();
         $cate = array();
         if($pid!=0)
             $condition['pid'] = $pid;
         if($type!=0){
             $condition['type'] = $type;
         }
         if($mode!=0){
             if($mode<=4)
                 $condition['mode'] = $mode;
             elseif($mode==5){
                 $condition['sub_mode'] = 1;
             }
             else
                 $condition['sub_mode'] = 2;

         }
         if($area!=0){
             $condition['area'] = $area;
         }
         if($search!=''){
             $condition['search'] = $search;
         }

         if($order!=''){
             $orderArr = explode('_',$order);
             switch($orderArr[0]){
                 case 'price' : {
                     if(isset($orderArr[1]) && $orderArr[1]=='asc')
                         $order = 'price asc';
                     else $order = 'price desc';
                 }
                     break;
                 case 'time' : {
                     if(isset($orderArr[1]) && $orderArr[1]=='asc')
                         $order = 'apply_time asc';
                     else $order = 'apply_time desc';
                 }
                     break;
                 default : {
                     $order = '';
                 }
             }
         }
         if ( ! empty($this->login)) {
             $login_status = 1;
         }else{
             $login_status = 0;
             $this->login['user_id'] = 0;
         }
         $data = $this->offer->getList($page, $condition,$order,$this->login['user_id']);
         $data['login'] = $login_status;

         // var_dump($data);exit;
         return $data;
     }
     /**
      * AJax获取产品分类信息
      * @return [Json]
      */
     public function ajaxGetCategoryAction(){
          $pid = safe::filterPost('pid', 'int',0);
          $type = safe::filterPost('type', 'int',0);
          $mode = safe::filterPost('mode', 'int',0);
          $page = safe::filterPost('page','int',1);
          $order = safe::filterPost('sort');
          $area = safe::filterPost('area','int',0);
          $search = safe::filterPost('search');

          $data = $this->offerList($pid,$type,$mode,$page,$order,$area,$search);
          die(json_encode($data));


     }

     public function jingjiaListAction(){
         $pid = safe::filterGet('pid', 'int',0);
         $status = safe::filterGet('status','int');
         $page = safe::filterGet('page','int',1);
         $area = safe::filterGet('area','int',0);
         $search = safe::filterGet('search');
         $order = safe::filterGet('sort');
         $condition = array();
         if($pid!=0)
             $condition['pid'] = $pid;

         if($area!=0){
             $condition['area'] = $area;
         }
         if($search!=''){
             $condition['search'] = $search;
         }

         if($order!=''){
             $orderArr = explode('_',$order);
             switch($orderArr[0]){
                 case 'price' : {
                     if(isset($orderArr[1]) && $orderArr[1]=='asc')
                         $order = 'price asc';
                     else $order = 'price desc';
                 }
                     break;
                 case 'time' : {
                     if(isset($orderArr[1]) && $orderArr[1]=='asc')
                         $order = 'apply_time asc';
                     else $order = 'apply_time desc';
                 }
                     break;
                 default : {
                     $order = '';
                 }
             }
         }
         //各状态对应的sql条件
         if($status==1){
             $condition['status'] = "o.start_time>now()";
         }elseif($status==2){
             $condition['status'] = "o.start_time<now() and o.end_time>now()";
         }elseif($status==3){
             $condition['status'] = "now()>o.end_time";
         }
         $data = $this->offer->jingjiaList($page, $condition,$order);
         if(!empty($data['data'])){
             foreach($data['data'] as $key=>$item){
                 if(isset($this->login['user_id']) && $this->login['user_id']==$item['user_id']){
                     $data['data'][$key]['pass'] = $item['jingjia_pass'];
                 }else{
                     $data['data'][$key]['pass'] = 0;
                 }
             }
         }
         die(json_encode($data));
     }

     /**
      * 根据传回的条件参数，查询产品
      */
     public function getIndexProductAction()
     {
          $config_id = safe::filterGet('config_id','int',0);
          $data = $this->offer->getOfferlistByConfig($config_id);
          die(\Library\json::encode($data));

     }

     public function getConfigProductAction()
     {

     }
	 
	 public function zixunDataAction(){
		 $url = 'http://info.nainaiwang.com/interface/tradewebinfo';
		 $ch = curl_init($url);
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_POST,1);
	 	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	 	//curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
	 	$output = curl_exec($ch);
	 	if(curl_errno($ch)){
	 		die('网络错误');
	 	}
		curl_close($ch);
		//$xml_obj = (array)new \SimpleXMLElement($output);
		die($output);
	 }



     public function healthAction(){
          die(\Library\json::encode(array('status'=>'UP','info'=>'SUCCESS')));
	 }

     /**
      * 报盘热销排行榜
      */
     public function offerRankAction()
     {
          $query = new \Library\Query('product_offer as o');
          $query->join = "left join products as p on o.product_id = p.id  ";
          $query->fields = "o.*,p.img,p.name,p.note,p.unit,p.quantity,p.freeze,p.sell,p.produce_area,IF(p.quantity-p.sell-p.freeze>0,0,1) as jiao";

          $query->where = ' o.status=:status and o.is_del = 0  and o.expire_time > now()';

          $query->bind = array('status'=>1);
          $query->order = 'o.sell_num desc';
          $query->limit = 6;
          $data = $query->find();
          foreach ($data as $key => &$value) {
               $value['img'] = empty($value['img']) ? '' : \Library\thumb::get($value['img'],180,180);//获取缩略图
          }
          die(\Library\json::encode($data));

     }

    public function checkLoginAction(){
        $right = new \Library\checkRight();
        $isLogin = $right->checkLogin();
        if($isLogin){
            $this->login = \Library\session::get('login');
            //获取未读消息
            $messObj=new \nainai\message($this->login['user_id']);
            $mess=$messObj->getCountMessage();
            $jsonArr = array(
                'mess'=>$mess,
                'login'=>1,
                'username'=>$this->login['username'],
                'sess_id' =>session_id(),
                'user_id' => $this->login['user_id'],
                'cert'    => $this->login['cert']
            );
            die(json_encode($jsonArr));

        }
        else
            die(json_encode(array('login'=>0)));
    }

    //计算定金
    public function payDepositComAction(){
        $num = safe::filterPost('num','floatval');
        $id = safe::filterPost('id','int');
        $price = safe::filterPost('price','floatval');
        $order = new \nainai\order\Order();
        $amount = $num * $price;
        $payDeposit = $order->payDepositCom($id,$amount);
        $res = $payDeposit === false ? tool::getSuccInfo(0,'获取定金失败') : tool::getSuccInfo(1,$payDeposit);
        die(json_encode($res));
    }

    public function jingjiaDepositAction(){
         if(isset($this->login['user_id'])){
             $offer_id = safe::filterGet('id','int');
             $userPaylog = new \nainai\user\UserPaylog();
             $res = $userPaylog->existPayLog('jingjia',$offer_id,$this->login['user_id']);
             if($res){
                 die(\Library\JSON::encode(tool::getSuccInfo()));
             }else{
                 die(\Library\JSON::encode(tool::getSuccInfo(0,'未缴纳保证金')));
             }
         }else{
             die(\Library\JSON::encode(tool::getSuccInfo(0,'未登录')));
         }
    }

    public function alrealyDepositAction(){
        if(isset($this->login['user_id'])){
            $offer_id = safe::filterPost('id','int');
            $jingjiaObj = new \nainai\offer\jingjiaOffer();
            $res = $jingjiaObj->checkDeposit($offer_id,$this->login['user_id']);
            die(\Library\JSON::encode($res));
        }else{
            die(\Library\JSON::encode(tool::getSuccInfo(0,'未登录')));
        }

    }

    public function jingjiaContractAction(){
        $graphql = new \nainai\graphqls();
        $offer_id = safe::filterGet('id','int');
        $query = '{
                        jingjia(id:'.$offer_id.'){
                            pro_name,
                            max_num,accept_area,end_time,product_id,accept_area_code,user_id,pay_days,
                            product{
                               produce_area,produce_address,note,unit,
                               attribute{
                                 name,value
                               }
                            },
                            seller{
                              true_name
                            }
                        }
                   }';

        $data = $graphql->query($query);
        die(JSON::encode($data['data']['jingjia']));
    }

    public function jingjiaDetailAction(){
        $id = Safe::filterGet('id', 'int');
        $pass = safe::filterGet('pass');
        if($id){
            //获取offer数据
            $info = $this->offer->offerDetail($id);
            if(empty($info)){
                die(json_encode(tool::getSuccInfo(0,'竞价不存在')));
            }

            $jingjiaOffer = new \nainai\offer\jingjiaOffer();

            if($info['status']==1 && !$jingjiaOffer->checkPass($id,$pass)){
                die(json_encode(tool::getSuccInfo(0,'场内竞价口令错误，您无权查看')));
            }
            $jingjiaOffer->addViews($id);
            //获取产品数据
            $pro = new \nainai\offer\product();
            $info = array_merge($info,$pro->getProductDetails($info['product_id']));
            $info['produce_area'] = tool::areaText($info['produce_area']);
            $info['accept_area_code'] = tool::areaText($info['accept_area_code']);
            //获取卖方数据
            $mem = new \nainai\member();
            $info['user'] = $mem->getUserDetail($info['user_id']);

            if(isset($this->login['user_id'])){
                $info['login_user'] = $this->login['user_id'];
            }else{
                $info['login_user'] = 0;
            }
            //计算报盘的状态
            $startTime = strtotime($info['start_time']);
            $now = time();
            $endTime = strtotime($info['end_time']);
            $info['order_status'] = 0;
            if($now<$startTime){
                $offerStatus=1;
            }elseif($now>=$startTime && $now<=$endTime){
                $offerStatus=2;
            }else{
                $offerStatus=3;
                //判断订单缴纳情况
                $dbObj = new \Library\M('order_sell');
                $order = $dbObj->where(array('offer_id'=>$id))->fields('contract_status,id')->getObj();
                if(!empty($order)){
                    if($order['contract_status']==3){
                        $info['order_status'] = 1;//待缴纳货款
                    }elseif($order['contract_status']==2){
                        $info['order_status'] = 2;//超时未缴纳货款
                    }else{
                        $info['order_status'] = 3;//已缴纳货款
                    }
                }
            }
            $info['status'] = $offerStatus;
            $info['attr'] = array();
            if(!empty($info['attr_arr'])){
                foreach($info['attr_arr'] as $key=>$item){
                    $info['attr'][] = array('name'=>$key,'value'=>$item);
                }
            }

            die(JSON::encode($info));
        }
    }

    public function baojiaDataAction(){
        $id = safe::filterGet('id','int');//报盘id
        //获取报价信息
        $baojiaData = $this->offer->baojiaData($id);
        $count = 0;
        if(!empty($baojiaData)){
            $temp = array();
            foreach($baojiaData as &$val){
                //计算报价的人数
                if(!in_array($val['user_id'],$temp)){
                    $temp[] = $val['user_id'];
                    $count++;
                }
                //隐藏真是名称
                if(!isset($this->login['user_id']) || $val['user_id']!=$this->login['user_id'])
                    $val['true_name'] = mb_substr($val['true_name'],0,1,'UTF-8').'*********';

            }
        }

        die(json_encode(array('data'=>$baojiaData,'count'=>$count)));
    }


    public function jingjiaDepositPageAction(){
        $graphql = new \nainai\graphqls();
        $user_id = isset($this->login['user_id']) ? $this->login['user_id']:0;
        $offer_id = safe::filterGet('id','int');
        $query = '{
                        user(id:'.$user_id.')
                        {
                        id,type,
                         bank(status:1){
                           bank_name,card_no,true_name
                         },
                        },
                        jingjia(id:'.$offer_id.'){
                            pro_name,jingjia_deposit,pay_days
                        }
                       
                   }';

        $data = $graphql->query($query);
        die(JSON::encode($data['data']));

    }


}