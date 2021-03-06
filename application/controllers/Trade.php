<?php
/**
 *
 * @author panduo
 * @desc 报盘列表
 * @date 2016-05-05 10:07:47
 */
use \tool\http;
use \Library\url;
use \Library\safe;
use \Library\tool;
use \nainai\order;
use \Library\json;
use \Library\M;
class tradeController extends \nainai\controller\Base {
 
	private $offer;
    private $login ;
    private $order;
	protected $certType = 'deal';
	public function init(){
		parent::init();
        $right = new \Library\checkRight();
        $isLogin = $right->checkLogin();
        if($isLogin){
           $this->login = \Library\session::get('login');
           //获取未读消息
           $messObj=new \nainai\message($this->login['user_id']);
           $mess=$messObj->getCountMessage();
           $this->getView()->assign('mess',$mess);
           $this->getView()->assign('login',1);
           $this->getView()->assign('cert',$this->login['cert']);
           $this->getView()->assign('username',$this->login['username']);
        }else{
            $this->getView()->assign('login',0);
        }
		$this->getView()->setLayout('layout');
		$this->offer = new offersModel();
        $this->order = new orderModel();
	}

	public function createOrderAction(){
	    if(IS_POST) {
            $id = safe::filterPost('id', 'int',0);
            $num = safe::filterPost('num','float',0);
            $invoice = safe::filterPost('invoice','int',1);
            $invoice = $invoice==1 ? 1 : 0;
            $user_id = $this->user_id;
            $res = $this->order->createOneOrder($id, $num, $user_id,$invoice);
            die(json::encode($res));

        }


    }
	//付款
	public function buyerPayAction(){
	    return false;
		$id = safe::filterPost('id','int');
		$num = safe::filterPost('num');
		$paytype = safe::filterPost('paytype');
		$account = safe::filterPost('account');
		$invoice = safe::filterPost('invoice');

		$detail = $this->offer->offerDetail($id);
		if ($detail['user_id'] == $this->pid) {
			die(json::encode(tool::getSuccInfo(0,'子账户不能购买父账户发布的商品')));
		}

		$certObj=new \nainai\cert\certificate();
		$certStatus=$certObj->getCertStatus($detail['user_id'],'deal');
		if($certStatus['status']==4){
			$mess=new \nainai\message($detail['user_id']);
			$mess->send('credentials');
			die(json::encode(tool::getSuccInfo(0,'该商品的发布商家资质不够，暂时不能购买')));
		}
		$seller_id = $detail['user_id'];
		$offer_type = intval($detail['mode']);
		switch ($offer_type) {
			case order\Order::ORDER_FREE:
				//自由报盘
				$order_mode = new order\FreeOrder($offer_type);
				break;
			case order\Order::ORDER_DEPOSIT:
				//保证金报盘
				$order_mode = new order\DepositOrder($offer_type);
				break;
			case order\Order::ORDER_STORE:
				//仓单报盘
				$order_mode = new order\StoreOrder($offer_type);
				break;
			case order\Order::ORDER_ENTRUST:
				//仓单报盘
				$order_mode = new order\EntrustOrder($offer_type);
				break;
			default:
				die(json::encode(tool::getSuccInfo(0,'无效报盘方式')));
				break;
		}
		$order_submode = null;


		//判断用户账户类型
		if(in_array($offer_type,array(\nainai\order\Order::ORDER_STORE,\nainai\order\Order::ORDER_DEPOSIT))){
			switch ($account) {
				case \nainai\order\Order::PAYMENT_AGENT:
					//代理账户 直接余额扣款
					break;
				case \nainai\order\Order::PAYMENT_BANK:
					//签约账户
					break;
				case \nainai\order\Order::PAYMENT_TICKET:
					die(json::encode(tool::getSuccInfo(0,'票据账户支付暂时未开通，请选择其他支付方式')));

					break;
				default:
					die(json::encode(tool::getSuccInfo(0,'无效账户类型')));
					break;
			}
		}
		$user_id = $this->user_id;


		$orderData['payment'] = $account;
		$orderData['offer_id'] = $id;
		$orderData['num'] = $num;
		$orderData['order_no'] = tool::create_uuid();
		$orderData['user_id'] = $user_id;
		$orderData['create_time'] = date('Y-m-d H:i:s',time());
		$orderData['mode'] = $offer_type;
		
		//店铺id
		$shopInfo = \nainai\shop\shop::info($seller_id);
		$orderData['shop_id'] = isset($shopInfo['id']) ? $shopInfo['id'] : '';

		//设置保险信息到合同里面
		if ($detail['insurance'] == 1) {//投保产品
			$orderData['risk'] = $detail['risk'];
		}else {//申请投保
			$risk = new \nainai\insurance\RiskApply();
			$data = $risk->getRiskApply(array('buyer_id' => $user_id, 'offer_id' => $id, 'status' => $risk::APPLYOK), 'risk');
			if (!empty($data)) {
				$orderData['risk'] = $data['risk'];
			}
		}


		//判断是否需要开具发票
		$orderData['invoice'] = $invoice == 1 ? 1 : 0;

		//判断用户是否填写发票所需信息
		if($orderData['invoice']){
			$user_invoice = new \nainai\user\UserInvoice();
			$invoce_info = $user_invoice->userInvoiceInfo($user_id);
			if(empty($invoce_info)){
				die(json::encode(tool::getSuccInfo(0,'发票信息未完善',url::createUrl('/ucenter/invoice@user'))));
			}
		}


		$order = new M('order_sell');
		try {
			$order->beginTrans();

			//交易前的预处理，竞价判断购买用户是否是胜出用户
			if($detail['sub_mode']==1){
				$subModeObj = new \nainai\offer\jingjiaOffer();
				$condition = $subModeObj->beforeTrade($detail['id'],$this->user_id);
				if($condition['success']==0){
					$order->rollBack();
					die(json::encode($condition));
				}
				$order_submode = new \nainai\order\JingjiaOrder();
			}
			elseif($detail['sub_mode']==2){//一口价交易锁住报盘的一行，以防并发修改
				$subModeObj = new \nainai\offer\yikoujiaOffer();
				$condition = $subModeObj->beforeTrade($detail['id'],$this->user_id);
				if($condition['success']==0){
					$order->rollBack();
					die(json::encode($condition));
				}
			}

			$order_mode->setSubmode($order_submode);
			$gen_res = $order_mode->geneOrder($orderData);

			if($gen_res['success'] == 1){
				$order_id = $gen_res['order_id'];

				if($offer_type == order\Order::ORDER_FREE){

					$order->commit();
					
					$amount = $order->where(array('id'=>$order_id))->getfield('amount');
					$url = url::createUrl('/offers/paySuccess?id='.$order_id.'&order_no='.$orderData['order_no'].'&amount='.$amount.'&payed=0&info=等待上传线下支付凭证或线上支付');
					die(json::encode(tool::getSuccInfo(1,'操作成功,稍后跳转',$url)));
				}else{

					$zhi = new \nainai\member();
					$pay_secret = safe::filterPost('pay_secret');
					
					if(!$zhi->validPaymentPassword($pay_secret,$user_id)){
						die(json::encode(tool::getSuccInfo(0,'支付密码错误')));
					}
					$pay_res = $order_mode->buyerDeposit($gen_res['order_id'],$paytype,$user_id,$account);
					if($pay_res['success'] == 1){
						$order->commit();
						$url = url::createUrl('/offers/paySuccess?id='.$order_id.'&order_no='.$orderData['order_no'].'&amount='.$pay_res['amount'].'&payed='.$pay_res['pay_deposit']);
						die(json::encode(tool::getSuccInfo(1,'支付成功,稍后跳转',$url)));

					}else{
						$order->rollBack();
						die(json::encode(tool::getSuccInfo(0,'预付定金失败:'.$pay_res['info'])));

					}
				}
			}else{
				die(json::encode(tool::getSuccInfo(0,'生成订单失败:'.$gen_res['info'])));
			}
		} catch (\PDOException $e) {
			$order->rollBack();
			die(json::encode(tool::getSuccInfo(0,$e->getMessage())));
		}
		
		return false;
	}

