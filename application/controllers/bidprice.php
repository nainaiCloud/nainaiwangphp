<?php
/**
 * @author panduo
 * @desc 报盘列表offers
 * @date 2016-05-05 10:07:47
 */
use \tool\http;
use \Library\url;
use \Library\safe;
use \Library\tool;
use \nainai\order\Order;
use \Library\checkRight;


use \nainai\offer\product;

use \Library\JSON;

class BidpriceController extends PublicController {

	public function bidpriceListAction(){
        //获取商品顶级分类
        $productModel = new product();
        $category = $productModel->getTopCate();
        $this->getView()->assign('cate',$category);
		$this->getView()->assign('cur','bidprice');
	}
	public function biddetailsAction(){
		$this->getView()->assign('cur','bidprice');
	}
	public function bidbondAction(){
        $id = safe::filterGet('id','int');
	    if(!isset($this->login['user_id'])){
	        $callBack = url::createUrl('/bidprice/bidbond').'?id='.$id;
	        $redirect = url::createUrl('/login/login@user').'?callback='.$callBack;
	        $this->redirect($redirect);
        }
        \nainai\syslog::info("用户".$this->login['user_id']."打开竞价id为".$id."的保证金页面");
		$this->getView()->assign('cur','bidprice');
	}
	public function bidContractAction(){
		if(!isset($this->login['user_id'])){
	        $id = safe::filterGet('id','int');
	        $callBack = url::createUrl('/bidprice/bidContract').'?id='.$id;
	        $redirect = url::createUrl('/login/login@user').'?callback='.$callBack;
	        $this->redirect($redirect);
        }
		$this->getView()->setLayout('');
	}
	
}