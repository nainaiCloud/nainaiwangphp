<?php
/**
 * 报盘模型
 */

use \Library\M;
use \Library\Query;
use \Library\tool;
use \Library\Thumb;
class OfferManageModel extends \nainai\offer\product{

	//模型对象实例
	private $offer;

	public function __construct(){
		parent::__construct();
		$this->offer = new M('product_offer');
	}
	

	/**
	 * 获取列表
	 * @param  int $page 当前页index
	 * @return array
	 */
	private function getList($page,$where =''){
		$Q = new \Library\searchQuery('product_offer as o');
		$Q->join = "left join products as p on o.product_id = p.id left join user as u on o.user_id = u.id
					left join company_info as c on u.id = c.user_id left join person_info as per on u.id = per.user_id";
		$Q->fields = "o.*,u.username,p.quantity,p.attribute,p.unit,p.name,p.note,p.market_id,p.cate_id,per.true_name,c.company_name";
		 $Q->order = 'apply_time desc';
		
		if($where) $Q->where = $where;
		// $Q->order = "sort";
		$sql = 'select count(*) as count from product_offer as o '.($where ? ' where '.$where : '');

		$modeArr = $this->getModelArray();
		$modeArr[0] = '采购';
		$data = $Q->find($modeArr);

		foreach ($data['list'] as $key => &$value){
			$value['divide_text'] = ($value['divide'] == 1) ? '是' : '否';
			$value['quantity'] = min($this->floatForm($value['quantity']),$value['max_num']);
			$value['mode_txt'] = $this->getMode($value['mode']);
			$value['mode_txt'] = $value['mode_txt']=='未知' ? '--' : $value['mode_txt'];
			$value['status_txt'] = $this->getStatus($value['status']);

			$value['attr']='';
			$attr_id = array();
            $attrs = unserialize($value['attribute']);
            if(!empty($attrs)){
                foreach ($attrs as $aid => $name) {
                    if (!in_array($aid, $attr_id)) {
                        $attr_id[] = $aid;
                    }
                }
            }
            $attrName = $this->getHTMLProductAttr($attr_id);
            if(!empty($attrs)){
                foreach($attrs as $key=>$val){
                    if(isset($attrName[$key])){
                        $value['attr'] .= $attrName[$key].':'.$val.' ';
                    }
                }
            }
            $value['market'] = $this->getCateName($this->getcateTop($value['market_id']));
            $value['cate'] = $this->getCateName($value['cate_id']);
			$value['type_txt'] = $this->getType($value['type']);
            $value['sub_mode'] = $this->getSubmode($value['sub_mode']);
		}
		$Q->downExcel($data['list'],'product_offer', '报盘信息列表 ');
		return $data;
	}

	/**
	 * 获取正常的报盘信息
	 * @param $page
	 * @return array
	 */
	public function  getActiveList($page){
		return $this->getList($page,'o.is_del = 0 and (now()< o.expire_time or o.expire_time is null) and o.status IN ('.self::OFFER_OK . ',' . self::OFFER_NG .','.self::OFFER_COMPLETE.')');
	}

	public function getJingjiaList($page){
        return $this->getList($page,'o.sub_mode=1 AND o.is_del = 0 and (now()< o.expire_time or o.expire_time is null) and o.status IN ('.self::OFFER_OK . ',' . self::OFFER_NG .','.self::OFFER_COMPLETE.')');

    }

    public function Baojialist($offer_id){
        $baojiaObj = new Query('product_jingjia as j');
        $baojiaObj->join = 'left join user as u on j.user_id=u.id';
        $baojiaObj->fields = 'j.*,u.username,u.true_name,u.mobile';
        $baojiaObj->order = 'j.price desc';
        $baojiaObj->where = 'offer_id=:offer_id';
        $baojiaObj->bind = array('offer_id'=>$offer_id);
        $res = $baojiaObj->find();

        return $res;
    }


