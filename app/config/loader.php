<?php

$loader = new \Phalcon\Loader();

$loader->registerDirs(
    array(
       APPLICATION_PATH . $di->getConfig()->application->tasksDir,
    )
);


$loader->registerNamespaces(array(
	'Application\Models' => APPLICATION_PATH . $config->application->modelsDir,
	'Application\Models\Entities' => APPLICATION_PATH . $config->application->modelsDir . 'entities/',
	'Application\Models\Services' => APPLICATION_PATH . $config->application->modelsDir . 'services/',
));

$loader->register();