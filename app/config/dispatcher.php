<?php

use \Phalcon\Mvc\Dispatcher as Dispatcher;
use \Phalcon\Events\Manager as EventsManager;
use \Phalcon\Mvc\Dispatcher\Exception as DispatchException;


$di->setShared('dispatcher', function() {
	
	$dispatcher = new Dispatcher();

	$eventsManager = new EventsManager();
	$eventsManager->attach("dispatch:beforeException", function($event, $dispatcher, $exception) {

		if ($exception instanceof DispatchException) {
			$dispatcher->forward(array(
				'controller' => 'error',
				'action'     => 'show404',
				'params'     => array(
					'exception' => $exception
				)
			));
			return false;
		}

		$dispatcher->forward(array(
			'controller' => 'error',
			'action'     => 'show503',
			'params'     => array(
				'exception' => $exception
			)
		));

		return false;
	});


	$dispatcher->setEventsManager($eventsManager);
	return $dispatcher;
});