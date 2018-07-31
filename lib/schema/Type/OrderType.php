<?php
namespace schema\Type;

use schema\Data\User;
use schema\Types;
use schema\MyTypes;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use schema\Data\Handle;
use GraphQL\Deferred;

class OrderType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Order',
            'description' => 'order data',
            'fields' => function() {
                return [
                    'id' => Types::id(),






                ];
            }


        ];
        parent::__construct($config);
    }






}
