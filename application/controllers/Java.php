<?php
/**
 * 交易中心不需要登录的控制器公共类
 */
use \Library\url;
use \Library\safe;
use \Library\tool;
use \Library\json;
use \nainai\order;
use \Library\M;
class JavaController extends \Yaf\Controller_Abstract{

     private $order;
     public function init(){
         $this->order = new orderModel();
     }

     public function createOrderAction(){
         $inputData = file_get_contents('php://input');
         $inputData = json::decode($inputData);
         $failRes = array();
         $offerNums = 0;
         foreach($inputData as $val){
             if(isset($val['id']) && isset($val['num']) && isset($val['user_id'])){
                 $offerNums += 1;
                 $res = $this->order->createOneOrder($val['id'],$val['num'],$val['user_id']);
                 if($res['success']==0){
                     $failRes=$res;
                 }
             }

         }
         //多于一个报盘，提示信息特殊处理
         if($offerNums>1){
             if(empty($failRes)){
                 $res['info'] = '所有报盘下单成功';
             }else{
                 $res['info'] = '部分报盘下单失败，原因为'.$res['info'].'请重新下单';
                 $res['time'] = 3;
            }
         }elseif($offerNums==0){
             $res = tool::getSuccInfo(0,'没有有效的报盘');
         }

         die(json::encode($res));


     }

     public function userInfoAction(){
         $mobile = safe::filterGet('mobile');
         \nainai\syslog::info("小程序开始关联，手机号：".$mobile);
         $obj = new indexModel();
         $data = $obj->userInfo($mobile);
         $res = json_encode($data,JSON_UNESCAPED_UNICODE);
         \nainai\syslog::info("手机号：".$mobile."关联信息为：".$res);
         die($res);
     }






}