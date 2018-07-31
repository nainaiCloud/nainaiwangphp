<?php
namespace schema\Type;

use schema\Types;
use schema\MyTypes;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use schema\Data\Handle;

class AttributeType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'attribute',
            'description' => '��������',
            'fields' => function() {
                return [
                    'id'      => Types::id(),
                    'name' => ['type'=>Types::string(),'description'=>'��������'],
                    'value'   => ['type'=>Types::string(),'description'=>'����ֵ'],
                    'note'    =>  ['type'=>Types::string(),'description'=>'��������'],
                ];
            },



        ];
        parent::__construct($config);
    }





}
