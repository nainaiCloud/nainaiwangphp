<?php
namespace schema\Type;

use schema\AppContext;
use schema\Data\DataSource;
use schema\Data\User;
use schema\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

class CompanyType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Company',
            'description' => '��ҵ��Ϣ',
            'fields' => function() {
                return [
                    'user_id' => Types::id(),
                    'company_name' => ['type'=>Types::string(),'description'=>'��ҵ����'],
                    'legal_person' => ['type'=>Types::string(),'description'=>'����'],
                    'contact' => ['type'=>Types::string(),'description'=>'��ϵ��'],
                    'contact_phone' => ['type'=>Types::string(),'description'=>'��ϵ�˵绰'],
                    'area' => ['type'=>Types::string(),'description'=>'����'],
                    'adress' => ['type'=>Types::string(),'description'=>'��ϸ��ַ'],
                    'business' => ['type'=>Types::string(),'description'=>'��Ӫ��Ʒ'],
                ];
            },



        ];
        parent::__construct($config);
    }





}
