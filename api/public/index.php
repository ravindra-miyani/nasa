<?php

/**
 * PhalconPHP Bootstrap file. All the request will come here first. Based on the logic it will execute the routes.
 * 
 * Copyright (C) 2017-2018 Ravindra Miyani - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Ravindra Miyani <mys6666@gmail.com>
 *
 * @author      Ravindra Miyani
 * @copyright   2017-2018 Ravindra Miyani
 * @license     
 * @version
 * @link
 * @see
 * @since
 */



use Phalcon\Mvc\Micro;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Session\Adapter\Files as Session;


try{

    define('ROOT_PATH', __DIR__);
    define('APP_CORE', ROOT_PATH . '/../app/core/');
    include_once(APP_CORE."common_includes.php");

    // Register an autoloader
    $loader = new Loader();

    $loader->registerDirs(
        [
            APP_CONTROLLERS,
            APP_MODELS,
            APP_CORE
        ]
    );

    $loader->register();

    // Create a DI
    $di = new FactoryDefault();

    // Setup a base URI so that all generated URIs include the "/" folder
    $di->set(
        'url',
        function () {
            $url = new UrlProvider();

            $url->setBaseUri('/');

            return $url;
        }
    );

    $di->setShared(
        'session',
        function () {
            $session = new Session();

            $session->start();

            return $session;
        }
    );


    
    $di->set('db', function(){
        $databaseParams = array(
            'host'      => 'localhost',
            'username'  => 'root',
            'password'  => 'Ravindra!6688',
            'dbname'    => 'nasa',
            'charset'   => 'utf8'
        );

        $connection = new \Phalcon\Db\Adapter\Pdo\Mysql($databaseParams);
        return $connection;
    });


    // PhalconPHP's Micro Framework suits best for REST API.  
    $application = new Micro();
    $application->setDI($di);

    require_once APP_CORE . '/routes.php'; // including routes file. 


    // Handle the request
    $response = $application->handle();

} catch (\Exception $e) {
    $array['exception_message'] = $e->getMessage();
    Response::getInstance()->sendResponse($array, 512, 'EXCEPTION');
}