<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/24
 * Time: 11:01
 */

namespace schema\Data;


abstract class Template
{
    protected  $fields = array();

    protected  $except = array();//排除的字段

    //array(f1=>f2,),f1依赖f2,如果查询有f1,则必须有f2
    protected $relyFeild = array();//字段之间的依赖
    protected  $table = '';

    protected  $primaryKey = 'id';

    protected  $buffer = array();

    /**
     * 加载buffer,将查询的数据写入buffer
     * @param $args
     * @param $context
     * @param array $ids
     * @param array $fields
     */
    public final  function loadBuffer($args, $context,$ids=array(),$fields=array()){
        //排除不可查询字段,获取查询的字段
        $fields = $this->getFields($fields);

        //初始化buffer
        $this->initBuffer($ids);
        //查询数据
        $data = $this->selectData($args, $context,$ids,$fields);
        //填充buffer
        $this->fillBuffer($data);

    }

    /**
     * 查找一条数据，先在buffer中找，如果没有再到数据库中找
     * @param $val
     * @param $args
     * @param $context
     * @param $info
     * @return mixed
     */
    public final  function findOne($val, $args, $context, $info){
        $data = $this->getOneBuffer($args);
        $fields = array_keys($info->getFieldSelection());
        $flag = true;
        if(!empty($data)){//判断data中是否包含info中的所有字段，有未包含的字段需重新获取
            foreach($fields as $f){
                if(!isset($data[$f])){
                    $flag=false;
                }
            }
        }

        if(empty($data) || !$flag){
            $fields = $this->getFields($fields);
            $data = $this->getOneData($args,$fields);
        }
        return $data;

    }

    public final  function findList($val, $args, $context, $info){
        $fields = array_keys($info->getFieldSelection());
        $fields = $this->getFields($fields);
        $data = $this->getMoreData($args,$context,$fields);
        $this->fillBuffer($data);
        return $data;

    }


    /**
     * 获取要查询的字段，将参数中的不存在的字段排除
     * @param array $fields
     * @return string
     */
    protected   function getFields($fields=array()){
        if(!empty($fields)){
            if(!empty($this->relyFeild)){
                //将依赖的字段加进去
                foreach($this->relyFeild as $key=>$f){
                    if(in_array($key,$fields) && !in_array($f,$fields)){
                        $fields[] = $f;
                    }
                }
            }
            if(!empty($this->except)){
                foreach($fields as $key=>$val){
                    if(in_array($val,$this->except)){
                        unset($fields[$key]);
                    }
                }
            }
            //如果查询字段不包含主键，加进去
            if(!in_array($this->primaryKey,$fields)){
                $fields[] = $this->primaryKey;
            }
        }

        return join(',',$fields);
    }

    /**
     * 初始化buffer,这样做是避免某个id在数据库中没有值，buffer中就不存在这个id
     * @param $ids
     */
    protected  function initBuffer($ids){
        if(!empty($ids)){
            foreach($ids as $id){
                $this->buffer[$id] = array();
            }
        }

    }

    /**
     * 将数据写入buffer
     * @param $data
     */
    protected  function fillBuffer($data){
        if(!empty($data)){
            foreach($data as $item){
                $this->buffer[$item[$this->primaryKey]] = $item;
            }
        }
    }


    /**
     * 根据参数及字段，从数据库获取多条数据
     * @param $args
     * @param $context
     * @param array $ids
     * @param array $fields
     * @return array 返回必须是array(id=>array(),id1=>array()...)
     */
    abstract protected  function selectData($args, $context,$ids=array(),$fields='*');



    /**
     * 根据参数，从buffer中查找一条数据
     * @param $args
     * @return array|mixed
     */
    abstract protected  function getOneBuffer($args);

    /**
     * 根据参数和字段，从数据库查找一条数据
     * @param $args
     * @param array $fields
     * @return mixed
     */
    abstract protected  function getOneData($args,$fields='*');

    /**
     * 查找多条数据
     * @param $args
     * @param $context
     * @param string $fields
     * @return mixed
     */
    abstract protected  function getMoreData($args,$context,$fields='*');




}