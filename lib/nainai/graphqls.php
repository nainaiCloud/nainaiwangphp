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
                $schema,//必须
                $query,//必须
                null,//传给QueryType的__construct函数的resolveField的第一个参数
                $appContext,//传给QueryType的__construct函数的resolveField的第三个参数
                (array) $variables//与查询字符串一起传递的参数
            );
            $output = $result->toArray(true);
            $httpStatus = 200;
        } catch (\Exception $error) {
            $httpStatus = 500;
            $output['errors'] = [
                FormattedError::createFromException($error, $debug)
            ];


        }
       // $schema->assertValid();
        //print_r($output);
        //header('Content-Type: application/json', true, $httpStatus);
        return $output;
    }
}
