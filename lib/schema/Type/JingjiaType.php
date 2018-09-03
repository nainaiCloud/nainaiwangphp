<?php
namespace schema\Type;

use schema\Types;
use schema\MyTypes;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use schema\Data\Handle;
use GraphQL\Deferred;

class JingjiaType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Jingjia',
            'description' => '竞价数据',
            'fields' => function() {
                return [
                    'id'      => Types::id(),
                    'user_id' => Types::id(),
                    'sub_mode' => Types::int(),//子报盘模式，1：竞价
                    'product_id' => Types::id(),//产品id
                    'pro_name' => Types::string(),
                    'old_offer'=> Types::id(),
                    'price'    => Types::float(),//成交后价格
                    'price_l'    => Types::float(),//起拍价
                    'price_r'    => Types::float(),
                    'accept_area_code' => [
                        'type'=>Types::string(),
                        'description'=>'收货地区',
                        'args' => [
                            'type'=>Types::int(),
                            'defaultValue'=>0,//为0返回解析出的中文地区，为1返回地区码
                            'name'=>'type'
                        ],
                        'resolve' => function($val, $args, $context, ResolveInfo $info){
                            return Handle::fieldTransfer($val,$args,$context,$info);
                         }
                        ],
                    'accept_area'=> Types::string(),
                    'accept_day' => Types::string(),
                    'acc_type'   => Types::string(),
                    'status'     => Types::int(),
                    'start_time' => Types::string(),
                    'end_time'   => Types::string(),
                    'max_num'    => Types::float(),
                    'jing_stepprice' => Types::float(),
                    'jingjia_mode' => Types::int(),
                    'jingjia_pass' => Types::int(),
                    'jingjia_deposit' => Types::float(),
                    'views'      => Types::int(),
                    'pay_days'   => Types::string(),
                    'other'      => Types::string(),

                    'seller'    => [
                        'type'=>MyTypes::User(),
                        'description'=>'卖方信息',
                        'args' => [
                            'id' => Types::id()
                        ],
                        'resolve' => function($val, $args, $context, ResolveInfo $info){
                            $args['id'] = $val['user_id'];
                            $res = Handle::findOne($val, $args, $context, $info);
                            return !empty($res)?$res : null;
                        }
                    ],
                    'baojia'    => [
                        'type'=>MyTypes::listOf(MyTypes::jingjiaBaojia()),
                        'description'=>'竞价的报价信息',
                        'args' => [
                            'offer_id' => Types::id()
                        ],
                        'resolve' => function($val, $args, $context, ResolveInfo $info){
                            $args['offer_id'] = $val['id'];
                            $res = Handle::findlist($val, $args, $context, $info);
                            return !empty($res)?$res : null;
                        }
                    ],
                    'product'   => [
                        'type' => MyTypes::product(),
                        'description' => '竞价的产品数据',

                        'resolve' => function($val,$args,$context,ResolveInfo $info){
                            Handle::bufferAdd($val['product_id'],$info);
                            return new Deferred(function () use ($val, $args, $context, $info) {
                                Handle::loadBuffer($args,$context,$info);
                                $args['id'] = $val['product_id'];
                                $res = Handle::findOne($val, $args, $context, $info);
                                return !empty($res)?$res : null;
                            });
                        }
                    ]
                ];
            },




        ];
        parent::__construct($config);
    }





}
