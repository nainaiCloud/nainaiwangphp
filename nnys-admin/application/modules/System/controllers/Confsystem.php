<?php 

/**
 * 系统配置项控制器
 */
use \Library\safe;
use \Library\tool;
use \Library\JSON;
use \Library\url;
class ConfsystemController extends Yaf\Controller_Abstract{

	private $confcredit;
	public function init(){
		$this->confcredit = new \config\ConfcreditModel();
		$this->confscaleOffer = new \config\ConfscaleOfferModel();
		$this->getView()->setLayout('admin');
		//echo $this->getViewPath();
	}

	/**
	 * 获取信誉值配置列表
	 * @return 
	 */
	public function creditListAction(){
		$page = safe::filterGet('page','int');
		$pageData = $this->confcredit->getList($page);
		$this->getView()->assign('data',$pageData['data']);
		$this->getView()->assign('bar',$pageData['bar']);
	}
	
	/**
	 * 新增或修改信誉值配置
	 */

	public function creditOperAction(){
		if(IS_AJAX){
			$oper_type = safe::filterPost("oper_type","int");
			$confcreditData['name'] 	= safe::filterPost('name');
			$confcreditData['name_zh']  = safe::filterPost('name_zh');
			$confcreditData['type']     = safe::filterPost('type','int');
			$confcreditData['sign']     = safe::filterPost('sign','int');
			$confcreditData['value']    = safe::filterPost('value','float');
			$confcreditData['sort']     = safe::filterPost('sort','int');
			$confcreditData['note']     = safe::filterPost('note');
			if($oper_type == 1){
				//新增
				$confcreditData['time']    = date("Y-m-d H:i:s",time());
			}else{
				//更新
				$confcreditData['ori_name'] = safe::filterPost('ori_name');
			}
			$res = $this->confcredit->confcreditUpdate($confcreditData);
			echo JSON::encode($res);
			return false;
		}else{
			$oper_type = intval($this->_request->getParam('oper_type'));
			if($oper_type == 2){
				$oper = "编辑";
				$name = $this->_request->getParam('name');
				$confcreditInfo = $this->confcredit->getconfcreditInfo($name);
				$this->getView()->assign('info',$confcreditInfo);
			}else{
				$oper = "新增";
			}
			$this->getView()->assign('oper',$oper);
			$this->getView()->assign('oper_type',$oper_type);
		}
	}

	/**
	 * 删除信誉值
	 */
	public function creditDelAction(){
		$name = $this->_request->getParam('name');
		$res = $this->confcredit->creditDel($name);
		die(JSON::encode($res));
	}


	/**
	 * 修改交易费率配置
	 */

	public function scaleOfferOperAction(){
		if(IS_AJAX){
			$confscaleOfferData['free'] 	= safe::filterPost('free');
			$confscaleOfferData['deposite'] = safe::filterPost('deposite');
			$confscaleOfferData['fee']      = safe::filterPost('fee');
			$confscaleOfferData['bid_bail']      = safe::filterPost('bid_bail');
			$confscaleOfferData['id']		= 1;
			$res = $this->confscaleOffer->confscaleOfferUpdate($confscaleOfferData);
			echo JSON::encode($res);
			return false;
		}else{
			$confscaleOfferInfo = $this->confscaleOffer->getconfscaleOfferInfo(1);
			$this->getView()->assign('info',$confscaleOfferInfo);
		}
	}


	/**
	 * 配置项的添加
	 */
	public function addConfigAction(){
		$configObj = new \config\configsModel();
		if(IS_POST){
			$config = array();
			$config['name'] = safe::filterPost('name');
			$config['name_zh'] = safe::filterPost('name_zh');
			$config['type'] = safe::filterPost('type');
			$config['value'] = safe::filterPost('value');

			$res = $configObj->add($config);

			die(json::encode($res));


		}
		else{
			//获取配置类型
			$types = $configObj->getType();
			$this->getView()->assign('type',$types);
		}
	}

	/**
	 * 配置项列表
	 */
	public function generalListAction(){
		$configObj = new \config\configsModel();
		$data = $configObj->getConfigList();
		$this->getView()->assign('data',$data);
	}

	/**
	 * 配置项的编辑
	 */
	public function editConfigAction(){
		$configObj = new \config\configsModel();
		if(IS_POST){
			$config = array();
			$config['id'] = safe::filterPost('id','int');
			$config['name_zh'] = safe::filterPost('name_zh');
			$config['value'] = safe::filterPost('value');

			$res = $configObj->update($config);

			die(json::encode($res));


		}
		else{
			$id = $this->getRequest()->getParam('id');
			$id = safe::filter($id,'int');
			if($id){
				$data = $configObj->get($id);
				if(!empty($data)){
					$data['type'] = $configObj->getType($data['type']);
				}

				$this->getView()->assign('data',$data);
			}
		}
	}

