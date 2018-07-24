<?php
namespace schema\Data;

use \Library\M;
use \Library\Query;
/**
 * Class DataSource
 *

 */
class Jingjia extends Template
{


    protected  $except = array('seller','baojia');//�ų����ֶ�


    protected  $table = 'product_offer';

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
        if(!empty( $this->buffer) && isset($this->$buffer[$id])){
            return $this->buffer[$id];
        }else{
            return array();
        }
    }

    /**
     * ���ݲ������ֶΣ������ݿ����һ������
     * @param $args
     * @param array $fields
     * @return mixed
     */
    protected  function getOneData($args,$fields=array())
    {
        if(isset($args['id']) && $args['id']){
            $where['id'] = $args['id'];
        }


        $obj = new M($this->table);
        if(empty($where)){
            return array();
        }

        $data = $obj->fields($fields)->where($where)->getObj();
        return $data;
    }

    protected  function getMoreData($args, $context, $fields='*'){
        $obj = new Query($this->table);
        $obj->page = isset($args['page']) ? $args['page'] : 1;
        $obj->pagesize = isset($args['pagesize']) ? $args['pagesize'] : 20;
        $obj->fields = $fields;
        $list = $obj->find();
        return $list;
    }







}
