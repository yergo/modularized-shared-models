<?php

namespace Application\Frontend;

use Phalcon\Mvc\ModuleDefinitionInterface;


class Module implements ModuleDefinitionInterface
{

	public function registerAutoloaders()
	{

		$loader = new \Phalcon\Loader();

		$loader->registerNamespaces(array(
			'Application\Frontend\Controllers' => '../app/modules/frontend/controllers/',
		));

		$loader->register();
		
	}

	/**
	 * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
	 */
	public function registerServices($di)
	{

		//Registering a dispatcher namespace
		$di->getDispatcher()->setDefaultNamespace("Application\Frontend\Controllers");

		//Registering the view component
		$di->getView()->setViewsDir(realpath(dirname(__FILE__)). '/views/');

	}

}