<?php

// Add the routes
$router->add('admin/login', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'login', 'middleware' => 'Guest']);
$router->add('admin/dashboard', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'dashboard', 'middleware' => 'Auth']);
$router->add('admin/logout', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'logout', 'middleware' => 'Auth']);
$router->add('admin/reset', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'sendResetPasswordLink', 'middleware' => 'Guest']);
$router->add('admin/reset-password/{id}', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'resetPassword', 'middleware' => 'Guest']);
$router->add('admin/password-reset', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'changePassword', 'middleware' => 'Guest']);
$router->add('admin/error', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'error']);

