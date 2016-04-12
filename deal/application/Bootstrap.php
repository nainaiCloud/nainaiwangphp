<?php
/**
 * @name Bootstrap
 * @author root
 * @desc 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * @see http://www.php.net/manual/en/class.yaf-bootstrap-abstract.php
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
class Bootstrap extends \Yaf\Bootstrap_Abstract{

    public function _initConfig(Yaf\Dispatcher $dispatcher) {
		//把配置保存起来
		$this->config = Yaf\Application::app()->getConfig();
		Yaf\Registry::set('config', $this->config);

		define('REQUEST_METHOD', strtoupper($dispatcher->getRequest()->getMethod()));
	}

	public function _initPlugin(Yaf\Dispatcher $dispatcher) {
		//注册一个插件
		$objSamplePlugin = new SamplePlugin();
		$dispatcher->registerPlugin($objSamplePlugin);
	}

	public function _initRoute(Yaf\Dispatcher $dispatcher) {
		//注册路由
		$router = Yaf\Dispatcher::getInstance()->getRouter();
		$router->addConfig(Yaf\Registry::get("config")->routes);

	}
	
	public function _initView(Yaf\Dispatcher $dispatcher){
		$view = new \views\wittyAdapter(\Yaf\Registry::get("config")->witty);
		$dispatcher->setView($view);
	}
}
