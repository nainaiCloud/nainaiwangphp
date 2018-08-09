<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/9
 * Time: 10:53
 */

namespace nainai;

require_once dirname(__DIR__)."/vendor/autoload.php";

use  Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
class syslog
{

       static private $logObj = array();
       static private $logInfo = array();//������־��Ϣ
       static public  function instance($channel='common'){
           if(!isset(self::$logObj[$channel])){
               self::$logObj[$channel] = new Logger($channel);
               self::handler($channel);

           }
       }


       static private function handler($channel){
           $stream = null;
            switch($channel){
                case 'common' :
                 default:
                    {
                    $logFile = \Library\tool::getConfig('log');
                   if(!isset($logFile['file'])){
                       $logFile['file'] = dirname(dirname(__DIR__)).'/log.txt';
                   }
                    if(!file_exists($logFile['file'])){
                        fopen($logFile['file'],'r');
                    }
                    try{
                        $stream = new StreamHandler($logFile['file']);
                        return self::$logObj[$channel]->pushHandler($stream,Logger::INFO);
                    }catch (\Exception $e){
                        return false;
                    }
                }

            }

       }


    /**
     * ����־��Ϣpush���ļ�
     * @param $info
     * @param string $channel
     */
       static public function info($info,$channel='common'){
             if(!isset(self::$logObj[$channel])){
                 self::instance($channel);
             }
             self::$logObj[$channel]->addInfo($info);
       }

       static public function warning($info,$channel='common'){
           if(!isset(self::$logObj[$channel])){
               self::instance($channel);
           }
           self::$logObj[$channel]->addWarning($info);
       }

    static public function error($info,$channel='common'){
        if(!isset(self::$logObj[$channel])){
            self::instance($channel);
        }
        self::$logObj[$channel]->addError($info);
    }








}