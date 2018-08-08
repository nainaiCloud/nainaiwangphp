<?php

//ÅäÖÃyaf
define('APPLICATION_PATH', __DIR__);
error_reporting(0);
date_default_timezone_set('Asia/Shanghai');
$app = new Yaf\Application(APPLICATION_PATH."/conf/application.ini");
$config = Yaf\Application::app()->getConfig();
\Yaf\Registry::set('config', $config);
//require_once __DIR__."/lib/nainai/jingjiaSocket.php";


use \nainai\jingjiaSocket;

$jingjia=new jingjiaSocket();
//$jingjia->receiveMessage();

$jingjia->run();
?>