<?php

// Add the routes
$router->add('admin/login', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'login', 'middleware' => 'Guest']);
$router->add('admin/dashboard', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'dashboard', 'middleware' => 'Auth']);
$router->add('admin/logout', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'logout', 'middleware' => 'Auth']);
$router->add('admin/error', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'error']);

