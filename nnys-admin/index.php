<?php

date_default_timezone_set('Asia/Shanghai');

header("Content-Type:text/html;charset=utf-8");
header('X-Frame-Options: SAMEORIGIN');
define('APPLICATION_PATH', __DIR__);

$application = new Yaf\Application( APPLICATION_PATH . "/conf/application.ini");

$application->bootstrap()->run();
?>
