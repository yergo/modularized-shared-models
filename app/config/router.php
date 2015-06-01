<?php

//use Phalcon\Mvc\Router\Annotations as Router;
use Phalcon\Mvc\Router as Router;
use Phalcon\CLI\Router as CliRouter;

/**
 * Registering a router
 */
$di->setShared('router', function () use ($application, $config) {

	if($application instanceof Phalcon\CLI\Console) {
		return new CliRouter();
	}

	$router = new Router(false);

	$router->setDefaultModule("frontend");
	$router->setUriSource(\Phalcon\Mvc\Router::URI_SOURCE_GET_URL);
	$router->removeExtraSlashes(TRUE);

	foreach($application->getModules() as $key => $module) {

		$prefix = $key == 'frontend' ? '' : ('/' . $key);

		$router->add($prefix . '/:params', array(
			'module'	 => $key,
			'controller' => 'index',
			'action'	 => 'index',
			'params'	 => 1
		))->setName($key);

		$router->add($prefix . '/:controller/:params', array(
			'module'	 => $key,
			'controller' => 1,
			'action'	 => 'index',
			'params'	 => 2
		));

		$router->add($prefix . '/:controller/:action/:params', array(
			'module'	 => $key,
			'controller' => 1,
			'action'	 => 2,
			'params'	 => 3
		));

	}


	return $router;
});

