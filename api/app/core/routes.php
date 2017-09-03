<?php
/**
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


/**
 * Setting an routes for the api calls from frontend.
 *
*/

$common_actions[] =  array('http_method' => 'get','url' => '/list', 'call' => 'getAll');
$common_actions[] =  array('http_method' => 'post','url' => '/add', 'call' => 'create');
$common_actions[] =  array('http_method' => 'get','url' => '/edit/{id}', 'call' => 'get');
$common_actions[] =  array('http_method' => 'put','url' => '/edit/{id}', 'call' => 'update');
$common_actions[] =  array('http_method' => 'delete','url' => '/delete/{id}', 'call' => 'remove');

if ($handle = opendir(APP_ROUTES)) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            $full_path = APP_ROUTES . $entry;
            include_once "$full_path";
        }
    }
    closedir($handle);
}


foreach($routes as $route_name => $route)
{
    $collection = null;
    $collection = new Phalcon\Mvc\Micro\Collection();

    if (! class_exists($route_name)) {
        continue;
    }


    $collection->setHandler($route_name, true);
    $collection->setPrefix($route['prefix']);
    $action_array = $common_actions;

    if (isset($route['actions'])) {
        $action_array = array_merge($common_actions, $route['actions']);
    }

    foreach ($action_array as $key1 => $action) {
        switch ($action['http_method']) {
            case 'get':
                $collection->get($action['url'], $action['call']);
                break;

            case 'post':
                $collection->post($action['url'], $action['call']);
                break;

            case 'put':
                $collection->put($action['url'], $action['call']);
                break;

            case 'delete':
                $collection->delete($action['url'], $action['call']);
                break;

            case 'options':
                $collection->options($action['url'], $action['call']);
                break;

            case 'patch':
                $collection->patch($action['url'], $action['call']);
                break;
        }
    }

    $application->mount($collection);
}
?>