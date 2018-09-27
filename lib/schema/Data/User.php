<?php
namespace schema\Data;

use \Library\M;
use \Library\Query;

class User extends Template
{

    protected $except = array('bank','invoice','dealer');
    protected  $table = 'user';

    protected  $primaryKey = 'id';

    protected  $buffer = array();

    protected  function selectData($args, $context, $ids=array() ,$fields = '*')
    {
        if(!empty($ids)){
            $where = array('id'=>array('in',join(',',$ids)));
        }else{
            $where = array('id'=>$args['id']);
        }
        $obj = new M($this->table);
        $data = $obj->fields($fields)->where($where)->select();
        return $data;
    }

    protected  function getOneBuffer($args){
        $id = $args['id'];
        if(!empty($this->buffer) && isset($this->buffer[$id])){
            return $this->buffer[$id];
        }else{
            return array();
        }
    }

    /**
     * 根据参数和字段，从数据库查找一条数据
     * @param $args
     * @param array $fields
     * @return mixed
     */
    protected  function getOneData($args,$fields=array())
    {
        if(isset($args['id']) && $args['id']){
            $where['id'] = $args['id'];
        }
        if(isset($args['mobile']) && $args['mobile']){
            $where['mobile'] = $args['mobile'];
        }

        if(isset($args['true_name']) && $args['true_name']){
            $where['true_name'] = $args['true_name'];
        }
        if(isset($args['type']) && in_array($args['type'],array(0,1))){
            $where['type'] = $args['type'];
        }

        $obj = new M('user');
        if(empty($where)){
            return array();
        }

        $data = $obj->fields($fields)->where($where)->getObj();
        return $data;
    }

    protected  function getMoreData($args, $context, $fields='*'){
        $obj = new Query('user');
        $obj->page = isset($args['page']) ? $args['page'] : 1;
        $obj->pagesize = isset($args['pagesize']) ? $args['pagesize'] : 20;
        $obj->fields = $fields;
        $bind = array();$where = '';
        if(isset($args['true_name'])){
            $where = 'true_name=:true_name';
            $bind['true_name'] = $args['true_name'];
        }
        if(isset($args['status'])){
            $where .= $where==''? 'status=:status ' : ' and status=:status';
            $bind['status'] = $args['status'];
        }
        if(isset($args['type'])){
            $where .= $where==''? 'type=:type ' : ' and type=:type';
            $bind['type'] = $args['type'];
        }
        $obj->where = $where;
        $obj->bind = $bind;
        $list = $obj->find();
        return $list;
    }









}
