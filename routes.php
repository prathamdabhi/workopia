<?php

// $routes =  [
//     '/' => 'controllers/home.php',
//     '/listing' => 'controllers/listing/index.php',
//     '/listing/create' => 'controllers/listing/create/create.php',

// ];

$router->get('/', 'controllers/home.php');
$router->get('/listings', 'controllers/listing/index.php');
$router->get('/listings/create', 'controllers/listing/create/create.php');
$router->get('/listing', 'controllers/listing/show.php');
