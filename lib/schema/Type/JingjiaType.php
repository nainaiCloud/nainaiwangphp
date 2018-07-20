<?php
namespace schema\Type;

use schema\Types;
use schema\MyTypes;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use schema\Data\Handle;

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
                    'accept_area_code' => Types::string(),
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
                ];
            },




        ];
        parent::__construct($config);
    }





}
