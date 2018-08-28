<?php
/**
 * User: maoyong
 * Date: 2016/5/17 0017
 * Time: ÏÂÎç 5:05
 */

use \Library\Query;
use \Library\M;
class offersModel extends \nainai\offer\product{

    private $offer;
	
	private $offerQuery = null;
    public function __construct(){
        $this->offer = new M('product_offer');
    }

    public function beginTrans(){
        $this->offer->beginTrans();
    }

    public function commit(){
        $this->offer->commit();
    }
    public function rollBack(){
        $this->offer->rollBack();
    }
    /**
     * »ñÈ¡²úÆ·¶ÔÓ¦·ÖÀàÏÂµÄµÄ±¨ÅÌÐÅÏ¢ÁÐ±í
     * @param  [Int] $cateId [·ÖÀàid]
     * @return [Array]
     */
    /**
     * ×Ô¶¨ÒåµÄmysqlº¯Êý
     * getChildLists(rootId)
     *  BEGIN
        DECLARE sTemp VARCHAR(1000);
        DECLARE sTempChd VARCHAR(1000);
        SET sTemp = '$';
        SET sTempChd =cast(rootId as CHAR);
        WHILE sTempChd is not null DO
        SET sTemp = concat(sTemp,',',sTempChd);
        SELECT group_concat(id) INTO sTempChd FROM nn.product_category where FIND_IN_SET(pid,sTempChd)>0;
        END WHILE;
        RETURN sTemp;
        END
     */
    public function getOfferCategoryList($cateId){
		static $times = 0;
		$expire = 3600 + $times * 600;
        $memcache=new \Library\cache\Cache(array('type'=>'m','expire'=>$expire));
        $res=$memcache->get('offerCategoryList'.$cateId);
        if($res){
            return unserialize($res);
        }
		$times = $times + 1;

		if($this->offerQuery == null){
			$this->offerQuery = new Query('product_offer as a');
			$this->offerQuery->fields = 'a.id,a.mode, a.sub_mode,a.price_l,a.price_r,a.type,a.accept_area, a.price, b.cate_id,b.id as product_id, b.name as pname, b.quantity, b.freeze,b.sell,b.unit,b.produce_area,b.img,b.note';
			$this->offerQuery->join = 'LEFT JOIN products as b ON a.product_id=b.id ';
		 //   $query->where = 'a.status='.self::OFFER_OK.' AND a.expire_time>now() AND  find_in_set(b.cate_id, getChildLists(:cid))';

			$this->offerQuery->order = 'a.apply_time desc';
			$this->offerQuery->limit = 10;
		}
		$this->offerQuery->where = 'b.market_id ='.$cateId.'  and a.status='.self::OFFER_OK.' AND a.expire_time>now() AND a.is_del = 0';

        $categoryList= $this->offerQuery->find();

        foreach($categoryList as $k=>$v){
            $categoryList[$k]['mode']=$this->getMode($v['mode']);
            $categoryList[$k]['produce_area'] = substr($v['produce_area'],0,2);
            $categoryList[$k]['img'] = \Library\Thumb::get($categoryList[$k]['img']);
            if($categoryList[$k]['sub_mode']==1 && $categoryList[$k]['price_r']==0){
                $categoryList[$k]['price_r'] = '-';
            }
        }


        $memcache->set('offerCategoryList'.$cateId,serialize($categoryList));
        return $categoryList;
    }


    /**
     * 获取所有子分类
     */
    private function getChildCate($pid,$level=1){
        static $cate = array();
        $obj = new M('product_category');
        $cates = $obj->where(array('pid'=>$pid))->fields('id,name')->select();
        static $childCates = array();
        static $childName = '';
        if($level==0){
            //获取下级分类统称
            $childName = $obj->where(array('id'=>$pid))->getField('childname');
            if(!$childName)
                $childName = '商品分类';
            $childCates = $cates;
        }
        foreach($cates as $k=>$v){
            $this->getChildCate($v['id']);
        }
        $cate = array_merge($cate,$cates);
        return array($cate,$childCates,$childName);
    }

