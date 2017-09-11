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
session_start();

/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
//$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('admin/login', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'login']);

/*if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1){*/

    $router->add('admin/dashboard', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'dashboard']);
    $router->add('admin/logout', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'logout']);
/*}else{*/
    $router->add('admin/error', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'error']);
/*}*/

$router->dispatch($_SERVER['QUERY_STRING']);
