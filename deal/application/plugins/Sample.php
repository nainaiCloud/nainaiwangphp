<?php
/**
 * @name SamplePlugin
 * @desc Yaf定义了如下的6个Hook,插件之间的执行顺序是先进先Call
 * @see http://www.php.net/manual/en/class.yaf-plugin-abstract.php
 * @author root
 */
class SamplePlugin extends Yaf\Plugin_Abstract {

	public function routerStartup(\Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
		$static = new \nainai\statistics();
		$static->createStatistics();

	}

	public function routerShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
		$market = new \nainai\market();
		$market->checkCanOper($request);
	}

	public function dispatchLoopStartup(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
	}

	public function preDispatch(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {

	}

	public function postDispatch(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {

	}

	public function dispatchLoopShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) {
		//echo $request->getActionName();
	}
}
