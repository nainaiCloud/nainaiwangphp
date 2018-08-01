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
            'description' => '产品数据',
            'fields' => function() {
                return [
                    'id'      => Types::id(),
                    'user_id' => Types::id(),
                    'name' => ['type'=>Types::string(),'description'=>'产品名称'],
                    'market_id' =>['type'=>Types::id(),'description'=>'市场id'],
                    'cate_id' => ['type'=>Types::id(),'description'=>'分类id'],
                    'unit'    => ['type'=>Types::string(),'description'=>'单位'],
                    'produce_area'    => [
                        'type'=>Types::string(),
                        'description'=>'产地地区',
                        'resolve' => function($val,$args,$context,ResolveInfo $info){
                            return Handle::fieldTransfer($val,$args,$context,$info);
                        }
                    ],
                    'attr_json' => [
                        'type'=>Types::string(),
                        'description'=>'属性的json形式',
                        'resolve' => function($val,$args,$context,ResolveInfo $info){
                            return Handle::fieldTransfer($val,$args,$context,$info);

                        }
                        ],
                    'note'    => ['type'=>Types::string(),'description'=>'备注'],
                    'produce_address'    => ['type'=>Types::string(),'description'=>'生产地址'],
                    'create_time' => ['type'=>Types::string(),'description'=>'时间'],
                    'img'     => ['type'=>Types::string(),'description'=>'图片地址'],
                    'attribute' => [
                        'type'=> Types::listOf(MyTypes::attribute()),
                        'description' => '商品的属性',
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
            //attribute类型的findlist只返回属性列表，不对属性的value填充
            $res = Handle::findList($val, $args, $context, $info);

            //填充属性value
            if(!empty($res)){
                foreach($res as $key=>$a){
                    $res[$key]['value'] = $attr[$a['id']];
                }
            }


            return !empty($res)?$res : null;
        });
    }







}
