<?php
/*
出金管理
author :wangzhande
Date :2015/5/6
 */
use Library\M;
use Library\Query;
use Library\tool;
use \admintool\adminQuery;
class fundOutModel {

	CONST FUNDOUT_APPLY = 0;
	CONST FUNDOUT_FIRST_OK = 2;//初审通过
	CONST FUNDOUT_FIRST_NG = 3;//初审驳回
	CONST FUNDOUT_FINAL_OK = 5;//终审通过
	CONST FUNDOUT_FINAL_NG = 4;//终审驳回
	CONST FUNDOUT_OK = 1;//出金完成

	private $hintCode = array(
		'outWrong' => array('code' => 0, 'info' => '操作错误'),
		'freezeLess' => array('code' => 0, 'info' => '冻结金额不足'),
		'outOk' => array('code' => 1, 'info' => '操作成功'),
	);
	public function getFundOutList($condition) {
		$fundOut = new adminQuery('withdraw_request as w');

		$fundOut->join = 'left join user as u on w.user_id = u.id';
		$fundOut->fields = 'w.request_no,w.amount,w.status,w.create_time,u.username,u.mobile,u.type,w.id,u.user_no';

		if(isset($condition['status']))
			$fundOut->where = ' w.is_del = 0 and w.status in ('.$condition['status'].')';
		else
			$fundOut->where = ' w.is_del = 0';

		$outInfo = $fundOut->find();
		
		foreach ($outInfo['list'] as $key => &$value) {
			$value['status_text'] = $this->getFundOutStatustext($value['status']);
		}

		$fundOut->downExcel($outInfo['list'],$condition['type'], $condition['name']);

		return $outInfo;
	}

	public function getCheckedFundOutList($page=1){
		$fundOut=new adminQuery('withdraw_request as w');
		$fundOut->join='left join user as u on w.user_id=u.id';
		$fundOut->fields='w.request_no,w.amount,w.status,w.create_time,u.username,u.mobile,u.type,w.id';
		$status="'".self::FUNDOUT_OK.','.self::FUNDOUT_FINAL_NG.','.self::FUNDOUT_FIRST_NG."'";
		$fundOut->where='is_del=0 and find_in_set(w.status,'.$status.')';
		$fundOut->page=$page;
		$checkedInfo=$fundOut->find();
		return [$checkedInfo,$fundOut->getPageBar()];
	}

