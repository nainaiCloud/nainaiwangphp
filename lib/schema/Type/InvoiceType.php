<?php
namespace schema\Type;

use schema\AppContext;
use schema\Data\DataSource;
use schema\Data\User;
use schema\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;

class InvoiceType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Invoice',
            'description' => '�û���Ʊ��Ϣ',
            'fields' => function() {
                return [
                    'user_id' => Types::id(),
                    'tax_no' => ['type'=>Types::string(),'description'=>'��˰��ʶ���'],
                    'address' => ['type'=>Types::string(),'description'=>'��Ʊ�˵�ַ'],
                    'phone' => ['type'=>Types::string(),'description'=>'��Ʊ�˵绰'],
                    'bank_name' => ['type'=>Types::string(),'description'=>'��������'],
                    'bank_no' => ['type'=>Types::string(),'description'=>'�����˺�'],
                ];
            },



        ];
        parent::__construct($config);
    }





}
