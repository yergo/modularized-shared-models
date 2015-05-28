<?php

$services = [
	'loader',
	'services',
	'modules',
	'router',
	'database',
	'dispatcher',
];

foreach($services as $service) {
	
	include_once(__DIR__ . '/config/' . $service . '.php');
	
}

//include_once(__DIR__ . '/../vendor/autoload.php');