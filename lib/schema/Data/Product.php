<?php
namespace schema\Data;

use \Library\M;
use \Library\Query;
/**
 * Class DataSource
 *

 */
class Product extends Template
{



    protected  $table = 'products';

    protected $except = array('attrs');

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


    /**
     * ���ݲ�������buffer�в���һ������
     * @param $args
     * @return array|mixed
     */
    protected  function getOneBuffer($args){
        $id = $args['id'];
        if(!empty( $this->buffer) && isset($this->buffer[$id])){
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
    protected  function getOneData($args,$fields='*')
    {
        $id = $args['id'];
        $where = array('id'=>$id);
        $obj = new M($this->table);
        $data = $obj->fields($fields)->where($where)->getObj();
        return $data;
    }

    protected  function getMoreData($args, $context, $fields='*')
    {
        return array();
    }


}
