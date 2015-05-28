<?php

use Phalcon\Mvc\Model\MetaData\Apc as MetaDataApcAdapter;
use Phalcon\Mvc\Model\MetaData\XCache as MetaDataXCacheAdapter;
use Phalcon\Mvc\Model\MetaData\Memory as MetaDataMemoryAdapter;

// Set the database service WEB
$di->set('db', function () use ($config) {
    $dbconf = $config->database;

    switch(strtolower($dbconf->adapter)) {

        case 'mysql':

            return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
                'host' => $dbconf->host,
                'username' => $dbconf->username,
                'password' => $dbconf->password,
                'dbname' => $dbconf->dbname,
                'charset' => $dbconf->charset,
                'options' => array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES "' . $dbconf->charset . '"',
                    PDO::ATTR_CASE => PDO::CASE_LOWER
                )
            ));

        case 'postgresql':

            return new \Phalcon\Db\Adapter\Pdo\Postgresql(array(
                'host' => $dbconf->host,
                'username' => $dbconf->username,
                'password' => $dbconf->password,
                'dbname' => $dbconf->dbname,
                'options' => array(
                )
            ));
		
		default: 
			throw new \Exception('Unimplemented database::adapter in config.ini');
    }
});

// Registering models metadata adapter and cacher
$di->set('modelsMetadata', function() use ($config)
{

	switch (strtolower($config->models->metadata->adapter)) {
		case 'apc':
			$metaData = new MetaDataApcAdapter([
				'lifetime' => $config->models->metadata->lifetime,
				'suffix' => $config->models->metadata->suffix,
			]);
			break;
		case 'xcache':
			$metaData = new MetaDataXCacheAdapter([
				'lifetime' => $config->models->metadata->lifetime,
				'prefix' => $config->models->metadata->suffix,
			]);
			break;
		case 'memory':
			$metaData = new MetaDataMemoryAdapter();
			break;
		default:
			throw new \Exception('Unimplemented models::metadata.adapter in config.ini');
	}
//	$metaData->setStrategy(new AnnotationsMetaDataInitializer());
	return $metaData;
});