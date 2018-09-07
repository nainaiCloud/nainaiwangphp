<?php
/**
 * @date 2018-8-28
 * 银行流水管理
 *
 */

use \Library\M;
use \Library\Query;
use \Library\searchQuery;
use \Library\tool;
class BankflowModel{

	//模型对象实例
    protected $tableName = 'mock_jsbank';
	protected $bankObj;
	public function __construct(){
		$this->bankObj = new M($this->tableName);
	}


	/**
	 * 获取列表
	 * @param  int $page 当前页index
	 * @return array
	 */
	public function getList($page){
		$Q = new Query($this->tableName.' as a');
		//$Q->join = 'left join admin_role as r on a.role = r.id';
		$Q->page = $page;
		$Q->pagesize = 20;
		$Q->order = ' a.id desc ';
		//$Q->fields = "a.*,r.name as role_name";
		//$Q->order = "a.create_time desc";
		//$Q->where = "a.name <> '$super_admin' and a.status >= 0 ".($name ? " and a.name like '%$name%'" : '');
		$data = $Q->find();
		$pageBar =  $Q->getPageBar();
		return array('data'=>$data,'bar'=>$pageBar);
	}
	
	public function add($data){
	    $data['TX_DT'] = \Library\time::getDateTime('Y-m-d');
        $data['TX_TM'] = \Library\time::getDateTime('H:i:s');
        if(!isset($data['TX_AMT']) || !$data['TX_AMT']){
            return tool::getSuccInfo(0,'金额不能为空');
        }
        if(!isset($data['TX_LOG_NO']) || !$data['TX_LOG_NO']){
            return tool::getSuccInfo(0,'流水号不能为空');
        }
	    $res = $this->bankObj->data($data)->add();
	    if($res){
	        return tool::getSuccInfo();
        }else{
	        return tool::getSuccInfo(0,'添加失败');
        }
    }

    public function edit($id,$data){
	    $res = $this->bankObj->where(array('id'=>$id))->data($data)->update();
        if($res || $res===0){
            return tool::getSuccInfo();
        }else{
            return tool::getSuccInfo(0,'更新失败');
        }
    }

    public function get($id){
	    $data = $this->bankObj->where(array('id'=>$id))->getObj();
	    return $data;
    }

    public function delete($id){
	    $res = $this->bankObj->where(array('id'=>$id))->delete();
        if($res){
            return tool::getSuccInfo();
        }else{
            return tool::getSuccInfo(0,'删除失败');
        }
    }

}