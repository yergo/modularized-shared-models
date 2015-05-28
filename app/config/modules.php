<?php
/**
 * Register application modules
 */

$application->registerModules(array(
    'frontend' => array(
        'className' => 'Application\Frontend\Module',
        'path' => __DIR__ . '/../modules/frontend/Module.php'
    ),
    'api' => array(
        'className' => 'Application\Api\Module',
        'path' => __DIR__ . '/../modules/api/Module.php'
    )
));