    /**
     * 根据视图获取报盘列表（还有问题）
     * @param $page
     * @param array $condition
     * @param string $order
     * @return array
     */
    public function getOfferList($page,$condition = array(),$order=''){
        $query = new Query('offersort');
        $where = 'status=:status and is_del = 0  and expire_time > now()';

        $bind = array('status'=>self::OFFER_OK);
        //获取分类条件
        $childcates = array();
        $childname = '';
        if(isset($condition['pid']) && $condition['pid']>0) {
            $cates = $this->getChildCate($condition['pid'],0);
            $childname = $cates[2];
            $cate_ids = array();
            $cate_ids[] = $condition['pid'];
            foreach($cates[0] as $v){
                $cate_ids[] = $v['id'];
            }
            $cate_ids = join(',',$cate_ids);
            $where .= ' and cate_id in ('.$cate_ids.')';

            $childcates = $cates[1];

        }

        //获取报盘类型条件
        if(isset($condition['type']) && $condition['type']!=0){
            $where .= ' and type=:type';
            $bind['type'] = $condition['type'];
        }

        //获取报盘类型
        if(isset($condition['mode']) && $condition['mode']!=0){
            $where .= ' and mode=:mode';
            $bind['mode'] = $condition['mode'];
        }

        //获取地区条件
        if(isset($condition['area']) && $condition['area']!=0){
            $where .= ' and left(produce_area,2) = :area ';
            $bind['area'] = $condition['area'];
        }

        //获取搜索条件
        if(isset($condition['search']) && $condition['search']!=''){
            $where .= ' and name like "%'.$condition['search'].'%" ';
        }
        $query->where = $where;
        $query->bind = $bind;

        $query->page = $page;
        $query->pagesize = 20;
        if($order=='')
            $query->order = "apply_time desc";
        else {
            $query->order = $order;
        }
        $data = $query->find();
        foreach ($data as $key => &$value) {
            $value['mode_txt'] = $this->offerMode($value['mode']);
         //   $value['img'] = empty($value['img']) ? '' : \Library\thumb::get($value['img'],30,30);//获取缩略图
            $value['left'] = number_format(floatval($value['quantity']) - floatval($value['freeze']) - floatval($value['sell']));
        }
        $pageBar =  $query->getPageBar();
        return array('data'=>$data,'bar'=>$pageBar,'cate'=>$childcates,'childname'=>$childname);
    }
    /**
     * 交易网页列表
     * @param $page
     * @param array $condition
     * @param string $order
     * @return array
     */
    public function getList($page,$condition = array(),$order='',$user_id){
        $query = new Query('product_offer as o');
        $query->join = "left join products as p on o.product_id = p.id  LEFT JOIN product_category as c ON p.cate_id=c.id left join admin_kefu as ke on o.kefu=ke.admin_id";
        $query->fields = "o.*,p.img,p.cate_id,p.name,p.quantity,p.freeze,p.sell,p.unit,p.produce_area,p.produce_address, c.name as cname,ke.qq,IF(p.quantity-p.sell-p.freeze=0 || o.status=6,1,0) as jiao";
        $query->group = 'o.id';
        $where = 'o.status in ('.self::OFFER_OK.','.self::OFFER_COMPLETE.','.self::OFFER_WAITINGTRADE.') and o.is_del = 0 and (now()< o.expire_time OR o.expire_time is null) ';
        $bind = array();

//        if (empty($order)) {
//            $model = new \nainai\offer\ProductSetting();
//            $detail = $model->getProductSetting(1);
//            $dbName = \Library\tool::getConfig(array('database','master','database'));
//
//            $query->join .= ' LEFT JOIN (select *, (time*' .$detail['time']. '+credit*'.$detail['credit'].') as common from (
//SELECT  p.user_id, p.apply_time, 100 * ( 1 - floor((UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(p.apply_time))/86400) / '.$detail['day'].') as time, (100*u.credit)/'.$detail['max_credit'].' as credit FROM '.$dbName.'.product_offer as p left join user
// as u ON p.user_id=u.id ) as s ) as cha on o.user_id=cha.user_id';
//            $order = 'cha.common desc, o.apply_time desc';
//        }

        //获取分类条件
        $childcates = array();
        $childname = '';
        if(isset($condition['pid']) && $condition['pid']>0) {
			 $memcache=new \Library\cache\Cache(array('type'=>'m','expire'=>0));
			 $cates = $memcache->get('cates'.$condition['pid']);
			 if(!$cates){
				 $cates = $this->getChildCate($condition['pid'],0);
				$memcache->set('cates'.$condition['pid'],serialize($cates));
			 }
			 else{
				 $cates = unserialize($cates);
			 }
			 $childname = $cates[2];
			$cate_ids = array();
			$cate_ids[] = $condition['pid'];
			foreach($cates[0] as $v){
					$cate_ids[] = $v['id'];
			}
			$cate_ids = join(',',$cate_ids);
			$where .= ' and c.id in ('.$cate_ids.')';
				
			$childcates = $cates[1];
            

        }

        //获取报盘类型条件
        if(isset($condition['type']) && $condition['type']!=0){
            $where .= ' and o.type=:type';
            $bind['type'] = $condition['type'];
        }

        //获取报盘类型
        if(isset($condition['mode']) && $condition['mode']!=0){
            $where .= ' and o.mode=:mode';
            $bind['mode'] = $condition['mode'];
        }

        //获取竞价一口价的类型
        if(isset($condition['sub_mode']) && $condition['sub_mode']!=0){
            $where .= ' and o.sub_mode=:sub_mode';
            $bind['sub_mode'] = $condition['sub_mode'];
        }

        //获取地区条件
        if(isset($condition['area']) && $condition['area']!=0){
            $where .= ' and left(p.produce_area,2) = :area ';
            $bind['area'] = $condition['area'];
        }

        //获取搜索条件
        if(isset($condition['search']) && $condition['search']!=''){
            $where .= ' and p.name like "%'.$condition['search'].'%" ';
        }
        $query->where = $where;
        $query->bind = $bind;

        $query->page = $page;
        $query->pagesize = 20;
        if($order=='')
            $query->order = "o.apply_time desc";
        else {
            $query->order = $order;
        }
        $data = $query->find();
		$certObj = new \nainai\cert\certificate();
        foreach ($data as $key => &$value) {
            $user_id = $value['type'] == \nainai\offer\product::TYPE_SELL ? $value['user_id'] : $user_id;
            $info = $value['type'] == \nainai\offer\product::TYPE_SELL ? '该卖家资质不完善,不能进行此交易' : '您的资质不完善,无法进行报价';
            $certStatus = $certObj->getCertStatus($user_id,'deal');
            $value['no_cert'] = $certStatus['status'] == 2 ? 0 : 1;
            $value['info'] = $info;
            $value['mode_txt'] = $this->offerMode($value['mode']);
            $value['img'] = empty($value['img']) ? '' : \Library\thumb::get($value['img'],30,30);//获取缩略图
            $value['left'] = number_format(min(floatval($value['quantity']) - floatval($value['freeze']) - floatval($value['sell']),$value['max_num']-$value['sell_num']));
            $value['left'] = $value['left'] <0 ? 0 : $value['left'];

        }
        //print_r($data);
        $pageBar =  $query->getPageBar();
        return array('data'=>$data,'bar'=>$pageBar,'cate'=>$childcates,'childname'=>$childname);
    }

