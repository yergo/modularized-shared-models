<?php

error_reporting(E_ALL & E_NOTICE);
ini_set('display_errors', 1);

defined('APPLICATION_ENV') || define('APPLICATION_ENV', getenv('APPLICATION_ENV') ?: 'developer');
defined('APPLICATION_DIR') || define('APPLICATION_DIR', 'app');
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../' . APPLICATION_DIR) . '/');

try {
	
	/**
	 * Read the configuration
	 */
	$config	 = new Phalcon\Config\Adapter\Ini(APPLICATION_PATH . 'config/config.ini');
	$di		 = new Phalcon\DI\FactoryDefault();
	$di->set('config', $config);

	$application = new \Phalcon\Mvc\Application($di);

	include_once(APPLICATION_PATH . 'autoload.php');

	echo $application->handle()->getContent();
	
} catch(\Exception $e) {
	/**
	 * @todo better handler
	 */
	var_dump($e);
}