	public function getrepertoryList(){
		$Q = new \Library\searchQuery('store_products as a');
		$Q->join = 'LEFT JOIN store_list  as b ON a.store_id=b.id LEFT JOIN product_offer as po ON a.product_id=po.product_id LEFT JOIN products as c ON po.product_id = c.id LEFT JOIN product_category as pc ON c.cate_id=pc.id';
		$Q->fields = 'b.name as lname, a.store_pos, c.name as pname, c.attribute, pc.name as cname , c.quantity,c.unit, po.id, a.apply_time';
		$Q->where = 'po.is_del = 0  and c.quantity>0 and po.mode='.self::STORE_OFFER.' and po.status IN ('.self::OFFER_OK . ',' . self::OFFER_NG .')';
		$data = $Q->find();
		$attrs = $attr_id = array();
	        foreach ($data['list'] as $key => $value) {

	            $attrs = unserialize($value['attribute']);
	            $data['list'][$key]['attribute'] = $attrs;
	            if(!empty($attrs)){
	                foreach ($attrs as $aid => $name) {
	                    if (!in_array($aid, $attr_id)) {
	                        $attr_id[] = $aid;
	                    }
	                }
	            }

	        }
	        $obj = new \nainai\offer\product();
	        $data['attrs'] =  $obj->getHTMLProductAttr($attr_id);
		return $data;
	}

	/**
	 * 获取待审核的报盘
	 *
	 */
	public function getApplyList($page){
		return $this->getList($page,'o.is_del = 0 and o.status = '.self::OFFER_APPLY);
	}

	/**
	 * 撤销报盘
	 */
	public function getCancelList(){
		return $this->getList(0,'o.is_del = 0 and o.status = '.self::OFFER_CANCEL);
	}

	/**
	 * 获取已删除的报盘
	 *
	 */
	public function getDelList($page){
		return $this->getList($page,'o.is_del = 1 ');
	}


	/**
	 * 获取信息
	 * 
	 * @param  int $id 
	 * @return array  信息
	 */
	public function getofferDetail($id){
		$obj = new M('product_offer');
		$info = $obj->where(array('id'=>$id))->getObj();
		if(!empty($info)){
			$info['type_txt'] = $this->getType($info['type']);
			$info['mode_txt'] = $this->getMode($info['mode']);
			$info['mode_txt'] = $info['mode_txt'] == '未知' ? '--' : $info['mode_txt'];
			$info['submode_txt'] = $this->getSubmode($info['sub_mode']);
			$info['status_txt'] = $this->getStatus($info['status']);
			$product = $this->getProductDetails($info['product_id']);

			$info['sign_thumb'] = \Library\thumb::getOrigImg($info['sign']);
			$info = array_merge($info,$product);
			if ($info['mode'] == \nainai\offer\product::DEPUTE_OFFER) {
				$Obj = new \nainai\system\EntrustSetting();
			            $info['rate'] = $Obj->getRate($info['cate_id']);
			}

		}
		return $info ? $info : array();
	}


