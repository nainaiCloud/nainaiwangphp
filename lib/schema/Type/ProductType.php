<?php
namespace schema\Type;

use schema\Types;
use schema\MyTypes;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use schema\Data\Handle;
use GraphQL\Deferred;

class ProductType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'product',
            'description' => '��Ʒ����',
            'fields' => function() {
                return [
                    'id'      => Types::id(),
                    'user_id' => Types::id(),
                    'name' => ['type'=>Types::string(),'description'=>'��Ʒ����'],
                    'market_id' =>['type'=>Types::id(),'description'=>'�г�id'],
                    'cate_id' => ['type'=>Types::id(),'description'=>'����id'],
                    'unit'    => ['type'=>Types::string(),'description'=>'��λ'],
                    'produce_area'    => [
                        'type'=>Types::string(),
                        'description'=>'���ص���',
                        'resolve' => function($val,$args,$context,ResolveInfo $info){
                            return Handle::fieldTransfer($val,$args,$context,$info);
                        }
                    ],
                    'attr_json' => [
                        'type'=>Types::string(),
                        'description'=>'���Ե�json��ʽ',
                        'resolve' => function($val,$args,$context,ResolveInfo $info){
                            return Handle::fieldTransfer($val,$args,$context,$info);

                        }
                        ],
                    'note'    => ['type'=>Types::string(),'description'=>'��ע'],
                    'produce_address'    => ['type'=>Types::string(),'description'=>'������ַ'],
                    'create_time' => ['type'=>Types::string(),'description'=>'ʱ��'],
                    'img'     => ['type'=>Types::string(),'description'=>'ͼƬ��ַ'],
                    'attribute' => [
                        'type'=> Types::listOf(MyTypes::attribute()),
                        'description' => '��Ʒ������',
                        'resolve' => function($val,$args,$context,ResolveInfo $info){
                            return $this->resolveAttr($val,$args,$context, $info);
                        }
                    ]
                ];
            },




        ];
        parent::__construct($config);
    }

    /**
     *
     * @param $val
     * @param $args
     * @param $context
     * @param ResolveInfo $info
     * @return Deferred
     */
    public function resolveAttr($val,$args,$context,ResolveInfo $info){
        $attr = unserialize($val['attribute']);

        Handle::bufferAddIDs(array_keys($attr),$info);

        return new Deferred(function () use ($val, $args, $context, $info) {
            Handle::loadBuffer($args,$context,$info);
            $attr = unserialize($val['attribute']);
            $args['ids'] = array_keys($attr);
            //attribute���͵�findlistֻ���������б��������Ե�value���
            $res = Handle::findList($val, $args, $context, $info);

            //�������value
            if(!empty($res)){
                foreach($res as $key=>$a){
                    $res[$key]['value'] = $attr[$a['id']];
                }
            }


            return !empty($res)?$res : null;
        });
    }







}
