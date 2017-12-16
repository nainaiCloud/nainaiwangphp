<?php

use \Library\Query;
use \Library\tool;
use \Library\M;
/**
 * 商品模型
 * @author zengmaoyong 
 */
class productModel extends \nainai\offer\product{


	/**
	 * 获取报盘对应的产品列表
	 * @param  [Int] $page     [分页]
	 * @param  [Int] $pagesize [分页]
	 * @param  string $where    [where的条件]
	 * @param  array  $bind     [where绑定的参数]
	 * @return [Array.list]           [返回的对应的列表数据]
	 * @return [Array.pageHtml]           [返回的分页html数据]
	 */
	public function getOfferProductList($page, $pagesize, $where='', $bind=array()){
		$query = new Query('product_offer as c');
		$query->fields = 'c.id, a.name, c.pro_name,b.name as cname, a.quantity,a.unit,a.freeze,a.sell, c.price, c.expire_time, c.status, c.mode, a.user_id, c.apply_time,c.max_num,c.sell_num';
		$query->join = '  LEFT JOIN products as a ON c.product_id=a.id LEFT JOIN product_category as b ON a.cate_id=b.id ';
		$query->page = $page;
		$query->pagesize = $pagesize;
		$query->order = 'c.id desc';
		// $query->order = ' a.create_time desc';

		$status = implode(',', array(self::OFFER_APPLY, self::OFFER_OK, self::OFFER_NG,self::OFFER_CANCEL,self::OFFER_COMPLETE,self::OFFER_WAITINGTRADE));
		$where .= ' AND c.status IN (' .$status. ')';
		if (empty($where)) {
			$where = ' AND c.mode IN (1, 2,3, 4) ';
		}else{
			$where .= ' AND c.mode IN (1, 2,3, 4) ';
			$query->bind = $bind;
		}
		$query->where = $where;
		$list = $query->find();
		foreach($list as $k=>$v){
			$list[$k]['status'] = $this->getStatus($list[$k]['status']);
			$list[$k]['left'] = min($v['quantity']-$v['freeze']-$v['sell'],$v['max_num']-$v['sell_num']);
		}
		return array('list' => $list, 'pageHtml' => $query->getPageBar());
	}

	/**
	 * 获取产品列表
	 * @param  string $where    [where的条件]
	 * @param  array  $bind     [where绑定的参数]
	 * @return [Array.list]           [返回的对应的列表数据]
	 * @return [Array.pageHtml]           [返回的分页html数据]
	 */
	public function getAllokoffer( $user_id){
		$query = new Query('product_offer as o');
		$query->fields = 'o.id,o.offer_no,o.mode,p.name,p.quantity-p.freeze-p.sell as leftnum,o.price';
		$query->join = '  LEFT JOIN products as p ON o.product_id=p.id  ';

		// $query->order = ' a.create_time desc';

		$where = 'o.user_id='.$user_id.' and o.type=1 and  o.sub_mode=0 and o.status='.self::OFFER_OK.' and o.is_del=0 and o.expire_time>now()';

		$query->where = $where;
		$list = $query->find();
		foreach($list as &$item){
			$item['mode_txt'] = $this->getMode($item['mode']);
		}

		return  $list;
	}


	/**
	 * 获取对应id的报盘和产品详情数据
	 * @param  [Int] $id [报盘id]
	 * @return [Array]     [报盘和产品数据]
	 */
	public function getOfferProductDetail($id,$user_id){
		$query = new M('product_offer');
		$offerData = $query->where(array('id'=>$id,'user_id'=>$user_id))->getObj();
		$offerData['divide_txt'] = $this->getDivide($offerData['divide']);
		$offerData['status_txt'] = $this->getStatus($offerData['status']);
		$productData = $this->getProductDetails($offerData['product_id']);
		return array($offerData,$productData);
	}


}