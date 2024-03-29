<?php

/**
 * Front controller
 *
 * PHP version 7.0
 */

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';


/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


/**
 * Sessions
 */
session_start();

/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('api/limit/{category:[\wżźćńółęąśŻŹĆŃÓŁĘĄŚ ]+}', ['controller' => 'Expenses', 'action' => 'limit']);
$router->add('api/monthlySum/{category:[\wżźćńółęąśŻŹĆŃÓŁĘĄŚ ]+}/{date:[0-9\-]+}', ['controller' => 'Expenses', 'action' => 'monthlySum']);
$router->add('', ['controller' => 'Login', 'action' => 'new']);
$router->add('login', ['controller' => 'Login', 'action' => 'new']);
$router->add('home', ['controller' => 'Home', 'action' => 'index']);
$router->add('setting', ['controller' => 'Settings', 'action' => 'show']);
$router->add('balance', ['controller' => 'Balances', 'action' => 'show']);
$router->add('logout', ['controller' => 'Login', 'action' => 'destroy']);
$router->add('password/reset/{token:[\da-f]+}', ['controller' => 'Password', 'action' => 'reset']);
$router->add('signup/activate/{token:[\da-f]+}', ['controller' => 'Signup', 'action' => 'activate']);
$router->add('{controller}/{action}');

$router->dispatch($_SERVER['QUERY_STRING']);
