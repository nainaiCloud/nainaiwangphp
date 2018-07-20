<?php
namespace schema\Type;

use schema\Types;
use schema\MyTypes;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use schema\Data\Handle;

class JingjiaBaojiaType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'JingjiaBaojia',
            'description' => '���۱�������',
            'fields' => function() {
                return [
                    'id'      => Types::id(),
                    'user_id' => Types::id(),//���۵��û�id
                    'offer_id' => Types::id(),//����id
                    'price' => [
                        'type'=>Types::float(),
                        'description'=>'���ۼ۸�'
                    ],
                    'win'   => [
                        'type' => Types::int(),
                        'description'=>'�Ƿ�ʤ����1��ʤ��'
                    ],
                    'time' => [
                        'type' => Types::string(),
                        'description'=>'����ʱ��'
                    ],
                    'amount' => [
                        'type' => Types::float(),
                        'description'=>'�ܼ۸�'
                    ],

                    'buyer'    => [
                        'type'=>MyTypes::User(),
                        'description'=>'���۷���Ϣ',
                        'args' => [
                            'id' => Types::id()
                        ],
                        'resolve' => function($val, $args, $context, ResolveInfo $info){
                            $args['id'] = $val['user_id'];
                            $res = Handle::findOne($val, $args, $context, $info);
                            return !empty($res)?$res : null;
                        }
                    ]
                ];
            },




        ];
        parent::__construct($config);
    }





}