	/**
	 * 删除配置项
	 */
	public function delConfigAction(){
		if(IS_POST){
			$configObj = new \config\configsModel();
			$id = $this->getRequest()->getParam('id');
			$id = safe::filter($id,'int');

			if($id){
				$res = $configObj->delete($id);
				die(json::encode($res)) ;
			}
		}

	}

	public function entrustListAction(){
		$model = new \nainai\system\EntrustSetting();
		$data = $model->getList();

		$this->getView()->assign('data',$data);
	}

	public function entrustaddAction(){
		if (IS_AJAX) {
			$data = array(
				'type' => safe::filterPost('type'),
				'value' => safe::filterPost('value'),
				'cate_id' => safe::filterPost('cate_id'),
				'create_time' => \Library\Time::getDateTime(),
				'note' => safe::filterPost('note'),
				'status' => safe::filterPost('status')
			);
			$model = new \nainai\system\EntrustSetting();
			$res = $model->addEntrustSetting($data);
			exit(JSON::encode($res));
		}
		$productModel = new productModel();
		$cateTree = $productModel->getCateTree();//获取分类树

		$model = new \nainai\system\EntrustSetting();
		$data = $model->getcatelist();
		$this->getView()->assign('data',$data);
               	$this->getView()->assign('tree',$cateTree);
	}

	public function entrustupdatestatusAction(){
		$id = $this->getRequest()->getParam('id');
		$status = safe::filterPost('status','int',0);
		$id = Safe::filter($id, 'int', 0);


		$agentData = array(
			'status' => $status
		);

		$agentModel = new \nainai\system\EntrustSetting();
		$returnData = $agentModel->updateEntrustSetting($agentData, $id);

		die(json::encode($returnData));
	}

	public function entrustdelAction(){
		$id = $this->getRequest()->getParam('id');
		$id = Safe::filter($id, 'int', 0);

		$agentModel = new \nainai\system\EntrustSetting();
		$returnData = $agentModel->deleteEntrustSetting($id);

		die(json::encode($returnData));
	}

	public function entrustupdateAction(){
		if (IS_AJAX) {
			$id = safe::filterPost('id');
			$data = array(
				'type' => safe::filterPost('type'),
				'value' => safe::filterPost('value'),
				'cate_id' => safe::filterPost('cate_id'),
				'create_time' => \Library\Time::getDateTime(),
				'note' => safe::filterPost('note'),
				'status' => safe::filterPost('status')
			);
			$model = new \nainai\system\EntrustSetting();
			$res = $model->updateEntrustSetting($data, $id);
			exit(JSON::encode($res));
		}
		$id = $this->getRequest()->getParam('id');
		$id = Safe::filter($id, 'int', 0);

		$agentModel = new \nainai\system\EntrustSetting();
		$detail = $agentModel->getDetail($id);
               	$this->getView()->assign('detail',$detail[0]);
	}


	public function productsetAction(){
		$model = new \nainai\offer\ProductSetting();

		if (IS_AJAX) {
			$data = array(
				'time' => safe::filterPost('time', 'float', 0),
				'credit' => safe::filterPost('credit', 'float', 0),
				'day' => safe::filterPost('day', 'float', 0),
				'max_credit' => safe::filterPost('max_credit', 'float', 0),
			);
			$res = $model->updateProductSetting($data, 1);
			exit(json::encode($res));
		}
		
		$detail = $model->getProductSetting(1);

		if (empty($detail)) {
			$detail = array('time' => 0, 'credit' => 0);
			$model->addProductSetting($detail);
		}
		$this->getView()->assign('detail',$detail);
	}


	/***********************首页板块的配置**************************/


	public function addIndexconfigAction()
	{
		$configObj = new \config\configsIndexModel();
		if(IS_POST){
			$config = array();
			$config['type'] = safe::filterPost('type');
			$config['sub_title'] = safe::filterPost('sub_title');
			$config['title'] = safe::filterPost('title');
			$res = $configObj->add($config);

			die(json::encode($res));


		}

	}

	public function indexconfigListAction()
	{

		$configObj = new \config\configsIndexModel();
		$data = $configObj->getConfigList();
		$this->getView()->assign('data',$data);
	}

	public function editIndexconfigAction()
	{
		$configObj = new \config\configsIndexModel();
		if(IS_POST){
			$config = array();
			$config['id'] = safe::filterPost('id','int');
			$config['type'] = safe::filterPost('type');
			$config['sub_title'] = safe::filterPost('sub_title');
			$config['title'] = safe::filterPost('title');
			$config['sort'] = safe::filterPost('sort','int');
			$config['pic_num'] = safe::filterPost('pic_num','int');
			$res = $configObj->update($config);

			die(json::encode($res));


		}
		else{
			$id = $this->getRequest()->getParam('id');
			$id = safe::filter($id,'int');
			if($id){
				$data = $configObj->get($id);
				$this->getView()->assign('data',$data);

			}
		}
	}

