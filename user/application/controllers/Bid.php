<?php
/**
 * 招投标管理
 * @author: weipinglee
 * @Date: 2017-06-9
 */
use \Library\M;
use \Library\json;
use \Library\session;
use \Library\url;
use \Library\Safe;
use \Library\Thumb;
use \Library\tool;
use \Library\PlUpload;
use \nainai\bid\buyerHandle;
use \nainai\bid\sellerHandle;

class BidController extends UcenterBaseController{

	private $bidObj = null;//招标对象

	private $bidObjSeller = null;//投标对象

	public function init()
	{
		parent::init(); // TODO: Change the autogenerated stub
		$this->bidObj = new buyerHandle($this->user_id);
		$this->bidObjSeller = new sellerHandle($this->user_id);
	}

	public function testAction(){
		$com = new \nainai\bid\comment\bidcomment();

	}

	/*********************招标发布相关功能***************************/
	public function setUserTruenameAction(){
		$Query = new \Library\Query('user as u');
		$Query->join = 'left join company_info as c on u.id = c.user_id
						 left join person_info as p on u.id = p.user_id';
		$Query->fields = ' u.id,u.type,u.username,u.mobile,c.company_name,p.true_name';
		$Query->limit = 10000;
		$data = $Query->find();
		$M = new \Library\M('user');
		$M->beginTrans();
		foreach($data as $val){
			if($val['type']==1){
				$M->data(array('true_name'=>$val['company_name']))->where(array('id'=>$val['id']))->update();
			}
			else{
				$M->data(array('true_name'=>$val['true_name']))->where(array('id'=>$val['id']))->update();
			}

		}
		$res = $M->commit();
		if($res)
			echo '成功';
		else echo '失败';

	}

	/**
	 * 获取邀请招标会员数据
	 */
	public function getYqUserAction()
	{
		if(IS_POST){
			$userObj = new M('user');
			$username = safe::filterPost('username');
			$where = 1;
			if($username)
				$where = 'username like "'.$username.'%"';
			$userData = $userObj->where($where)->fields('id,username,type,mobile,true_name')->order('username asc')->select();
			die(json::encode($userData));
		}



	}

	/**
	 * 邀请招标选择完用户点击确认的时候，通过post上传已选中用户的id列表
	 */
	public function addYqUserAction()
	{
		if(IS_POST){
			$user_list = safe::filterPost('user_list');//以逗号相隔的id
			$type = safe::filterPost('type');
			session::clear('yq_list');//清除旧的的用户id
			if($type=='yq'){
				session::set('yq_list',$user_list);
			}

			die(json::encode(tool::getSuccInfo(1,'提交成功',url::createUrl('/bid/tenderfb1').'?type='.$type)));
		}
	}

	/**
	 * 发布招标第一步，选择招标类型，邀请招标选择邀请用户
	 */
	public function tenderfbAction()
	{
		$userObj = new M('user');
		$username = safe::filterPost('username');
		$where = 1;
		if($username)
			$where = 'username like "'.$username.'%"';


		$userData = $userObj->where($where)->fields('id,username,type,mobile,true_name')->order('username asc')->select();
		$this->getView()->assign('user',$userData);
	}

	/**
	 * 发布招标第二步，上传招标文件
	 */
	public function tenderfb1Action()
	{
		$type = safe::filterGet('type');
		if($type!='yq'){
			$type='gk';
		}
		$this->getView()->assign('type',$type);
	}

	/**
	 * 发布招标第三步页面，填写招标具体内容
	 */
	public function tenderfb2Action()
	{
		//获取传过来的招标类型
		$type = safe::filterGet('type');
		if($type!='yq'){
			$type='gk';
		}
		$this->getView()->assign('type',$type);

		//获取标书地址
		$this->bidObj->setStateObj('bid');
		$res = $this->bidObj->uploadBid();
		if($res['flag']==1){
			$uploadSrc = $res['fileSrc'].'@user';
		}
		else{
			$this->redirect(url::createUrl('/bid/tenderfb1').'?type='.$type);
		}

		$this->getView()->assign('docSrc',$uploadSrc);

		//获取顶级分类
		$product = new \nainai\offer\product();
		$topCate = $product->getTopCate();
		$this->getView()->assign('topCate',$topCate);



	}

