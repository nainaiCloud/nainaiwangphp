<?php
/*
入金审核
author  wzd
Date:2016/5/4
 */
use Library\adminrbac\rbac;
use Library\JSON;
use Library\M;
use Library\Query;
use Library\safe;
use nainai\fund;
use \Library\url;
use \Library\tool;

class FundinController extends InitController {


	public function init() {
		$this->getView()->setLayout('admin');
	}
	//线上列表
	public function onlineListAction() {
		$fundObj = new fundInModel();
		$condition = array('types' => fundInModel::DIRECT. ',' . fundInModel::UNION, 'name' => '线上列表', 'controller'=>'line');
		$condition['status'] = fundInModel::OFFLINE_APPLY.','.fundInModel::OFFLINE_FIRST_OK ;
		$condition['type'] = 'recharge_orderline';
		$this->listData($condition);
	}
	//线下待审核列表
	public function checkofflinelistAction() {
		$condition = array('types' => fundInModel::OFFLINE, 'name' => '线下待审核列表', 'controller'=>'off');
		$condition['status'] = fundInModel::OFFLINE_APPLY.','.fundInModel::OFFLINE_FIRST_OK ;
		$condition['type'] = 'recharge_orderoff';
		$this->listData($condition);
	}

	//线下已审核审核列表
	public function checkedofflinelistAction() {
		$condition = array('types' => fundInModel::OFFLINE, 'name' => '线下已审核审核列表', 'controller'=>'off');
		$condition['status'] =  fundInModel::OFFLINE_FIRST_NG . ','  . fundInModel::OFFLINE_FINAL_OK . ',' . fundInModel::OFFLINE_FINAL_NG ;
		$condition['type'] = 'recharge_orderoff';
		$this->listData($condition);
	}

	public function listData($condition=array()){
		$fundObj = new fundInModel();
		
		$data = $fundObj->getOnlineList($condition);

		$this->getView()->assign('data', $data);
	}
	
	//线下详情页
	public function offlineEditAction() {
		//判断当前用户有没有终审的权限
		$id = safe::filterGet('id', 'int');
		if(!$id) $id = intval($this->_request->getParam('id'));
		$fundObj = new fundInModel();
		$data = $fundObj->offLineDetail($id);

		$controllerName = $this->getRequest()->getControllerName();
		$moduleName = $this->getRequest()->getModuleName();
		$data['url'] = \Library\url::createUrl($moduleName.'/'.$controllerName.'/'.$data['action']);


		$this->getView()->assign('reInfo', $data);

	}
	//初审
	public function offlineFirstAction() {
		$id = safe::filterPost('re_id', 'int');
		$status = safe::filterPost('status', 'int');
		$mess  = safe::filterPost('message');
		$userName=safe::filterPost('user_name');
		$user_id=safe::filterPost('user_id','int');
		$fundObj = new fundInModel();

		$res = $fundObj->offLineFirst($id,$status,$mess);//初审操作
		if($res['success']==1) {
			$adminMsg = new \nainai\adminMsg();
			$content = '用户' . $userName . '有一笔入金需要终审';
			$adminMsg->setStatus($this, $id);
			$messObj=new \nainai\message($user_id);

			if ($status == 1) {
				$adminMsg->createMsg('fundinFinal', $id, $content);
			}else{
				$messObj->send('fundInFail');
			}
		}
		die(json::encode($res));
	}
	//终审
	public function offlineFinalAction() {
		$id = safe::filterPost('re_id', 'int');
		$status = safe::filterPost('status', 'int');
		$mess  = safe::filterPost('message');
		$user_id=safe::filterPost('user_id','int');
		$fundObj = new fundInModel();
		$res = $fundObj->offLineFinal($id,$status,$mess);//终审操作
		if($res['success']==1){
			$adminMsg = new \nainai\adminMsg();
			$adminMsg->setStatus($this,$id);
			$messObj=new \nainai\message($user_id);
			if($status==1){
				$messObj->send('fundInOk');
			}else{
				$messObj->send('fundInFail');
			}

		}
		die(json::encode($res));

	}

	/**
	 *
	 */
	public function delAction() {
		$id = safe::filterGet('id', 'int');

		$fundObj = new fundInModel();

		if($fundObj->logicDel($id)){

		}



	}


	public function bankflowlistAction(){
        $obj = new BankflowModel();
        $page = safe::filterGet('page','int',1);
        $data = $obj->getList($page);
        $this->getView()->assign('data',$data);
    }

    public function bankflowAddAction(){
        $obj = new BankflowModel();
	    if(IS_POST){
             $id = safe::filterPost('id','int');
             $data = array(
                 'OP_ACCT_NO_32'=> safe::filterPost('OP_ACCT_NO_32'),
                 'OP_CUST_NAME'=> safe::filterPost('OP_CUST_NAME'),
                 'TX_AMT'=> safe::filterPost('TX_AMT'),
                 'TX_LOG_NO'=> safe::filterPost('TX_LOG_NO'),
                 'img'  => safe::filterPost('img')
             );
             if($data['img']){
                 $data['img'] = tool::setImgApp($data['img']);
             }
             if($id){
                 $res = $obj->edit($id,$data);
             }else{
                 $res = $obj->add($data);
             }
            die(json::encode($res));
        }else{
	        $id = safe::filterGet('id');
	        $data = array();
	        if($id){

	            $data = $obj->get($id);

            }
            $this->getView()->assign('data',$data);
        }
    }

    public function bankflowDelAction(){
        $obj = new BankflowModel();
	    $id = safe::filterGet('id','int');
	    $res = $obj->delete($id);
	    die(json::encode($res));
    }

    public function bankSearchAction(){
	    $name = safe::filterGet('name');
	    $acc  = safe::filterGet('acc');
	    $data = array();
	    if($name || $acc){
	        $obj = new M('user_bank');
	        $where = "";
	        if($name){
	            $where .= " true_name like \"".$name."%\" ";
            }
            if($acc){
	            $where .= $where=="" ? " " : " and ";
	            $where .= " card_no like \"".$acc."%\" ";
            }
            $data = $obj->where($where)->fields('user_id,bank_name,card_no,true_name')->select();

        }
        die(json::encode($data));
    }
}

?>