<?php
/**
 * Statsutils console file
 */

$_SESSION = [];

define('VERSION', '1.0.0');

// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__)) . '/');

$config	 = new Phalcon\Config\Adapter\Ini(APPLICATION_PATH . "config/config.ini");
$di = new \Phalcon\DI\FactoryDefault\CLI();
$di->set('config', $config);

$application = new \Phalcon\CLI\Console($di);


require_once APPLICATION_PATH . 'autoload.php';

$di->setShared('console', $application);

/**
 * Process the console arguments
 */
$arguments = array();

foreach($argv as $k => $arg) {
    if($k == 1) {
        $arguments['task'] = $arg;
    } elseif($k == 2) {
        $arguments['action'] = $arg;
    } elseif($k >= 3) {
        $arguments[] = $arg;
    }
}

// define global constants for the current task and action
define('CURRENT_TASK', (isset($argv[1]) ? $argv[1] : null));
define('CURRENT_ACTION', (isset($argv[2]) ? $argv[2] : null));

$di->setShared('console', $application);

try {
    // handle incoming arguments
    $application->handle($arguments);
}
catch (\Phalcon\Exception $e) {
    echo $e->getMessage();
    exit(255);
}