	/**
	 * 发布招标第三步保存，创建新的招标和包件
	 */
	public function createNewBidAction()
	{
		if(IS_POST){

			$bidData = array(
					'mode' => safe::filterPost('mode'),
					'user_id' => $this->user_id,
					'doc' => safe::filterPost('docsrc'),//标书地址
					'top_cate' => safe::filterPost('top_cate','int'),//市场分类
					'pro_name' => safe::filterPost('pro_name'),//项目名称
					'pro_address' => safe::filterPost('pro_address') ,//项目地址
					'begin_time'  => safe::filterPost('begin_time'),//开始时间
					'end_time'  => safe::filterPost('end_time'),//结束时间
					'open_time'  => safe::filterPost('open_time'),//开标时间
					'bid_require'  => safe::filterPost('bid_require'),//招标条件
					'pro_brief'  => safe::filterPost('pro_brief'),//项目简介
					'bid_content'  => safe::filterPost('bid_content'),//招标内容
					'pack_type'  => safe::filterPost('pack_type'),//包件类型，1：分包、2：总包
					'eq'  		 => serialize(safe::filterPost('eq')),//投标企业资质，多条数据序列化
					'doc_begin'  => safe::filterPost('doc_begin'),//标书销售开始时间
					'doc_price'  => safe::filterPost('doc_price') ,//标书价格
					'supply_bail' => safe::filterPost('supply_bail') ,//供方保证金
					'open_way'   => safe::filterPost('open_way'),//开标方式
					'pay_way' => implode(',',safe::filterPost('pay_way')) ,//多种支付方式已逗号相隔
					'other'  => safe::filterPost('other') ,//其他事项
					'bid_person'  => safe::filterPost('bid_person'),//招标人
					'cont_person'  => safe::filterPost('cont_person'),//联系人
					'cont_email'   => safe::filterPost('cont_email'),//联系邮箱
					'cont_address' => safe::filterPost('cont_address') ,//联系地址
					'cont_phone'  => safe::filterPost('cont_phone'),//联系电话
					'cont_tax' => safe::filterPost('cont_tax') ,//联系传真
					'agent' => safe::filterPost('agent'),//代理机构
					'agent_person'  => safe::filterPost('agent_person'),//代理联系人
					'agent_address'  => safe::filterPost('agent_address'),//代理地址
					'agent_email'  => safe::filterPost('agent_email') ,//代理邮箱
					'agent_phone' => safe::filterPost('agent_phone') ,//代理电话
					'agent_tax'   => safe::filterPost('agent_tax'),//代理传真
			);

			$bidData['yq_user'] = session::get('yq_list') ? session::get('yq_list') : '';

			$package = array(
				'pack_no' => safe::filterPost('pack_no'),
				'product_name' => safe::filterPost('product_name'),
				'brand' => safe::filterPost('brand'),
					'spec' => safe::filterPost('spec'),
					'tech_need' => safe::filterPost('tech_need'),
					'unit' => safe::filterPost('unit'),
					'num' => safe::filterPost('num'),
					'tran_days' => safe::filterPost('tran_days')
			);
			$bidData['package'] = array();
			foreach($package as $key=>$item){
				foreach($item as $k=>$v){
					$bidData['package'][$k][$key] = $v;
				}
			}
			 $this->bidObj->setStateObj('bid');
			$res = $this->bidObj->init($bidData);
			if($res['success']==1){
				session::clear('yq_list');
				$res['info'] = '操作成功';
				$res['returnUrl'] = url::createUrl('/bid/tenderfb3').'?id='.$res['id'];
			}
			die(json::encode($res));


		}
	}

	/**
	 * 发布招标第四步，通过id参数获取保存成功的招标信息
	 */
	public function tenderfb3Action()
	{
		$id = safe::filterGet('id','int');
		$detail = $this->bidObj->getBidDetail($id);

		$this->getView()->assign('data',$detail);
	}

