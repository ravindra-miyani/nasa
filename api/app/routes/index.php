<?php
$routes['IndexController']['prefix'] 		= '/index';
$routes['IndexController']['actions'][] 	= array('http_method' => 'get','url' => '/index','call' => 'index');