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
                    'status' => ['type'=>Types::int(),'description'=>'��֤״̬'],
                    'apply_time'   => ['type'=>Types::string(),'description'=>'����ʱ��'],
                    'verify_time' => ['type'=>Types::string(),'description'=>'���ʱ��']

                ];
            },



        ];
        parent::__construct($config);
    }





}
