<?php
// Test this using following command
// php -S localhost:8080 ./graphql.php
namespace nainai;
require_once dirname(__DIR__) . '\vendor\autoload.php';

use \schema\Types;
use \GraphQL\Type\Schema;
use \GraphQL\GraphQL;
use \GraphQL\Error\FormattedError;
use \GraphQL\Error\Debug;

class graphqls{

    private $contextObj = null;

    public function __construct($context=null)
    {

    }

    public function query($query,$appContext=null,$variables=array()){

        $debug = false;
        if (!empty($_GET['debug'])) {
            set_error_handler(function($severity, $message, $file, $line) use (&$phpErrors) {
                throw new \ErrorException($message, 0, $severity, $file, $line);
            });
            $debug = Debug::INCLUDE_DEBUG_MESSAGE | Debug::INCLUDE_TRACE;
        }

        try {
            // GraphQL schema to be passed to query executor:
            $schema = new Schema([
                'query' => Types::query()
            ]);

            $result = GraphQL::executeQuery(
                $schema,//����
                $query,//����
                null,//����QueryType��__construct������resolveField�ĵ�һ������
                $appContext,//����QueryType��__construct������resolveField�ĵ���������
                (array) $variables//���ѯ�ַ���һ�𴫵ݵĲ���
            );
            $output = $result->toArray(true);
            //$httpStatus = 200;
        } catch (\Exception $error) {
            //$httpStatus = 500;
            $output['errors'] = [
                FormattedError::createFromException($error, $debug)
            ];
        }

        return $output;
    }
}