	//支付页面
	public function checkAction(){
		$this->getView()->setLayout('layout2');

		$id = safe::filter($this->_request->getParam('id'),'int',1);

		$info = $this->offer->offerDetail($id);
		if(empty($info)){
			$this->error('报盘不存在或未通过审核');
		}
		if(time() > strtotime($info['expire_time'])){
			$this->error('报盘不存在或已过期');
		}

		if($info['divide']==\nainai\offer\product::UNDIVIDE ){//不可拆分
			$info['fixed'] = true;
			$info['minimum'] = $info['max_num'];
			$info['amount'] = $info['max_num'] * $info['price'];
		}
		else if($info['left'] <= $info['minimum']){//余量不够最小起订量
			$info['fixed'] = true;
			$info['minimum'] = $info['left'];
			$info['amount'] = $info['left'] * $info['price'];
		}
		else{//可拆分且余量大于起订量
			$info['fixed'] = false;
			$info['amount'] = $info['minimum'] * $info['price'];
		}

		$order_mode = new order\Order($info['mode']);
		$info['minimum_deposit'] = floatval($order_mode->payDepositCom($info['id'],$info['minimum']*$info['price']));
		$info['left_deposit'] = floatval($order_mode->payDepositCom($info['id'],$info['left']*$info['price']));

		$info['show_payment'] = in_array($info['mode'],array()) ? 1 : 0;
		//商品剩余数量
		$pro = new \nainai\offer\product();

		$info = array_merge($info,$pro->getProductDetails($info['product_id']));
        $info['is_vip'] = 0;
        $info['old_price'] = 0;
		if($this->login['cert']['vip']==1 || $this->login['cert']['vip_temp']==1){
		    $info['is_vip'] = 1;
            $info['old_price'] = $info['price'];
            $info['price'] = $info['price_vip'];

        }
		// echo '<pre>';var_dump($info);
		//判断下是否能够申请保险
		if($info['insurance'] == 0){
			//已经申请了的不能在申请
			$risk = new \nainai\insurance\RiskApply();
			$data = $risk->getRiskApply(array('buyer_id' => $this->user_id, 'offer_id' => $info['id']), 'id');
			if (!empty($data)) {
				$info['insurance'] = 1;
			}
		}

		//卖家资质
		$certObj = new \nainai\cert\certificate();
		$certStatus = $certObj->getCertStatus($info['user_id'],'deal');
		if($certStatus['status']==4){
			$mess = new \nainai\message($info['user_id']);
			$mess->send('credentials');
			$this->getView()->assign('no_cert',1);
		}else{
			$this->getView()->assign('no_cert',0);
		}

		$this->getView()->assign('user_id',$this->user_id ? $this->user_id : 0);
		$this->getView()->assign('data',$info);


	}

