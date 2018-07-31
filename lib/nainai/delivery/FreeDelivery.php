<?php
/**
 * @author panduo
 * @date 2016-05-13 10:42:05
 * @brief 仓单提货
 *
 */
namespace nainai\delivery;
use \Library\M;
use \Library\Query;
use \Library\tool;
use \Library\url;
use \Library\time;

use nainai\order;
class FreeDelivery extends Delivery{
	
	public function __construct(){
		parent::__construct(order\Order::ORDER_FREE);
		$this->orderObj = new \nainai\order\Order();
	}


    /**
     * 卖方审核提单
     * @param $id
     * @param int $status
     * @param string $msg
     */
	public function sellerCheck($id,$status=1,$msg=''){

	    $obj = new M('product_delivery');
	    $status = $status==1 ? self::DELIVERY_SELLER_AGREE : self::DELIVERY_SELLER_UNAGREE;
	    $data = array('status'=>$status,'seller_msg'=>$msg);
        $res = $obj->where(array('id'=>$id))->data($data)->update();
        if($res){
            return tool::getSuccInfo();
        }else{
            return tool::getSuccInfo(0,'审核失败');
        }

    }
}