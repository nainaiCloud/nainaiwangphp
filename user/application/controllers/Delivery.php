<?php 

/**
 * 提货
 */
use \Library\safe;
use \Library\tool;
use \Library\JSON;
use \Library\url;
use \Library\checkRight;

class DeliveryController extends UcenterBaseController {


    //提货页面
    public function newDeliveryAction(){
        $order_id = safe::filter($this->_request->getParam('order_id'));

        $delivery = new \nainai\delivery\Delivery();

        //获取此订单可以提取货物数量
        $left = $delivery->orderNumLeft($order_id,false);//返回数值
        if(!is_float($left)){
            //报错
            $this->error($left);exit;
        }
        
        $info = $delivery->deliveryStore($order_id);
        $info['left'] = $left;
        $this->getView()->assign('data',$info);
    }

    //生成提货表
    public function geneDeliveryAction(){
        $deliveryData['order_id'] = safe::filterPost('order_id','int');
        $deliveryData['num'] = safe::filterPost('num');
        $deliveryData['delivery_man'] = safe::filterPost('delivery_man');
        $deliveryData['phone'] = safe::filterPost('phone');
        $deliveryData['idcard'] = safe::filterPost('idcard');
        $deliveryData['plate_number'] = safe::filterPost('plate_number');
        $deliveryData['expect_time'] = date('Y-m-d H:i:s',strtotime(safe::filterPost('expect_time')));
        $deliveryData['remark'] = safe::filterPost('remark');

        $deliveryData['user_id'] = $this->user_id;

        $delivery = new \nainai\delivery\Delivery();
        $res = $delivery->geneDelivery($deliveryData);

        die(json::encode($res));
    }

    public function deliveryInfoAction(){
        $title = safe::filter($this->_request->getParam('title'));
        $order_no = safe::filter($this->_request->getParam('order_no'));
        $delivery_id = safe::filter($this->_request->getParam('delivery_id'));
        $is_seller = safe::filter($this->_request->getParam('is_seller'));
        $delivery = new \nainai\delivery\Delivery();
        $order = new \nainai\order\Order();
        $info = $delivery->deliveryInfo($delivery_id);

        $info['order'] = $order->contractDetail($info['order_id']);
        $info['title'] = $title;
        $info['order_no'] = $order_no;
        $info['delivery_id'] = $delivery_id;
        $info['id'] = $info['order_id'];
        $info = array($info);
        $delivery->deliveryStatus($info,$is_seller);
        // echo '<pre>';var_dump($info[0]['action']);exit;
        $this->getView()->assign('info',$info[0]);
    }

    public function deliveryInfoSellerAction(){
        $title = safe::filter($this->_request->getParam('title'));
        $order_no = safe::filter($this->_request->getParam('order_no'));
        $delivery_id = safe::filter($this->_request->getParam('delivery_id'));
        $is_seller = safe::filter($this->_request->getParam('is_seller'));
        $delivery = new \nainai\delivery\Delivery();
        $order = new \nainai\order\Order();
        $info = $delivery->deliveryInfo($delivery_id);

        $info['order'] = $order->contractDetail($info['order_id']);
        $info['title'] = $title;
        $info['order_no'] = $order_no;
        $info['delivery_id'] = $delivery_id;
        $info['id'] = $info['order_id'];
        $info = array($info);
        $delivery->deliveryStatus($info,$is_seller);
        // echo '<pre>';var_dump($info[0]['action']);exit;
        $this->getView()->assign('info',$info[0]);
    }
    /**
     * 显示发货页面
     */
    public function consignmentAction(){
        $id = safe::filter($this->_request->getParam('id'),'int');
        $order = new \nainai\order\Order();
        $delivery = new \nainai\delivery\Delivery();

        $info = $order->contractDetail($id);
        $info['delivery_id'] = safe::filter($this->_request->getParam('delivery_id','int'));
        $invoice = $order->orderInvoiceInfo($info);

        $info = array_merge($info,$delivery->deliveryInfo($info['delivery_id']));
        $this->getView()->assign('invoice',$invoice);
        $this->getView()->assign('info',$info);
    }

    public function deliBuyListAction(){
        $delivery = new \nainai\delivery\Delivery();
        $page = safe::filterGet('page','int',1);
        $user = $this->user_id;
        $list = $delivery->deliveryList($user,$page,false);

        $this->getView()->assign('data',$list['data']);
        $this->getView()->assign('page',$list['bar']);
    }

    public function deliSellListAction(){
        $delivery = new \nainai\delivery\Delivery();
        $page = safe::filterGet('page','int',1);
        $user = $this->user_id;
        $list = $delivery->deliveryList($user,$page,true);

        $this->getView()->assign('data',$list['data']);
        $this->getView()->assign('page',$list['bar']);
    }

    //显示仓库费用
    public function storeFeesPageAction(){
        $delivery_id = safe::filter($this->_request->getParam('id'));
        $store = new \nainai\delivery\StoreDelivery();
        $storeInfo = $store->storeFees($delivery_id);
        $delivery_info = $store->deliveryInfo($delivery_id);

        $storeInfo['delivery_amount'] = number_format($storeInfo['delivery_num'] * $storeInfo['price_unit'],2);
        $this->getView()->assign('info',$storeInfo);
        $this->getView()->assign('delivery_info',$delivery_info);
    }

    //卖家支付仓库管理费用
    public function storeFeesAction(){
        $delivery_id = safe::filterPost('id','int');
        $user_id = $this->user_id;

        if($delivery_id){
            $store = new \nainai\delivery\StoreDelivery();
            $res = $store->payStoreFees($delivery_id,$user_id);
            die(json::encode($res));
        }

    }

    /**
     * 自由报盘同意提货
     */
    public function freeAgreeAction(){
        $delivery_id = $this->_request->getParam('delivery_id','int');

        //设置提货状态为同意
        $deliveryObj = new \nainai\delivery\FreeDelivery();

        $res = $deliveryObj->sellerCheck($delivery_id,1,'');
        if($res['success'] == 1){
            $this->success('已同意提货');
        }else{
            $this->error($res['info']);
        }
        return false;

    }

    /**
     * 自由报盘提货的卖家审核
     */
    public function freeDeliveryAction(){
        $deliveryId = safe::filterPost('id','int');
        $status = safe::filterPost('status','int',1);//1同意，0不同意
        $msg = safe::filterPost('msg');

        $deliveryObj = new \nainai\delivery\FreeDelivery();

        $res = $deliveryObj->sellerCheck($deliveryId,$status,$msg);
        die(JSON::encode($res));
    }



}