    public function jingjiaList($page,$condition = array(),$order=''){
        $query = new Query('product_offer as o');
        $query->join = "left join products as p on o.product_id = p.id  LEFT JOIN product_category as c ON p.cate_id=c.id 
                        left join user as u on o.user_id=u.id ";
        $query->fields = "o.*,u.true_name,p.img,p.cate_id,p.attr_json,p.name,p.quantity,p.freeze,p.sell,p.unit,p.produce_area,p.produce_address, c.name as cname";
        $where = 'o.sub_mode=1  and o.is_del = 0 and o.status in (1,5,6,7) ';
        $bind = array();

        //获取分类条件
        $childcates = array();
        $childname = '';
        if(isset($condition['pid']) && $condition['pid']>0) {
            $memcache=new \Library\cache\Cache(array('type'=>'m','expire'=>0));
            $cates = $memcache->get('cates'.$condition['pid']);
            if(!$cates){
                $cates = $this->getChildCate($condition['pid'],0);
                $memcache->set('cates'.$condition['pid'],serialize($cates));
            }
            else{
                $cates = unserialize($cates);
            }
            $childname = $cates[2];
            $cate_ids = array();
            $cate_ids[] = $condition['pid'];
            foreach($cates[0] as $v){
                $cate_ids[] = $v['id'];
            }
            $cate_ids = join(',',$cate_ids);
            $where .= ' and c.id in ('.$cate_ids.')';

            $childcates = $cates[1];


        }

        //获取地区条件
        if(isset($condition['area']) && $condition['area']!=0){
            $where .= ' and left(p.produce_area,2) = :area ';
            $bind['area'] = $condition['area'];
        }

        //获取搜索条件
        if(isset($condition['search']) && $condition['search']!=''){
            $where .= ' and p.name like "%'.$condition['search'].'%" ';
        }

        if(isset($condition['status'])){
            $where .= ' and '.$condition['status'];
        }
        $query->where = $where;
        $query->bind = $bind;

        $query->page = $page;
        $query->pagesize = 20;
        if($order=='')
            $query->order = "o.id desc";
        else {
            $query->order = $order;
        }
        $data = $query->find();
        $baojiaObj = new M('product_jingjia');
        foreach ($data as $key => &$value) {
            $value['img'] = empty($value['img']) ? '' : \Library\thumb::get($value['img'],300,300);//获取缩略图
            $value['baojia'] = $baojiaObj->where(array('offer_id'=>$value['id']))->getField('count(id)');
            $value['price_f'] = $baojiaObj->where(array('offer_id'=>$value['id']))->order('price desc')->limit(1)->getField('price');
            $attr_ids = array();
            $detail['attribute'] = json_decode($value['attr_json'],true);
            if(!empty($detail['attribute'])){
                foreach ($detail['attribute'] as $k => $v) {
                    if(!is_numeric($k)){
                        $value['attr'] = $detail['attribute'];
                        break;
                    }
                    $attr_ids[] = $k;
                }
            }
            if(!empty($value['attr'])){
                continue;
            }
            //获取属性
            $attrs = $this->getHTMLProductAttr($attr_ids);
            $detail['attr_arr'] = array();
            if(!empty($detail['attribute'])) {
                foreach ($detail['attribute'] as $k => $v) {
                    if(isset($attrs[$k])){
                        $detail['attr_arr'][] = array(
                            'name'=>$attrs[$k],
                            'value'=>$v
                        );
                    }

                }
            }

            $value['attr'] = $detail['attr_arr'];

            $startTime = strtotime($value['start_time']);
            $now = time();
            $endTime = strtotime($value['end_time']);
            if($now<$startTime){
                $value['status']=1;
            }elseif($now>=$startTime && $now<=$endTime){
                $value['status']=2;
            }else{
                $value['status']=3;
            }
        }
        //print_r($data);
        $pageBar =  $query->getPageData();
        return array('data'=>$data,'page'=>$pageBar,'cate'=>$childcates,'childname'=>$childname);
    }

