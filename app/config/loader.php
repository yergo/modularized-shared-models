<?php

$loader = new \Phalcon\Loader();

$loader->registerNamespaces(array(
	'Application\Models' => $config->application->modelsDir,
	'Application\Models\Entities' => $config->application->modelsDir . 'entities/',
	'Application\Models\Services' => $config->application->modelsDir . 'services/',
));

$loader->register();