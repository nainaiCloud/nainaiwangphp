<?php
/*
出金审核操作类
author: wangzhande
Date:2016-5-6
 */
use Library\JSON;
use Library\safe;
use Library\tool;

class FundoutController extends InitController {
	public function init() {
		parent::init();
	}

	/**
	 * 出金待审核
	 */
	public function checkfundoutlistAction(){
		$condition = array('name' => '出金待审核', 'status' => fundOutModel::FUNDOUT_APPLY.','.fundOutModel::FUNDOUT_FIRST_OK);
		$condition['type'] = 'withdraw_request';
		$this->listData($condition);
	}

	/**
	 * 出金待拨款
	 */
	public function pendingpaymentlistAction(){
		$condition = array('name' => '出金待拨款', 'status' => fundOutModel::FUNDOUT_FINAL_OK);
		$condition['type'] = 'withdraw_request';
		$this->listData($condition);
	}

	/**
	 * 出金已审核
	 */
	public function checkedfundoutlistAction(){
		$condition = array('name' => '出金已审核', 'status' => fundOutModel::FUNDOUT_OK.','.fundOutModel::FUNDOUT_FIRST_NG.','.fundOutModel::FUNDOUT_FINAL_NG);
		$condition['type'] = 'withdraw_request';
		$this->listData($condition);
	}

	//出金列表
	public function listData($condition) {
		$fundOutModel = new fundOutModel();
		$data = $fundOutModel->getFundOutList($condition);

		$this->getView()->assign('data', $data);
	}

	//出金详情页
	public function fundOutEditAction() {
		$id = safe::filterGet('id', 'int');
		if(!$id) $id = intval($this->_request->getParam('id'));
		$fundOutModel = new fundOutModel();
		$data = $fundOutModel->fundOutDetail($id);
		$controllerName = $this->getRequest()->getControllerName();
		$moduleName = $this->getRequest()->getModuleName();
		$data['url'] = \Library\url::createUrl($moduleName . '/' . $controllerName . '/' . $data['action']);

		$data['proot'] = \Library\Thumb::get($data['proot'],180,180);
		$data['bank_proof'] = \Library\Thumb::get($data['bank_proof'],180,180);
		$this->getView()->assign('outInfo', $data);
	}
	//出金初审
	public function firstCheckAction() {
		if(IS_AJAX && IS_POST){
			$id = safe::filterPost('out_id', 'int');
			//if(!$id) $id = intval($this->_request->getParam('id'));
			$status = safe::filterPost('status', 'int');
			$message = safe::filterPost('message');
			$userName=safe::filterPost('user_name');
			$user_id=safe::filterPost('user_id','int');
			$fundOutModel = new fundOutModel();
			$res = $fundOutModel->fundOutFirst($id, $status, $message);
			if($res['code']==1){
				$adminmsg=new \nainai\AdminMsg();
				$adminmsg->setStatus($this,$id);
				if($status==1){
					$content='用户'.$userName.'有一笔提现需要终审';
					$adminmsg->createMsg('fundoutfinal',$id,$content);
				}else {
					$messObj=new \nainai\message($user_id);
					$messObj->send('fundOutFail');
				}
			}
			die(JSON::encode(tool::getSuccInfo($res['code'], $res['info'])));
		}

	}
	//出金终审
	public function finalCheckAction() {
		if(IS_AJAX && IS_POST){
			$id = safe::filterPost('out_id', 'int');
			$status = safe::filterPost('status', 'int');
			$message = safe::filterPost('message');
			$userName=safe::filterPost('user_name');
			$user_id=safe::filterPost('user_id','int');
			$fundOutModel = new fundOutModel();
			$res = $fundOutModel->fundOutFinal($id, $status, $message);
			if($res['code']==1){
				$adminmsg=new \nainai\AdminMsg();
				$adminmsg->setStatus($this,$id);
				if($status==1) {
					$content = '用户' . $userName . '有一笔提现需要打款';
					$adminmsg->createMsg('fundouttransfer', $id, $content);
				}else{
					$messObj=new \nainai\message($user_id);
					$messObj->send('fundOutFail');
				}
			}
			die(JSON::encode(tool::getSuccInfo($res['code'], $res['info'])));
		}

	}
	//上传凭证
	public function transferAction() {
		if(IS_AJAX && IS_POST){
			$id = safe::filterPost('out_id', 'int',0);
			$proof = safe::filterPost('imgfile2');
			$user_id=safe::filterPost('user_id');

			if(!$id || $proof==''){
				die(JSON::encode(tool::getSuccInfo(0,'请上传打款凭证'))) ;
			}

			$proof = tool::setImgApp($proof);
			$fundOutModel = new fundOutModel();
			$res = $fundOutModel->fundOutTransfer($id,$proof);
			if($res['code']==1){
				if($res['code']==1){
					$adminmsg=new \nainai\AdminMsg();
					$adminmsg->setStatus($this,$id);
					$messObj=new \nainai\message($user_id);
					$messObj->send('fundOutOk');
				}
			}
			die(JSON::encode(tool::getSuccInfo($res['code'], $res['info'])));
		}
	}

	public function delAction() {
		if(IS_AJAX && IS_POST) {
			$id = safe::filterGet('id', 'int');
			$fundOutModel = new fundOutModel();
			$res = $fundOutModel->logicDel($id);
			echo JSON::encode($res);
			return false;
		}
	}
	/**
	 * [upload ajax上传]
	 * @return    [type]      [description]
	 */
	public function uploadAction(){
        \nainai\syslog::info("管理员".$this->admin_id."上传操作开始");
		//调用文件上传类
		$photoObj = new \Library\photoupload();
		$photoObj->setThumbParams(array(180,180));
		$photo = current($photoObj->uploadPhoto());

		if($photo['flag'] == 1)
		{
            \nainai\syslog::info("管理员".$this->admin_id."上传成功,文件：".$photo['img']);
			$result = array(
				'flag'=> 1,
				'img' => $photo['img'],
				'thumb'=> $photo['thumb'][1]
			);
		}
		else
		{
            \nainai\syslog::info("管理员".$this->admin_id."上传失败".$photo['flag']."_".$photo['errInfo']);
			$result = array('flag'=> $photo['flag'],'error'=>$photo['errInfo']);
		}
		echo json::encode($result);

		return false;
	}

}
?>