	/**
	 * 报价页面
	 */
	public function reportAction(){
		if($this->user_type==0){
			$this->error('个人用户不能报价');exit;
		}
		$id = $this->getRequest()->getParam('id');
		$id = Safe::filter($id, 'int');

		if (intval($id) > 0) {
			$PurchaseOfferModel = new \nainai\offer\PurchaseOffer();
			$offerDetail = $PurchaseOfferModel->getOfferProductDetailDeal($id);

			if(empty($offerDetail)){
				$this->error('采购不存在');exit;
			}

			$this->getView()->setLayout('');
			$this->getView()->assign('offer', $offerDetail[0]);
			$this->getView()->assign('product', $offerDetail[1]);
			$this->getView()->assign('user_id', $this->user_id ? $this->user_id : 0);
		}else{
			$this->error('未知的采购报盘!');
		}
		$this->getView()->setLayout('layout2');

	}


	/**
	 * 处理添加报价
	 */
	public function doreportAction(){
		if($this->user_type==0)
			die(json::encode(tool::getSuccInfo(0,'个人用户不能报价'))) ;
		if (IS_POST) {
			$Model = new \nainai\offer\PurchaseReport();
			$offer_id = safe::filterPost('id', 'int');
			$order = new \nainai\order\Order();
			$offer_info = $order->offerInfo($offer_id);
			$obj = new \nainai\offer\PurchaseOffer();
			$data = $obj->getPurchaseOffer($offer_id);


			if(empty($data)){
				die(json::encode(tool::getSuccInfo(0,'采购不存在!')));
				exit();
			}
			else if($data['user_id']==$this->user_id){
				die(json::encode(tool::getSuccInfo(0,'不能给自己的采购报价!')));exit();
			}
			else if($data['user_id']==$this->pid){
				die(json::encode(tool::getSuccInfo(0,'子账户不能报价父账户发布的商品!')));exit();
			}



			//判断是否已经添加过报价
			$res = $Model->getPurchaseReport(array('seller_id'=>$this->user_id, 'offer_id'=>$offer_id), 'id');
			if (!empty($res)) {
				die(json::encode(tool::getSuccInfo(0,'已报价，不要重复报价!')));
				exit();
			}
			$attrs = Safe::filterPost('attribute');

			$reportData = array(
				'offer_id' => $offer_id,
				'attr' => empty($attrs) ? '' : serialize($attrs),
				'produce_area' => safe::filterPost('area','int'),
				'price' => Safe::filterPost('price', 'float'),
				'create_time' => \Library\Time::getDateTime(),
				'seller_id' => $this->user_id,
				'status' => $Model::STATUS_APPLY
			);

			$res = $Model->addPurchaseReport($reportData);
			if($res['success'] == 1){
				$mess = new \nainai\message($offer_info['user_id']);
				$jump_url = "<a href='".url::createUrl('/Purchase/lists@user')."'>跳转到采购列表页</a>";
				$content = '您的采购：'.$offer_info['product_name'].',有新的报价。'.$jump_url;
				$mess->send('common',$content);
			}
			die(json::encode($res));
		}else{
			$this->error('错误的操作!');
		}
	}

