<?php
/**
 * Created by PhpStorm.
 * User: weipinglee
 * Date: 2018/9/7
 * Time: 9:50
 */

namespace nainai;

class appInit
{

    private $dispatcher = null;
    private $config ;

    public function __construct($dispatcher)
    {
        $this->dispatcher = $dispatcher;
        $this->config = \Library\tool::getConfig();


    }

    public function init(){
        $this->initHttp();
        $this->initError();
    }

    private function initHttp(){
        define('REQUEST_METHOD', strtoupper($this->dispatcher->getRequest()->getMethod()));
        define('IS_GET',        REQUEST_METHOD =='GET' ? true : false);
        define('IS_POST',       REQUEST_METHOD =='POST' ? true : false);
        define('IS_PUT',        REQUEST_METHOD =='PUT' ? true : false);
        define('IS_DELETE',     REQUEST_METHOD =='DELETE' ? true : false);
        define('IS_AJAX',       ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) ? true : false);
         if(isset($this->config['http'])){
            if($this->config['http']['access_control_allow']){
                header("Access-Control-Allow-Origin : *");
                header("Access-Control-Allow-Credentials : true");
            }
        }

    }

    private function initError(){
        if($this->config['error']){
            error_reporting(E_ALL);
        }
        else{
            error_reporting(0);
        }
    }


}