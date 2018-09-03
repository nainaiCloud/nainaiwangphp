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
            'description' => '��������',
            'fields' => function() {
                return [
                    'id'      => Types::id(),
                    'user_id' => Types::id(),
                    'sub_mode' => Types::int(),//�ӱ���ģʽ��1������
                    'product_id' => Types::id(),//��Ʒid
                    'pro_name' => Types::string(),
                    'old_offer'=> Types::id(),
                    'price'    => Types::float(),//�ɽ���۸�
                    'price_l'    => Types::float(),//���ļ�
                    'price_r'    => Types::float(),
                    'accept_area_code' => [
                        'type'=>Types::string(),
                        'description'=>'�ջ�����',
                        'args' => [
                            'type'=>Types::int(),
                            'defaultValue'=>0,//Ϊ0���ؽ����������ĵ�����Ϊ1���ص�����
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
                        'description'=>'������Ϣ',
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
                        'description'=>'���۵ı�����Ϣ',
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
                        'description' => '���۵Ĳ�Ʒ����',

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
