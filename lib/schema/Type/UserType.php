<?php
namespace schema\Type;

use schema\Data\User;
use schema\Types;
use schema\MyTypes;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use schema\Data\Handle;
use GraphQL\Deferred;

class UserType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'User',
            'description' => 'user data',
            'fields' => function() {
                return [
                    'id' => Types::id(),
                    'type' => Types::int(),
                    'username' => ['type'=>Types::string()],
                    'true_name' => Types::string(),
                    'mobile' => Types::string(),
                    'email' => Types::string(),
                    'login_time' => Types::string(),

                    'invoice' => [
                        'type'=>MyTypes::Invoice(),
                        'description'=>'开票信息',
                        'args' => [
                            'user_id' => Types::id()
                        ],
                        'resolve' => function($val, $args, $context, ResolveInfo $info){
                            $args['user_id'] = $val['id'];
                            $res = Handle::findOne($val, $args, $context, $info);
                            return !empty($res)?$res : null;
                        }
                    ],

                    'company' => [
                        'type'=>MyTypes::Company(),
                        'description'=>'企业信息',
                        'args' => [
                            'user_id' => Types::id()
                        ],
                        'resolve' => function($val, $args, $context, ResolveInfo $info){
                            $args['user_id'] = $val['id'];
                            $res = Handle::findOne($val, $args, $context, $info);
                            return !empty($res)?$res : null;
                        }

                    ],

                    'bank' => [
                        'type' => MyTypes::bank(),
                        'description'=>'开户信息',
                        'args' => [
                            'user_id' => Types::id(),
                            'status' => Types::int()
                        ],
                        'resolve' => function($val, $args, $context, ResolveInfo $info){
                            Handle::bufferAdd($val['id'],$info);
                            return new Deferred(function () use ($val, $args, $context, $info) {
                                Handle::loadBuffer($args,$context,$info);
                                $args['user_id'] = $val['id'];
                                $res = Handle::findOne($val, $args, $context, $info);
                                return !empty($res)?$res : null;
                            });




                        }
                    ]



                ];
            }


        ];
        parent::__construct($config);
    }






}