	/**
	 * 发布招标，扣除保证金
	 */
	public function bidReleaseAction()
	{
		if(IS_POST){
			$bid_id = safe::filterPost('bid_id','int');
			$bidObj = $this->bidObj;
			$bidObj->setStateObj('bid',$bid_id);
			$pay_type = safe::filterPost('pay_type','int',1);
			$res = $bidObj->release($pay_type);
			if($res['success']==1)
				$res['returnUrl'] = url::createUrl('/bid/tenderfb4');
			die(json::encode($res));
		}

	}

	public function tenderfb4Action(){

	}

	/**
	 * 撤销招标
	 */
	public function cancleBidAction()
	{
		if(IS_POST){
			$bid_id = safe::filterPost('bid_id','int');
			$bidObj = $this->bidObj;
			$bidObj->setStateObj('bid',$bid_id);

			$res = $bidObj->bidCancle();
			die(json::encode($res));
		}
	}

	public function closeBidAction(){
		if(IS_POST){
			$bid_id = safe::filterPost('bid_id','int');
			$bidObj = $this->bidObj;
			$bidObj->setStateObj('bid',$bid_id);

			$res = $bidObj->bidClose();
			die(json::encode($res));
		}
	}



	/**
	 * 添加补充公告接口
	 */
	public function addBidNoticeAction(){
		if(IS_POST){
			$bid_id = safe::filterPost('bid_id','int');
			$title = safe::filterPost('title');
			$content = safe::filterPost('content');
			$this->bidObj->setStateObj('bid',$bid_id);
			$res = $this->bidObj->addBidNotice($title,$content);
			die(json::encode($res));
		}
	}




/*********************招标列表和详情相关***************************/


	/**
	 * 招标列表
	 */
	public function getBidListAction()
	{
		$page = safe::filterGet('page','int',1);
		$bidObj = $this->bidObj;
		$list = $bidObj->getBidList($page);//print_r($list);
		$this->getView()->assign('data',$list);
		//$this->getView()->assign('list',$list);
	}

	public function updateBidDetailAction()
	{
		$id = safe::filterGet('id','int');
		$detail = $this->bidObj->getBidDetail($id);
		$this->getView()->assign('detail',$detail);
	}

	public function getBidDetailAction()
	{
		$id = safe::filterGet('id','int');
		$detail = $this->bidObj->getBidDetail($id);
		$this->getView()->assign('detail',$detail);

		switch($detail['status']){
			case 0 :
			case 1 :
			case 4 :
			case 5:
			case 3 :{//跳转1
				$this->redirect(url::createUrl('/bid/tenderdetail').'?id='.$id);
			}
			break;
			case 2 : {//跳转2
				$this->redirect(url::createUrl('/bid/tenderdetail1').'?id='.$id);
			}
			break;
			case 6 : {//跳转3
				$this->redirect(url::createUrl('/bid/tenderdetail2').'?id='.$id);
			}
			break;
			case 7 : {
				$this->redirect(url::createUrl('/bid/tenderdetail3').'?id='.$id);
			}


		}
	}

	/**
	 * 招标详情第一步，未发布时显示
	 */
	public function tenderDetailAction(){
		$id = safe::filterGet('id','int');
		$detail = $this->bidObj->getBidDetail($id);
		$this->getView()->assign('detail',$detail);

	}

	public function tenderDetail1Action(){
		$id = safe::filterGet('id','int');
		$detail = $this->bidObj->getBidDetail($id);
		$this->getView()->assign('detail',$detail);

		//获取补充公告
		$bidObj = $this->bidObj;
		$notice = $bidObj->getBidNotice($id);
		$this->getView()->assign('notice',$notice);
		//获取投标信息
		$page = safe::filterGet('page','int',1);
		$replyList = $this->bidObj->getReplyList($id,$page);
		$this->getView()->assign('replyList',$replyList);
	}

	/**
	 * 查看投标方资质
	 */
	public function viewpaperAction()
	{
		$id = safe::filterGet('id','int');//投标id
		$certs = $this->bidObj->getReplyCerts($id);
		$this->getView()->assign('certs',$certs);

	}

