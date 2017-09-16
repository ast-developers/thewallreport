<?php

// Add the routes
$router->add('admin', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'login', 'middleware' => 'Guest']);
$router->add('admin/login', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'login', 'middleware' => 'Guest']);
$router->add('admin/forgot-password', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'sendResetPasswordLink', 'middleware' => 'Guest']);
$router->add('admin/reset-password/{token:[a-z]+}', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'resetPassword', 'middleware' => 'Guest']);
$router->add('admin/password-reset', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'changePassword', 'middleware' => 'Guest']);
$router->add('admin/logout', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'logout', 'middleware' => 'Auth']);
$router->add('admin/dashboard', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'dashboard', 'middleware' => 'Auth']);
$router->add('admin/users', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'getUsers', 'middleware' => 'Auth']);
$router->add('admin/users-ajax-paginate', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'userPaginate','middleware' => 'Auth']);
$router->add('admin/bulk-delete-users', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'bulkDeleteUsers','middleware' => 'Auth']);
$router->add('admin/add-user', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'storeUser', 'middleware' => 'Auth']);
$router->add('admin/edit-user/{id:\d+}', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'storeUser', 'middleware' => 'Auth']);
$router->add('admin/update-user', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'storeUser', 'middleware' => 'Auth']);
$router->add('admin/flow-flow', ['namespace' => 'Admin','controller' => 'FlowFlowController', 'action' => 'index','middleware' => 'Auth']);
$router->add('', ['namespace' => 'Front','controller' => 'IndexController', 'action' => 'index']);
/*$router->add('admin/checkuser', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'checkuser', 'middleware' => 'Auth']);*/
$router->add('admin/error', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'error']);


