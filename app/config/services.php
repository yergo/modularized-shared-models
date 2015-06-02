<?php
/**
 * Services are globally registered in this file
 */

use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Session\Adapter\Files as SessionAdapter;

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di['url'] = function () {
    $url = new UrlResolver();
    $url->setBaseUri('/');

    return $url;
};

/**
 * Start the session the first time some component request the session service
 *
$di['session'] = function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
}; */

$di->set('voltService', function ($view, $di) {
    $cacheBaseDir = APPLICATION_PATH . $di->getConfig()->application->cacheDir . 'volt';

    if (!is_dir($cacheBaseDir)) {
        $umask = umask(0000);
        mkdir($cacheBaseDir, 0777, true);
        umask($umask);
    }

    $cacheBaseDir = realpath($cacheBaseDir);

    $options = array(
        'compiledPath' => function ($templatePath) use ($cacheBaseDir) {

            // Create cached file path
            $templatePath = realpath($templatePath);
            $cachedFilePath = $cacheBaseDir . str_replace(APPLICATION_PATH, '', $templatePath);
            $cachedFileDir = dirname($cachedFilePath);

            if (!is_dir($cachedFileDir)) {
                $umask = umask(0000);
                mkdir($cachedFileDir, 0777, true);
                umask($umask);
            }

            return $cachedFilePath;
        },
        'compileAlways' => true, // $di->getConfig()->application->env === 'dev',
    );

    $volt = new Phalcon\Mvc\View\Engine\Volt($view, $di);
    $volt->setOptions($options);

    return $volt;
});

$di->setShared('view', function() {
	
		$view = new \Phalcon\Mvc\View();

		$view->registerEngines(array(
			'.volt' => 'voltService'
		));

		return $view;
});