    //获取报盘类型
    public function offerMode($type){
        return $this->getMode($type);
    }

    /**
     * 按照后台配置的筛选条件返回部分商品数据
     * @param $configId int 配置id
     * @param int $page
     * @param int $page_size
     * @return array
     */
    public function getOfferlistByConfig($configId,$page=1,$page_size=6,$order='',$pagebar=0)
    {
        $query = new Query('product_offer as o');
        $query->join = "left join products as p on o.product_id = p.id  ";
        $query->fields = "o.*,p.img,p.name,p.note,p.unit,p.quantity,p.freeze,p.sell,p.produce_area,IF(p.quantity-p.sell-p.freeze>0,0,1) as jiao";

        $whereStr = ' o.status=:status and o.is_del = 0  and (o.expire_time > now() or o.expire_time is null )';

        $bind = array('status'=>self::OFFER_OK);

        $configObj = new M('configs_indexshow');
        $productData = $configObj->where(array('id'=>$configId))->fields('proids,pic_num,pic_num')->getObj();

        if(empty($productData)){
            return array();
        }
        if(isset($productData['proids']) && $productData['proids']){
            $whereStr .= ' and o.id in ('.$productData['proids'].')';
        }



        $query->where = $whereStr;
        $query->bind = $bind;
        $query->page = $page;
        $query->pagesize = $productData['pic_num']>0 ? $productData['pic_num'] : $page_size;
        if($order){
            $query->order = $order;
        }
        else
            $query->order = " o.offer_sort asc ";

        $data = $query->find();
        foreach ($data as $key => &$value) {
           $value['img'] = empty($value['img']) ? '' : \Library\thumb::get($value['img'],180,180);//获取缩略图
           $value['price_r'] = $value['price_r']<=0 ? '-' : $value['price_r'];
        }

        if($pagebar){
            return array('list'=>$data,'bar'=>$query->getPageBar());
        }
        return $data;

    }


