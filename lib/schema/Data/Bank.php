<?php
namespace schema\Data;

use \Library\M;
use \Library\Query;
/**
 * Class DataSource
 *

 */
class Bank extends Template
{

    protected  $fields = array('user_id','bank_name','card_no','true_name','proof','status');


    protected  $table = 'user_bank';

    protected  $primaryKey = 'user_id';

    protected  $buffer = array();



    protected  function selectData($args, $context, $ids=array() ,$fields = '*')
    {

        if(!empty($ids)){
            $where = array('user_id'=>array('in',join(',',$ids)));
        }else{
            $where = array('user_id'=>$args['user_id']);
        }
        if(isset($args['status'])){
            $where['status'] = $args['status'];
        }
        $obj = new M($this->table);
        $data = $obj->fields($fields)->where($where)->select();
        return $data;
    }


    /**
     * 根据参数，从buffer中查找一条数据
     * @param $args
     * @return array|mixed
     */
    protected  function getOneBuffer($args){
        $id = $args['user_id'];
        if(!empty( $this->buffer) && isset($this->buffer[$id])){
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
    protected  function getOneData($args,$fields='*')
    {
        $id = $args['user_id'];
        $where = array('user_id'=>$id);
        if(isset($args['status'])){
            $where['status'] = $args['status'];
        }
        $obj = new M($this->table);
        $data = $obj->fields($fields)->where($where)->getObj();
        return $data;
    }

    protected  function getMoreData($args, $context, $fields='*')
    {
        return array();
    }


}