	public function tenderDetail2Action(){
		$id = safe::filterGet('id','int');
		$detail = $this->bidObj->getBidDetail($id);
		$this->getView()->assign('detail',$detail);

		//获取各个包件投标信息
		$packList = $this->bidObj->getReplyPackList($id);
		$pack = array();
		if(!empty($packList)){
			foreach($packList as $key=>$val){
				$pack[$val['pack_no']][] = $val;
			}
		}

		$this->getView()->assign('packlist',$pack);


	}

	public function packCompareAction()
	{
		$this->getView()->setLayout('');
		$pack_id = safe::filterGet('pack_id');
		$pack_ids = implode(',',$pack_id);//组成以逗号相隔的数据
		if($pack_ids=='')
			$pack_ids=0;
		$packList = $this->bidObj->getPackCompareList($pack_ids);
		$this->getView()->assign('packlist',$packList);


	}

	/**
	 * 评论招标
	 */
	public function addCommentAction()
	{
		if(IS_POST){
			$bid_id = safe::filterPost('bid_id','int');
			$content = safe::filterPost('content');
			$this->bidObjSeller->setStateObj('bid',$bid_id);
			$res = $this->bidObjSeller->bidComment($content,$this->user_id);
			die(json::encode($res));
		}

	}

	/**
	 * 未中标的用户退还保证金
	 */
	public function rebackBailAction()
	{
		if(IS_POST){
			$bid_id = safe::filterPost('bid_id','int');
			$this->bidObj->setStateObj('bid',$bid_id);
			$res = $this->bidObj->rebackReplyBail($bid_id);
			die(json::encode($res));
		}
	}


	/****************************投标发布*********************/

	public function tbListAction()
	{
		$page = safe::filterGet('page','int',1);
		$data = $this->bidObjSeller->getReplyList($page);

		$this->getView()->assign('data',$data);
	}


	public function tbDetailAction()
	{
		$id = safe::filterGet('id','int');
		$data = $this->bidObjSeller->getReplyDetail($id);
		if($data['bid_status']==7 || $data['bid_status']==8){
			$this->redirect(url::createUrl('/bid/bidOper5').'?reply_id='.$id);
			exit;
		}

		switch($data['status']){
			case 1 :
			case 2 :
			case 4 :{//跳转到第1
				$this->redirect(url::createUrl('/bid/bidOper').'?id='.$data['bid_id']);
			}
			break;
			case 3 : {//跳转到2
				$this->redirect(url::createUrl('/bid/bidOper2').'?reply_id='.$id);
			}
			break;
			case 6 :
			case 5 :{//跳转到3
			$this->redirect(url::createUrl('/bid/bidOper3').'?reply_id='.$id);
			}
			break;
			case 7 :  {//跳转到4
				$this->redirect(url::createUrl('/bid/bidOper4').'?reply_id='.$id);
			}
		}
	}


	/**
	 * 投标第一步页面
	 */
	public function bidOperAction()
	{
		//招标详情
		$bid_id = safe::filterGet('id','int');
		if($bid_id){
			$bidDetail = $this->bidObjSeller->getBidDetail($bid_id);
			$this->getView()->assign('detail',$bidDetail);

			//判断是否可投标
			if($bidDetail['mode']=='yq' && !in_array($this->user_id,explode(',',$bidDetail['yq_user']))){
				$this->error('您未被邀请，不能投标',url::createUrl('/bid/tendercontent@deal').'?id='.$bid_id);

			}

			//证书信息
			$certs = $this->bidObjSeller->getUserReplyCerts($this->user_id,$bid_id);
			$certHasSubmit = 0;
			if(!empty($certs) && $certs[0]['status']==2){
				$certHasSubmit = 1;
			}

			$this->getView()->assign('certHasSubmit',$certHasSubmit);
			$this->getView()->assign('certs',$certs);
		}


	}