	/**
	 * 更新审核状态
	 * @param int $id 报盘id
	 * @param int $status
	 */
	public function setStatus($id,$status, $msg=''){
		if(!($id = intval($id))) return tool::getSuccInfo(0,'参数错误');
		$status = isset($status) ? intval($status) : 1;

		$offerData = $this->offer->where(array('id'=>$id))->fields('user_id,old_offer,acc_type,mode,sub_mode,offer_fee,status,product_id,type')->getObj();

		if($offerData['status']!=self::OFFER_APPLY){
			return tool::getSuccInfo(0,'该报盘已审核');
		}

		try {
			$this->offer->beginTrans();
			$status = $status==1 ? self::OFFER_OK : self::OFFER_NG;

			$res=true;
			//如果是自由报盘，扣费或释放资金
			if($offerData['mode'] == self::FREE_OFFER && $offerData['sub_mode']==0){
				$fund = \nainai\fund::createFund($offerData['acc_type']);
				$free_offer = new \nainai\offer\freeOffer();
				$fee = $free_offer->getFee($offerData['user_id']);
				if($fee>0){
					if($status==self::OFFER_OK){//通过扣费

						$note = '扣除id为'.$id.'的自由报盘报盘费用';
						$marketFund = new \nainai\fund\paytoMarket();
						$res = $fund->freezePay($offerData['user_id'],0,floatval($offerData['offer_fee']),$note);
						$marketFund->paytoMarket($offerData['user_id'],1,2,$id,floatval($offerData['offer_fee']),'自由报盘费用');
					}
					else{
						$note = '释放id为'.$id.'自由报盘报盘费用';
						$res = $fund->freezeRelease($offerData['user_id'],floatval($offerData['offer_fee']),$note);
					}
				}
			}
			if($res===true){
				$this->offer->where(array('id'=>$id))->data(array('status'=>$status, 'admin_msg' => $msg))->update();
				$log = new \Library\log();
				$log->addLog(array('table'=>'报盘','type'=>'check','id'=>$id,'check_text'=>$this->getStatus($status)));

				$param = array('mode' => $offerData['mode'], 'offer_fee'=>$offerData['offer_fee'], 'status'=>$status,'sub_mode'=>$offerData['sub_mode']);
				$param['name'] = $this->offer->table('products')->where(array('id'=>$offerData['product_id']))->getField('name');
				$param['type'] = $offerData['type'];
				if($offerData['sub_mode']==1){
					$param['mode_txt'] = '竞价报盘';
				}
				else if($offerData['sub_mode']==2){
					$param['mode_txt'] = '抢购报盘';
				}
				else{
					$param['mode_txt'] = $this->getMode($param['mode']);
				}

				$obj = new \nainai\message($offerData['user_id']);
				$res = $obj->send('offer', $param);
				if($status==self::OFFER_OK && $offerData['mode'] == self::FREE_OFFER){//审核通过增加信誉值
					$credit = new \nainai\CreditConfig();
					$credit->changeUserCredit($offerData['user_id'],'cert_free');
				}
			}
			else{//付款发生错误
				$this->offer->rollBack();
				return tool::getSuccInfo(0,isset($res)?$res : '系统错误');
			}

			$res = $this->offer->commit();
			//事务成功且设置状态为通过，报盘是非转的竞价，生成mysql event
//			if($res===true && $status==self::OFFER_OK && $offerData['sub_mode']==1 &&$offerData['old_offer']==0){
//			    $jingjiaObj = new \nainai\offer\jingjiaOffer();
//			    $jingjiaObj->createXinEvent($id);
//            }
		} catch (PDOException $e) {
			$this->offer->rollBack();
			$res = $e->getMessage();
		}
		return $res == true ? tool::getSuccInfo() : tool::getSuccInfo(0,(is_string($res) && $res) ? $res : '未知错误');
	}





	/**
	 * 删除
	 * @param  int $id 
	 */
	public function offerDel($id){
		$offer = $this->offer;
		if(($id = trim($id))){
			try {
				$offer->beginTrans();

				$offer->where(array('id'=>$id))->delete();

				$res = $offer->commit();
			} catch (PDOException $e) {
				$offer->rollBack();
				$res = $e->getMessage();
			}
			
		}else{
			$res = '参数错误';
		}

		if($res===true){
			$resInfo = tool::getSuccInfo();
		}
		else{
			$resInfo = tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
		}
		return $resInfo;		
	}

	/**
	 * 逻辑删除报盘
	 * @param int  $id 报盘id
	 * @param int $direct 1:删除，0：复原
	 */
	public function logicDel($id,$direct=1){
		$offer = $this->offer;
		$direct = $direct==1 ? 1 : 0;
		if($id = trim($id)){
			try {
				$offer->beginTrans();
				$this->offer->where(array('id'=>$id))->data(array('is_del'=>$direct))->update();
				$res = $offer->commit();
			} catch (PDOException $e) {
				$offer->rollBack();
				$res = $e->getMessage();
			}

		}else{
			$res = '参数错误';
		}
		if($res===true){
			$resInfo = tool::getSuccInfo();
		}
		else{
			$resInfo = tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
		}
		return $resInfo;
	}

	/**
	 *
	 * @param $offer_id
	 * @param $kefu_id
	 */
	public function addKefu($offer_id,$kefu_id){
		if($offer_id && $kefu_id){
			$this->offer->beginTrans();
			$this->offer->where(array('id'=>$offer_id))->data(array('kefu'=>$kefu_id))->update();
			$log  = new \Library\log();
			$log->addLog(array('content'=>'为报盘'.$offer_id.'绑定客服'.$kefu_id));
			$res = $this->offer->commit();
			if($res===true){
				return tool::getSuccInfo();
			}
			return tool::getSuccInfo(0,'绑定失败');
		}
		else{
			return tool::getSuccInfo(0,'操作错误');
		}
	}

	/**
	 * 获取当前登录客服的报盘
	 * @param $page
	 * @return array
	 */
	public function getKefuOfferList($page){
		$admin = \Library\session::get('admin');
		$admin_id = $admin['id'];
		if($admin_id>0){
			$data = $this->getList($page,'o.kefu='.$admin_id);
			return $data;
		}
		return array();
	}