	//用户是否设置支付密码
	public function hasPaySecretAction(){
		$pass = safe::filterPost('password');
		$member = new \nainai\member();
		die(json::encode(tool::getSuccInfo(1,(int)$member->validPaymentPassword($pass))));
	}


	//支付回调
    public function rechargeCallbackAction(){
        //从URL中获取支付方式
        $payment_id      = safe::filterGet('id', 'int');
        $paymentInstance = Payment::createPaymentInstance($payment_id);

        if(!is_object($paymentInstance))
        {
            die(json::encode(\Library\tool::getSuccInfo(0,'支付方式不存在')) ) ;
        }
        
        //初始化参数
        $money   = '';
        $message = '支付失败';
        $orderNo = '';
        
        //执行接口回调函数
        $callbackData = array_merge($_POST,$_GET);
        unset($callbackData['controller']);
        unset($callbackData['action']);
        unset($callbackData['_id']);
        $return = $paymentInstance->callback($callbackData,$payment_id,$money,$message,$orderNo);
        //支付成功
        if($return){
            $order_no = str_replace('recharge','',$orderNo);
            
            $rechargeObj = new M('recharge_order');
            $rechargeRow = $rechargeObj->getObj('order_no = "'.$order_no.'"');
            if(empty($rechargeRow))
            {
                //die(json::encode(\Library\tool::getSuccInfo(0,'充值失败')) ) ;
                $this->error('充值失败',url::createUrl("/fund/cz"));
            }
            $dataArray = array(
                'status' => 1,
            );
            
            $rechargeObj->data($dataArray);
            $result = $rechargeObj->data($dataArray)->where('order_no = "'.$order_no.'"')->update();
            
            if(!$result)
            {
                //die(json::encode(\Library\tool::getSuccInfo(0,'充值失败')) ) ;
                $this->error('充值失败',url::createUrl("/fund/cz"));
            }
            
            $money   = floatval($rechargeRow['amount']);
            $agenA = new \nainai\fund\agentAccount();
            $res = $agenA->in(intval($rechargeRow['user_id']), $money);
            if($res)
            {
				$userLog=new \Library\userLog();
				$userLog->addLog(['action'=>'充值操作','content'=>'充值了'.$money.'元']);
				$this->success('充值余额成功:'.$rechargeRow['amount'].'元',url::createUrl("/fund/cz"));
                // die(json::encode(\Library\tool::getSuccInfo(1,'充值成功',url::createUrl('/fund/doFundIn'))));
                exit;
            }
            //die(json::encode(\Library\tool::getSuccInfo(0,'充值失败')) ) ;
            $this->error('充值失败',url::createUrl("/fund/cz"));
        }
        else
        {
            //die(json::encode(\Library\tool::getSuccInfo(0,'充值失败')) ) ;
            $this->error('充值失败',url::createUrl("/fund/cz"));
        }
    }

	//竞价交易报价
	public function jingjiabaojiaAction()
	{
        $zhi = new \nainai\member();
        $pay_secret = safe::filterPost('pass');
        $user_id = $this->user_id;
        if(!$zhi->validPaymentPassword($pay_secret,$user_id)){
            die(json::encode(tool::getSuccInfo(0,'支付密码错误')));
        }

		$price = safe::filterPost('price','float');
		$offer_id = safe::filterPost('offer_id','int',0);

		$jingjiaObj = new \nainai\offer\jingjiaOffer();
		$res = $jingjiaObj->baojia($offer_id,$price,$user_id);
		die(json::encode($res));
	}

}