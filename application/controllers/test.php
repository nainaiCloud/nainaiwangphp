<?php
/**
 * 交易中心不需要登录的控制器公共类
 */
use \Library\url;
use \nainai\offer\product;
use \nainai\sso\NNcas;
use \Library\tool;
use \Library\safe;
class TestController extends \Yaf\Controller_Abstract{


    public function indexAction(){

    }

    public function graphqlAction(){
        $query = '
              {
                        jingjia(id:16068){
                            pro_name,
                            max_num,accept_area,end_time,accept_area_code,
                            product{
                               produce_area,produce_address,note,unit,
                               attribute{
                                 name,value
                               }
                            }
                        }
                   }
        ';
        $graphqlObj = new \nainai\graphqls();
        $res = $graphqlObj->query($query);
        print_r($res);
    }


    public function jsMockAction(){
        if(IS_POST){
            $username = safe::filterPost('username');
            $amount = safe::filterPost('amount');
            $obj = new \nainai\fund\jsMock();
            $userObj = new \Library\M('user');
            $user_id = $userObj->where(array('username'=>$username))->getField('id');
            if(!$user_id){
                die(json_encode(tool::getSuccInfo(0,'用户不存在')));
            }
            $res = $obj->payMarket($user_id,$amount);
            if($res){
                die(json_encode(tool::getSuccInfo()));
            }else{
                die(json_encode(tool::getSuccInfo(0,'失败')));
            }
        }else{

        }

    }

    public function timeAction(){

    }

    public function getNowTimeAction(){
        echo time();exit;
    }



}