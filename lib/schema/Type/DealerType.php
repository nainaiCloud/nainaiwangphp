<?php
namespace schema\Type;

use schema\Types;
use GraphQL\Type\Definition\ObjectType;

class DealerType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'dealer',
            'description' => 'dealer data',
            'fields' => function() {
                return [
                    'user_id' => Types::id(),
                    'status' => ['type'=>Types::int(),'description'=>'认证状态'],
                    'apply_time'   => ['type'=>Types::string(),'description'=>'申请时间'],
                    'verify_time' => ['type'=>Types::string(),'description'=>'审核时间']

                ];
            },



        ];
        parent::__construct($config);
    }





}