	public function getPendingPaymentList($page=1){
		$fundOut=new adminQuery('withdraw_request as w');
		$fundOut->join='left join user as u on w.user_id=u.id';
		$fundOut->fields='w.request_no,w.amount,w.status,w.create_time,u.username,u.mobile,u.type,w.id';
		$fundOut->where='is_del=0 and w.status='.self::FUNDOUT_FINAL_OK;
		$fundOut->page=$page;
		$pendInfo=$fundOut->find();
		return $pendInfo;
	}
	public static function getFundOutStatustext($status) {
		switch (intval($status)) {
			case self::FUNDOUT_APPLY:{
					return "申请提现";
				}
				break;
			case self::FUNDOUT_FIRST_OK:{
					return "初审通过";
				}
				break;
			case self::FUNDOUT_FIRST_NG:{
					return "初审驳回";
				}break;
			case self::FUNDOUT_FINAL_OK:{
					return "终审通过，待打款";
				}break;
			case self::FUNDOUT_FINAL_NG:{
					return "终审驳回";
				}break;
			case self::FUNDOUT_OK:{
					return "出金完成";
					break;
				}
			default:{
					return "未知";
				}
				break;

		}

	}
	//提现详情
	public function fundOutDetail($rid) {
		$fundOut = new Query('withdraw_request as w');
		$fundOut->join = 'left join user as u on u.id=w.user_id left join user_bank as b on u.id=b.user_id';
		$fundOut->fields = 'u.username,u.mobile,w.*,b.true_name,b.bank_name,b.card_no,b.proof as bank_proof';
		$fundOut->where = 'w.id= :id';
		$fundOut->bind = array('id' => $rid);
		$data = $fundOut->getObj();

		$data['statusText'] = self::getFundOutStatustext($data['status']);
		//获取审核提交的方法
		$data['action'] = '';
		if ($data['status'] == self::FUNDOUT_APPLY) {
			$data['action'] = 'firstCheck';
		} else if ($data['status'] == self::FUNDOUT_FIRST_OK) {
			$data['action'] = 'finalCheck';
		} else if ($data['status'] == self::FUNDOUT_FINAL_OK) {
			$data['action'] = 'transfer';
		}

		return $data;

	}
	//出金初审
	public function fundOutFirst($wid, $status, $mess = '') {
		$fundOut = new M('withdraw_request');
		$where = array('id' => $wid);
		$reInfo = $fundOut->where($where)->getObj();
		//只有处于申请状态的才可以
		if ($reInfo['status'] == self::FUNDOUT_APPLY) {

			$data = array();
			$fundModel = \nainai\fund::createFund(1);
			if ($status == 1) {

				//获取冻结资金
				$userFund = $fundModel->getFreeze($reInfo['user_id']);
				if ($userFund != 0 && $userFund - $reInfo['amount'] >= 0) {
					$data['status'] = self::FUNDOUT_FIRST_OK;
				} else {
					return $this->hintCode['freezeLess'];
				}

			} else {
				$data['status'] = self::FUNDOUT_FIRST_NG;
				$fundModel->freezeRelease($reInfo['user_id'],$reInfo['amount'],$reInfo['request_no'].'出金初审被驳回');

			}
			$data['first_time'] = \Library\Time::getDateTime();
			$data['first_message'] = $mess;
			$fundOut->beginTrans();
			if ($fundOut->where($where)->data($data)->update()) {
				$log = new \Library\log();
				$log->addLog(array('table'=>'withdraw_request','type'=>'check','field'=>'request_no','id'=>$wid,'check_text'=>$this->getFundOutStatustext($data['status'])));
				if($fundOut->commit()){
					return $this->hintCode['outOk'];
				}
				else{
					return $this->hintCode['outWrong'];
				}

			} else {

				return $this->hintCode['outWrong'];
			}

		} else {

			return $this->hintCode['outWrong'];
		}
	}
	//出金终审
	public function fundOutFinal($wid, $status, $mess = '') {
		$fundOut = new M('withdraw_request');
		$where = array('id' => $wid);
		$reInfo = $fundOut->where($where)->getObj();
		//只有处于初审通过才可以
		if ($reInfo['status'] == self::FUNDOUT_FIRST_OK) {
			$data = array();
			$data['final_time'] = \Library\Time::getDateTime();
			$data['final_message'] = $mess;
			$fundModel = \nainai\fund::createFund(1);
			if ($status == 1) {

				//获取冻结资金
				$userFund = $fundModel->getFreeze($reInfo['user_id']);
				if ($userFund != 0 && $userFund - $reInfo['amount'] >= 0) {
					$data['status'] = self::FUNDOUT_FINAL_OK;
				} else {
					return $this->hintCode['freezeLess'];
				}

			} else {
				$data['status'] = self::FUNDOUT_FINAL_NG;
				$fundModel->freezeRelease($reInfo['user_id'],$reInfo['amount'],$reInfo['request_no'].'出金终审被驳回');
			}
			$fundOut->beginTrans();
			if ($fundOut->where($where)->data($data)->update()) {
				$log = new \Library\log();
				$log->addLog(array('table'=>'withdraw_request','type'=>'check','field'=>'request_no','id'=>$wid,'check_text'=>$this->getFundOutStatustext($data['status'])));
				if($fundOut->commit()){
					return $this->hintCode['outOk'];
				}
				else
					return $this->hintCode['outWrong'];

			} else {
				return $this->hintCode['outWrong'];
			}

		} else {
			return $this->hintCode['outWrong'];
		}
	}

	/**
	 * 上传打款凭证
	 * @param $wid
	 * @param $proof
	 * @return mixed
	 */
	public function fundOutTransfer($wid,$proof) {
		$fundOut = new M('withdraw_request');
		$where = array('id' => $wid);

		$userData = $fundOut->where($where)->getObj();//提现总金额

		if($userData['status']==self::FUNDOUT_FINAL_OK){
			$data = array(
				'proot' => $proof,
				'status' => self::FUNDOUT_OK,
			);

			$fundOut->beginTrans();

			if ($fundOut->where($where)->data($data)->update()) {

				$fund = \nainai\fund::createFund(1);
				$res = $fund->out($userData['user_id'],floatval($userData['amount']),$userData['request_no'].'提现成功');
				if(true===$res){
                    $log = new \Library\log();
                    $log->addLog(array('table'=>'withdraw_request','type'=>'check','field'=>'request_no','id'=>$wid,'check_text'=>$this->getFundOutStatustext($data['status'])));

                    if(true===$fundOut->commit()){
                        return $this->hintCode['outOk'];
                    }
                }else{
                    $fundOut->rollBack();
				    return $res;
                }



			}
			$fundOut->rollBack();
		}

		return $this->hintCode['outWrong'];
	}
	/**
	 * 逻辑删除
	 * @param $id
	 *
	 */
	public function logicDel($id) {
		$reModel = new M('withdraw_request');
		$where = array('id' => $id);

		if ($reModel->data(array('is_del' => 1))->where($where)->update()) {
			return $this->hintCode['outOk'];
		} else {
			return $this->hintCode['outWrong'];
		}

	}

}

?>