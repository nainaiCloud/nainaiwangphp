<?php
namespace schema\Type;

use schema\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

class BankType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Bank',
            'description' => 'bank data',
            'fields' => function() {
                return [
                    'user_id' => Types::id(),
                    'bank_name' => ['type'=>Types::string(),'description'=>'��������'],
                    'card_no'   => ['type'=>Types::string(),'description'=>'����'],
                    'true_name' => ['type'=>Types::string(),'description'=>'����������'],
                    'proof'     => ['type'=>Types::string(),'description'=>'����֤��'],
                    'status'    => ['type'=>Types::int(),'description'=>'״̬��1����ͨ��'],
                ];
            },



        ];
        parent::__construct($config);
    }





}
