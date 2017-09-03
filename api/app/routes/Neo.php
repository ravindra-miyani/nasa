<?php

$routes['NeoController']['prefix'] 		= '/neo';

$routes['NeoController']['actions'][] 	= array('http_method' => 'get','url' => '/save-neo','call' => 'getAllFromNASA');


$routes['NeoController']['actions'][] 	= array('http_method' => 'get','url' => '/hazardous','call' => 'getAllHazardous');

$routes['NeoController']['actions'][] 	= array('http_method' => 'get','url' => '/fastest','call' => 'getFastestHazNonHaz');

$routes['NeoController']['actions'][] 	= array('http_method' => 'get','url' => '/fastest/{is_haz}','call' => 'getFastestHazNonHaz');

$routes['NeoController']['actions'][] 	= array('http_method' => 'get','url' => '/best-year','call' => 'getBestYearHazNonHaz');

$routes['NeoController']['actions'][] 	= array('http_method' => 'get','url' => '/best-year/{is_haz}','call' => 'getBestYearHazNonHaz');

$routes['NeoController']['actions'][] 	= array('http_method' => 'get','url' => '/best-month','call' => 'getBestMonthHazNonHaz');

$routes['NeoController']['actions'][] 	= array('http_method' => 'get','url' => '/best-month/{is_haz}','call' => 'getBestMonthHazNonHaz');