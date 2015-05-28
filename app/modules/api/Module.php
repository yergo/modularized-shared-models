<?php

namespace Application\Api;

use \Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
	
	/**
	 * Registering loaders for API module controllers.
	 */
	public function registerAutoloaders()
	{

		$loader = new \Phalcon\Loader();

		$loader->registerNamespaces(array(
			'Application\Api\Controllers' => APPLICATION_PATH . '/modules/api/controllers/',
		));

		$loader->register();
	}

	/**
	 * Register the services here to make them general or register in the ModuleDefinition to make them module-specific
	 */
	public function registerServices($di)
	{
		
		//Registering a dispatcher namespace
		$di->getDispatcher()->setDefaultNamespace("Application\Api\Controllers");

		//Registering the view component
		$di->getView()->disable();

	}

}