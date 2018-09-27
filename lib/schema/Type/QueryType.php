<?php
namespace schema\Type;

use schema\Data\Handle;
use schema\Types;
use schema\MyTypes;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class QueryType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Query',
            'fields' => [
                'user' => [
                    'type' => MyTypes::user(),
                    'description' => '用户数据',
                    'args' => [
                        'id' => [
                                  'type'=>Types::id(),
                                  'name'=>'id',
                                   'defaultValue'=>0
                                 ],
                        'mobile' => [
                                   'type'=>Types::string(),
                                    'name'=>'mobile',
                                    'defaultValue'=>''
                            ],
                        'true_name' => [
                            'type'=>Types::string(),
                            'name'=>'true_name',
                            'defaultValue'=>''
                        ],
                        'type' => [
                            'type'=>Types::int(),
                            'name'=>'type'
                        ]
                       // 'username' => Types::nonNull(Types::string())
                    ],
                ],
                'users'   => [
                    'type' => Types::listOf(MyTypes::user()),
                    'description' => '用户数据列表',
                    'args' => [
                        'page' => [
                            'type'=>Types::int(),
                            'name'=>'page',
                            'defaultValue'=>1
                        ],
                        'pagesize' => [
                            'type'=>Types::int(),
                            'name'=>'pagesize',
                            'defaultValue'=>20
                        ],
                        'true_name' => [
                            'type'=>Types::string(),
                            'name'=>'true_name'
                        ],
                        'type' => [
                            'type'=>Types::int(),
                            'name'=>'type'
                        ],
                        'status'=> [
                            'type'=>Types::int(),
                            'name'=>'status',
                            'description'=>'用户状态，0正常'
                        ]
                        // 'username' => Types::nonNull(Types::string())
                    ],
                    'resolve' => function($val, $args, $context, ResolveInfo $info){
                        $res = Handle::findList($val, $args, $context, $info);
                        return !empty($res)?$res : null;
                    }
                ],

                'jingjia' => [
                    'type' => MyTypes::jingjia(),
                    'description' => '竞价数据',
                    'args' => [
                        'id' => [
                            'type'=>Types::id(),
                            'name'=>'id',
                            'defaultValue'=>0
                        ],
                        'pro_name' => [
                            'type' => Types::string(),
                            'name'=>'pro_name'
                        ]

                    ],
                ],


            ],
            'resolveField' => function($val, $args, $context, ResolveInfo $info) {//var_dump($info);
                $res = Handle::findOne($val, $args, $context, $info);
                return !empty($res)?$res : null;
            }
        ];
        parent::__construct($config);

    }





    public function deprecatedField()
    {
        return 'You can request deprecated field, but it is not displayed in auto-generated documentation by default.';
    }
}
