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
                    'description' => '�û�����',
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
                       // 'username' => Types::nonNull(Types::string())
                    ],
                ],
                'users'   => [
                    'type' => Types::listOf(MyTypes::user()),
                    'description' => '�û������б�',
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
                    'description' => '��������',
                    'args' => [
                        'id' => [
                            'type'=>Types::id(),
                            'name'=>'id',
                            'defaultValue'=>0
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