	/**
	 * 获取过期的报盘
	 */
	public function getExpireOfferList($page){
		return $this->getList($page,'(now()>o.expire_time || o.status=6 || o.status=5) ');
	}

	public function expireOfferDetailsAction(){

	}

	/************首页配置产品的部分数据获取**************************/

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
	 * 获取下级子分类
	 */
	public  function getNextCate($pid){
		$obj = new \Library\M('product_category');
		$cates = $obj->where(array('pid'=>$pid))->fields('id,name')->select();

		return $cates;
	}


	public function getSearchProduct($where,$page=0)
	{
		$query = new \Library\Query('product_offer as o');
		$query->join = "left join products as p on o.product_id = p.id  left join user as u on p.user_id=u.id";
		$query->fields = "o.*,p.img,p.name,p.note,p.unit,p.quantity,p.freeze,p.sell,p.produce_area,u.username";

		$whereStr = ' o.status=:status and o.is_del = 0  and (o.expire_time > now() or o.expire_time is null )';

		if(isset($where['str']) && is_string($where['str'])){
			$whereStr .= ' and '.$where['str'];
		}
		$bind = array('status'=>self::OFFER_OK);
		if(isset($where['username'])&&$where['username']){
			$whereStr .= ' and u.username=:username';
			$bind['username'] = $where['username'];
		}

		if(isset($where['start_time'])&&$where['start_time'] >0){
			$whereStr .= ' and p.create_time>=:start_time';
			$bind['start_time'] = $where['start_time'];
		}
		if(isset($where['end_time'])&&$where['end_time']>0){
			$whereStr .= ' and p.create_time<=:end_time';
			$bind['end_time'] = $where['end_time'];
		}
		if(isset($where['market_id'])&&$where['market_id']){
			$whereStr .= ' and p.market_id=:market_id';
			$bind['market_id'] = $where['market_id'];
		}
		if(isset($where['cate_id'])&&$where['cate_id']>0){
			$cates = $this->getChildCate($where['cate_id'],0);
			foreach($cates[0] as $v){
				$cate_ids[] = $v['id'];
			}
			$cate_ids = join(',',$cate_ids);
			$whereStr .= ' and p.cate_id in ('.$cate_ids.')';
		}
		if(isset($where['mode'])&& $where['mode']>=0){
			$whereStr .= ' and o.mode=:mode';
			$bind['mode'] = $where['mode'];
		}
		if(isset($where['sub_mode'])&& $where['sub_mode']>=0){
			$whereStr .= ' and o.sub_mode=:sub_mode';
			$bind['sub_mode'] = $where['sub_mode'];
		}
		if(isset($where['area'])&&$where['area']){
			$len = strlen($where['area']);
			$whereStr .= ' and left(p.produce_area,'.$len.') =:area';
			$bind['area'] = $where['area'];
		}

		$query->where = $whereStr;
		$query->bind = $bind;

		if($page){
			$query->page = $page;
			$query->pagesize = 20;
			$data['list'] = $query->find();
			$data['bar'] = $query->getPageBar();
			foreach ($data['list'] as $key => &$value) {
				$value['img'] = empty($value['img']) ? '' : \Library\thumb::get($value['img'],180,180);//获取缩略图
				$value['divide_text'] = ($value['divide'] == 1) ? '是' : '否';
				$value['quantity'] = $this->floatForm($value['quantity']);
				$value['mode_txt'] = $this->getMode($value['mode']);
				$value['mode_txt'] = $value['mode_txt']=='未知' ? '--' : $value['mode_txt'];
				$value['status_txt'] = $this->getStatus($value['status']);

				$value['type_txt'] = $this->getType($value['type']);
			}
		}
		else{
			$data= $query->find();
			foreach ($data as $key => &$value) {
				$value['img'] = empty($value['img']) ? '' : \Library\thumb::get($value['img'],180,180);//获取缩略图
				$value['divide_text'] = ($value['divide'] == 1) ? '是' : '否';
				$value['quantity'] = $this->floatForm($value['quantity']);
				$value['mode_txt'] = $this->getMode($value['mode']);
				$value['mode_txt'] = $value['mode_txt']=='未知' ? '--' : $value['mode_txt'];
				$value['status_txt'] = $this->getStatus($value['status']);

				$value['type_txt'] = $this->getType($value['type']);
			}
		}

		return $data;


	}

	
}