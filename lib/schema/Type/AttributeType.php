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
            'description' => '属性数据',
            'fields' => function() {
                return [
                    'id'      => Types::id(),
                    'name' => ['type'=>Types::string(),'description'=>'属性名称'],
                    'value'   => ['type'=>Types::string(),'description'=>'属性值'],
                    'note'    =>  ['type'=>Types::string(),'description'=>'属性描述'],
                ];
            },



        ];
        parent::__construct($config);
    }





}