	/**
	 * 删除配置项
	 */
	public function delIndexconfigAction(){
		if(IS_POST){
			$configObj = new \config\configsIndexModel();
			$id = $this->getRequest()->getParam('id');
			$id = safe::filter($id,'int');

			if($id){
				$res = $configObj->delete($id);
				die(json::encode($res)) ;
			}
		}

	}

	public function addofferlistAction(){
		$id = $this->getRequest()->getParam('id');
		$id = safe::filter($id,'int');
		if(IS_POST){

		}
		else{
			//获取所有市场
			$proObj = new \nainai\offer\product();
			$topCate = $proObj->getTopCate();
			$this->getView()->assign('topCate',$topCate);
			$this->getView()->assign('configId',$id);

		}
	}

	/**
	 * 获取下级子分类
	 */
	public function ajaxnextlevelCateAction(){
		$configObj = new\OfferManageModel();
		$pid = safe::filterGet('pid','int',0);
		if($pid>0){
			$res = $configObj->getNextCate($pid);
			die(JSON::encode($res)) ;
		}
		echo JSON::encode(array());
		exit;
	}

	public function ajaxGetSearchProductAction(){
		$searchArray = array(
			'username'=> safe::filterGet('username'),
			'start_time' => safe::filterGet('start_time'),
			'end_time' => safe::filterGet('end_time'),
			'area'=> safe::filterGet('area'),
			'mode'=> safe::filterGet('mode','int',-1),
			'market_id' => safe::filterGet('market_id','int',0),
			'cate_id' => safe::filterGet('cate_id','int',0)
		);

		if($searchArray['mode']==5){
			$searchArray['sub_mode'] = 1;
			unset($searchArray['mode']);
		}
		elseif($searchArray['mode']==6){
			$searchArray['sub_mode'] = 2;
			unset($searchArray['mode']);
		}
		$offerObj = new\OfferManageModel();
		$result = $offerObj->getSearchProduct($searchArray);
		die(JSON::encode($result));
	}

	public function ajaxAddSearchProductAction()
	{
		$jsonData = $_POST;
		foreach($jsonData['ids'] as &$val){
			$val = safe::filter($val,'int');
		}
		$configObj = new \config\configsIndexModel();
		if(isset($jsonData['configId']) && $jsonData['configId']>0){
			$res = $configObj->addConfigIds($jsonData['configId'],$jsonData['ids']);
			die(JSON::encode($res));
		}
		die(JSON::encode(array('success'=>0)));

	}

	//显示配置的商品列表
	public function configproListAction()
	{
		$config_id = $this->getRequest()->getParam('id');
		$page = safe::filterGet('page','int',1);
		$this->getView()->assign('config_id',$config_id);
		$configObj = new \config\configsIndexModel();
		$data = $configObj->getConfigProducts($config_id,$page);
		$this->getView()->assign('data',$data);


	}

	public function configproDelAction()
	{
		$proId = $this->getRequest()->getParam('proid');
		$configId = $this->getRequest()->getParam('config_id');
		$configObj = new \config\configsIndexModel();
		$res = $configObj->delConfigProduct($configId,$proId);
		die(JSON::encode($res));
	}

	public function ajaxChgprosortAction(){
		$offer_id = safe::filterPost('id','int');
		$sort = safe::filterPost('sort','int');
		$obj = new \Library\M('product_offer');
		$res = $obj->where(array('id'=>$offer_id))->data(array('offer_sort'=>$sort))->update();
		if($res){
			die(JSON::encode(\Library\tool::getSuccInfo()));
		}
		else
			die(JSON::encode(\Library\tool::getSuccInfo(0,'操作失败')));
	}


	public function workdaylistAction(){
	    $bank = safe::filterGet('bank');
	    $workDayObj = new \nainai\system\workday();
	    $where = array();
	    if($bank!='all'){
	        $where = array('bank'=>$bank);
        }
        $data = $workDayObj->lists($where);
	    $this->getView()->assign('bank',$bank);
	    $this->getView()->assign('data',$data);
    }

    public function workdayDelAction(){
	    $id = safe::filterGet('id');
        $workDayObj = new \nainai\system\workday();
        $res = $workDayObj->delete($id);
        die(json::encode($res));
    }

    public function workdayAddAction(){
	    if(IS_POST){
             $data = array(
                 'bank'=>safe::filterPost('bank'),
                 'day' => safe::filterPost('day'),
                 'type' => safe::filterPost('type')
             );

            $workDayObj = new \nainai\system\workday();
            $res = $workDayObj->add($data);
            die(json::encode($res));
        }else{

        }
    }

    public function workdayCopyAction(){
         if(IS_POST){
             $from = safe::filterPost('from');
             $to = safe::filterPost('to');
             $workDayObj = new \nainai\system\workday();
             $res = $workDayObj->copy($from,$to);
             die(json::encode($res));
         }
    }
}
 ?>