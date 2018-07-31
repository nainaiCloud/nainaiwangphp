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

    protected  $except = array();//�ų����ֶ�

    //array(f1=>f2,),f1����f2,�����ѯ��f1,�������f2
    protected $relyFeild = array();//�ֶ�֮�������
    protected  $table = '';

    protected  $primaryKey = 'id';

    protected  $buffer = array();

    /**
     * ����buffer,����ѯ������д��buffer
     * @param $args
     * @param $context
     * @param array $ids
     * @param array $fields
     */
    public final  function loadBuffer($args, $context,$ids=array(),$fields=array()){
        //�ų����ɲ�ѯ�ֶ�,��ȡ��ѯ���ֶ�
        $fields = $this->getFields($fields);

        //��ʼ��buffer
        $this->initBuffer($ids);
        //��ѯ����
        $data = $this->selectData($args, $context,$ids,$fields);
        //���buffer
        $this->fillBuffer($data);

    }

    /**
     * ����һ�����ݣ�����buffer���ң����û���ٵ����ݿ�����
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
        if(!empty($data)){//�ж�data���Ƿ����info�е������ֶΣ���δ�������ֶ������»�ȡ
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
     * ��ȡҪ��ѯ���ֶΣ��������еĲ����ڵ��ֶ��ų�
     * @param array $fields
     * @return string
     */
    protected   function getFields($fields=array()){
        if(!empty($fields)){
            if(!empty($this->relyFeild)){
                //���������ֶμӽ�ȥ
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
            //�����ѯ�ֶβ������������ӽ�ȥ
            if(!in_array($this->primaryKey,$fields)){
                $fields[] = $this->primaryKey;
            }
        }

        return join(',',$fields);
    }

    /**
     * ��ʼ��buffer,�������Ǳ���ĳ��id�����ݿ���û��ֵ��buffer�оͲ��������id
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
     * ������д��buffer
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
     * ���ݲ������ֶΣ������ݿ��ȡ��������
     * @param $args
     * @param $context
     * @param array $ids
     * @param array $fields
     * @return array ���ر�����array(id=>array(),id1=>array()...)
     */
    abstract protected  function selectData($args, $context,$ids=array(),$fields='*');



    /**
     * ���ݲ�������buffer�в���һ������
     * @param $args
     * @return array|mixed
     */
    abstract protected  function getOneBuffer($args);

    /**
     * ���ݲ������ֶΣ������ݿ����һ������
     * @param $args
     * @param array $fields
     * @return mixed
     */
    abstract protected  function getOneData($args,$fields='*');

    /**
     * ���Ҷ�������
     * @param $args
     * @param $context
     * @param string $fields
     * @return mixed
     */
    abstract protected  function getMoreData($args,$context,$fields='*');




}