	/**
	 * 删除证书接口
	 */
	public function delCertAction()
	{
		$cert_id = safe::filterPost('cert_id','int');
		$reply_id = safe::filterPost('reply_id','int');
		$bid_id = safe::filterPost('bid_id','int');
		$this->bidObjSeller->setStateObj('reply',$reply_id);
		$res = $this->bidObjSeller->replyCertDel($cert_id,$reply_id);
		$res['returnUrl'] = url::createUrl('/bid/bidOper').'?id='.$bid_id;
		die(json::encode($res));

	}

	public function bidOper1Action(){
		$bid_id = safe::filterGet('id','int');
		$bidDetail = $this->bidObjSeller->getBidDetail($bid_id);
		$this->getView()->assign('detail',$bidDetail);
	}

	/**
	 * 上传资质证书
	 */
	public function uploadCertsAction(){
		if(IS_POST){
			$bid_id = safe::filterPost('id','int');
			$certs = array(
					'cert_name' => safe::filterPost('name'),
					'cert_type'=> safe::filterPost('type'),
					'cert_des' => safe::filterPost('des'),
					//'cert_pic' => safe::filterPost('pic'),
			);
			$photo = new \Library\photoupload();
			$res = $photo->uploadPhoto();
			if($res['pic']['flag']==1){
				$certs['cert_pic'] = $res['pic']['img'].'@user';
			}
			else{
				$this->redirect(url::createUrl('/bid/bidOper1').'?error='.$res['pic']['errInfo']);
			}
			$this->bidObjSeller->setStateObj('bid',$bid_id);
			$res = $this->bidObjSeller->replyUploadCerts($this->user_id,$certs);
			if($res['success']==1){
				$this->redirect(url::createUrl('/bid/bidOper').'?id='.$bid_id);
			}
			else{
				$this->redirect(url::createUrl('/bid/bidOper1').'?error='.$res['info']);
			}

		}
	}

	/**
	 * 提交证书进行审核
	 */
	public function submitCertAction(){
		if(IS_POST){
			$reply_id = safe::filterPost('id','int');//投标id

			$this->bidObjSeller->setStateObj('reply',$reply_id);
			$res = $this->bidObjSeller->replySubmitCert();
			die(json::encode($res));
		}

	}

	/**
	 * 投标资质审核
	 */
	public function replyCertsVerifyAction(){
		if(IS_POST){
			$reply_id = safe::filterPost('reply_id','int');
			$status = safe::filterPost('status','int',0);
			$this->bidObj->setStateObj('reply',$reply_id);
			$res = $this->bidObj->replyCertsVerify($status);

			die(json::encode($res));
		}
	}

	/**
	 * 支付标书费用页面
	 */
	public function bidOper2Action()
	{
		//$bid_id = safe::filterGet('id','int');
		$reply_id = safe::filterGet('reply_id','int');
		$M = new M('bid_reply');
		$bid_id = $M->where(array('id'=>$reply_id))->getField('bid_id');
		$bidDetail = $this->bidObjSeller->getBidDetail($bid_id);
		$this->getView()->assign('detail',$bidDetail);
		$this->getView()->assign('bid_id',$bid_id);
		$this->getView()->assign('reply_id',$reply_id);


	}


	public function replyPayDocAction()
	{
		if(IS_POST){
			$reply_id = safe::filterPost('reply_id','int');

			$this->bidObjSeller->setStateObj('reply',$reply_id);
			$pay_type  = 1;
			$res = $this->bidObjSeller->replyPaydocFee($pay_type);
			$res['returnUrl'] = url::createUrl('/bid/bidOper3').'?reply_id='.$reply_id;
			die(json::encode($res));

		}


	}

	public function bidOper3Action()
	{
		$reply_id = safe::filterGet('reply_id','int');
		$M = new M('bid_reply');
		$bid_id = $M->where(array('id'=>$reply_id))->getField('bid_id');
		$bidDetail = $this->bidObjSeller->getBidDetail($bid_id);

		$replyDetail = $this->bidObjSeller->getReplyDetail($reply_id);

		$this->getView()->assign('detail',$bidDetail);
		$this->getView()->assign('reply',$replyDetail);
		$this->getView()->assign('bid_id',$bid_id);
		$this->getView()->assign('reply_id',$reply_id);
	}