    //获取报盘类型
    public function offerType($id){
        return intval($this->offer->where(array('id'=>$id))->getField('mode'));
    }

    /**
     * 获取统计报盘的数量
     * @return Int
     */
    public function getOfferNum(){
        $memcache=new \Library\cache\driver\Memcache();
        $offerNum=$memcache->get('offerNum');
        if($offerNum){
            return unserialize($offerNum);
        }
        $offerNum=$this->offer->table('products')->fields('COUNT(id) as num ')->where('quantity-sell > 0')->getObj();
        $memcache->set('offerNum',serialize($offerNum));
        return $offerNum;
    }

    /**
     * 获取某一分类的所有祖先分类
     * @param
     */
    public function getCateTopList($cate){
        if(intval($cate)>0){
            $cate = intval($cate);
            $parent = array();
            $obj = new M('product_category');
            $pid = $obj->where(array('id'=>$cate))->getField('pid');

            $parent[] = $cate;
            while($pid!=0){
                $parent[] = $pid;
                $pid = $obj->where(array('id'=>$pid))->getField('pid');
            }
            return array_reverse($parent);
        }
        return array();

    }

    /**
     * 获取竞价报价数据
     * @param $offer_id int 报盘id
     * @return mixed
     */
    public function baojiaData($offer_id)
    {
        $baojiaObj = new Query('product_jingjia as j');
        $baojiaObj->join = 'left join user as u on j.user_id=u.id';
        $baojiaObj->fields = 'j.*,u.username,u.true_name';
        $baojiaObj->order = 'j.price desc';
        $baojiaObj->where = 'offer_id=:offer_id';
        $baojiaObj->bind = array('offer_id'=>$offer_id);
        $res = $baojiaObj->find();
        $model = new M('user');
        foreach($res as $val){
            if($val['true_name']==''){
                $str = 'SELECT createUsertruename('.$val['user_id'].',100)';
                $model->query($str);
            }
        }
        return $res;

    }



}