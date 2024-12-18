<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';

use Framework\Router;
use Framework\Session;

Session::start();


require '../helper.php';


// require getPatch('Framework/Router.php');
// require getPatch('Framework/Database.php');

// spl_autoload_register(function ($class) {
//     $classPath = require getPatch('Framework/' . $class . '.php');
//     if (file_exists($classPath)) {
//         return $classPath;
//     }
// });


//instattiate route
$router = new Router();

//get routes
$routes = require getPatch('routes.php');

//get url and method from request
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


//ROUTE THE REQUEST
$router->route($uri);