	public function ajaxUploadDocAction(){
		$uploadObj = new \Library\upload\commonUpload();
		$res = $uploadObj->upload();
		$res['doc']['src'] = tool::setImgApp($res['doc']['src']);
		die(json::encode($res['doc']));
	}

	/**
	 * 上传投标书兼报价
	 */
	public function replyGivePriceAction()
	{
		if(IS_POST){
			$reply_id = safe::filterPost('reply_id','int');

			$package = array(
					'pack_id' => safe::filterPost('pack_id','int'),
					'pack_no' => safe::filterPost('pack_no'),
					'brand' => safe::filterPost('brand'),
					'unit_price' => safe::filterPost('unit_price'),
					'freight_fee' => safe::filterPost('freight_fee'),
					'tran_days' => safe::filterPost('tran_days'),
					'note' => safe::filterPost('note'),
					'quanlity' => safe::filterPost('quanlity'),
					'deliver' => safe::filterPost('deliver','int',1)
			);
			$data = array();
			foreach($package as $key=>$item){
				foreach($item as $k=>$v){
					$data[$k][$key] = $v;
				}
			}

			$upload = safe::filterPost('doc1');
			$this->bidObjSeller->setStateObj('reply',$reply_id);
			$res = $this->bidObjSeller->replySubmitPackage($data,$upload);
			die(json::encode($res));
		}
	}

	public function bidOper4Action(){
		$reply_id = safe::filterGet('reply_id','int');
		$M = new M('bid_reply');
		$bid_id = $M->where(array('id'=>$reply_id))->getField('bid_id');
		$bidDetail = $this->bidObjSeller->getBidDetail($bid_id);

		$this->getView()->assign('reply_id',$reply_id);
		$this->getView()->assign('detail',$bidDetail);
	}

	public function bidOper5Action(){
		$reply_id = safe::filterGet('reply_id','int');
		$M = new M('bid_reply');
		$bid_id = $M->where(array('id'=>$reply_id))->getField('bid_id');
		$bidDetail = $this->bidObjSeller->getBidDetail($bid_id);
		$this->getView()->assign('reply_id',$reply_id);
		$this->getView()->assign('detail',$bidDetail);

		$zbInfo = $this->bidObjSeller->getZbInfo($bid_id,$this->user_id);
		$this->getView()->assign('zbinfo',$zbInfo);

	}




	/***********************截标评标********************************/

	public function stopBidAction()
	{
		if(IS_POST){
			$bid_id = safe::filterPost('bid_id','int');
			$this->bidObj->setStateObj('bid',$bid_id);
			$res = $this->bidObj->bidStop();
			die(json::encode($res));
		}

	}

	public function pingbiaojsAction()
	{
		if(IS_POST){
			$status = safe::filterPost('status','int');//1：评标结束，0：项目流标
			$bid_id = safe::filterPost('bid_id','int');
			$this->bidObj->setStateObj('bid',$bid_id);
			$res = $this->bidObj->pbClose($status);
			die(json::encode($res));

		}
	}

	public function pingbiaoAction(){
		if(IS_POST){
			$id = safe::filterPost('reply_pack_id','int');
			$point = array(
					'zz'=>safe::filterPost('zz'),
					'js'=>safe::filterPost('js'),
					'sw'=>safe::filterPost('sw')
			);
			$bid_id = safe::filterPost('bid_id');
			$status = safe::filterPost('status');
			$this->bidObj->setStateObj('bid',$bid_id);
			$res = $this->bidObj->pingbiao($id,$point,$status);
			die(json::encode($res));
		}
	}

	/**
	 * 中标信息
	 */
	public function tenderDetail3Action(){
		$id = safe::filterGet('id','int');
		$detail = $this->bidObj->getBidDetail($id);
		$this->getView()->assign('detail',$detail);

		//获取各个包件中标信息
		$zbInfo = $this->bidObj->getZbUser($id);
		$this->getView()->assign('zbinfo',$zbInfo);


	}








}