<?php

namespace nainai\system;

use \Library\M;
use \Library\searchQuery;
use \Library\Tool;

class workday {

    public $pk = 'id';

    private $banks = array('js','gd');//建设银行，光大银行

    private $bankName = array(
        'js'=>'建设银行',
        'gd'=>'光大银行'
    );

    private $tableName = 'bank_workday';


	protected $rules = array(
	        array('bank','require','必须选择银行'),
	        array('day','date','日期格式不正确'),
	        array('type',array(1,2),'类型错误',0,'in'),
	);

	public function add($data){
	    if(!isset($data['bank']) || !isset($data['day']) || !isset($data['type'])){
	        return tool::getSuccInfo(0,'参数错误');
        }

        if(!in_array($data['bank'],$this->banks)){
	        return tool::getSuccInfo(0,'银行字段错误');
        }
        $obj = new M($this->tableName);
	    $id = $obj->where(array('bank'=>$data['bank'],'day'=>$data['day']))->getField('id');
	    if(!$id){
	        if($obj->data($data)->validate($this->rules)){
	            $res = $obj->add();

            }else{
	            $res = $obj->getError();
            }
        }else{
	        $res = '该日期已存在，不能再添加';
        }
        if(is_numeric($res) && $res > 0){
            $resInfo = tool::getSuccInfo();
        }
        else{
            $resInfo = tool::getSuccInfo(0,is_string($res) ? $res : '系统繁忙，请稍后再试');
        }
        return $resInfo;

    }

    public function delete($id){
        $obj = new M($this->tableName);
        $res = $obj->where(array('id'=>$id))->delete();
        if($res){
            return tool::getSuccInfo();
        }else{
            return tool::getSuccInfo(0,'删除失败');
        }


    }

    /**
     * 复制一个银行的数据到另一个银行，先删除另一个银行的原有数据
     * @param $bankFrom
     * @param $bankTo
     * @return array
     */
    public function copy($bankFrom,$bankTo){
	    //删除bankTo的所有日期
        if($bankFrom==$bankTo){
            return tool::getSuccInfo(0,'同一银行不能复制');
        }
        if(!in_array($bankTo,$this->banks)){
            return tool::getSuccInfo(0,'目标银行不存在');
        }
        $obj = new M($this->tableName);
        $obj->beginTrans();
        $obj->where(array('bank'=>$bankTo))->delete();
        $data = $obj->where(array('bank'=>$bankFrom))->fields('bank,type,day')->select();
        if(!empty($data)){
            foreach($data as &$item){
                $item['bank'] = $bankTo;
            }

            $obj->data($data)->adds();

        }
        if($obj->commit()){
            return tool::getSuccInfo();
        }else{
            $obj->rollBack();
            return tool::getSuccInfo(0,'复制失败');
        }


    }

    public function lists($where=array()){
        $wheres = array();
        if(isset($where['bank']) && in_array($where['bank'],$this->banks)){
            $wheres['bank'] = $where['bank'];
        }
        if(isset($where['type']) && in_array($where['type'],array(1,2))){
            $wheres['type'] = $where['type'];
        }

        $obj = new M($this->tableName);
        $data = $obj->where($wheres)->select();
        foreach($data as &$item){
            $item['bank'] = $this->bankName[$item['bank']];
        }
        return $data;


    }



}