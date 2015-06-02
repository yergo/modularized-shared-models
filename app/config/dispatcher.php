<?php

use \Phalcon\Mvc\Dispatcher as Dispatcher;
use \Phalcon\Events\Manager as EventsManager;
use \Phalcon\Mvc\Dispatcher\Exception as DispatchException;

if (!$di instanceof \Phalcon\DI\FactoryDefault\CLI) {
	$di->setShared('dispatcher', function() {

		$dispatcher = new Dispatcher();

		$eventsManager = new EventsManager();
		$eventsManager->attach("dispatch:beforeException", function($event, $dispatcher, $exception) {

			// handle dispatch exceptions
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

			// handle all other exceptions
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
}