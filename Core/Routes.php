<?php

// Admin routes
$router->add('admin', ['namespace' => 'Admin', 'controller' => 'UserController', 'action' => 'login', 'middleware' => 'Guest']);
$router->add('admin/', ['namespace' => 'Admin', 'controller' => 'UserController', 'action' => 'login', 'middleware' => 'Guest']);
$router->add('admin/login', ['namespace' => 'Admin', 'controller' => 'UserController', 'action' => 'login', 'middleware' => 'Guest']);
$router->add('admin/forgot-password', ['namespace' => 'Admin', 'controller' => 'UserController', 'action' => 'sendResetPasswordLink', 'middleware' => 'Guest']);
$router->add('admin/reset-password/{token:[a-z]+}', ['namespace' => 'Admin', 'controller' => 'UserController', 'action' => 'resetPassword', 'middleware' => 'Guest']);
$router->add('admin/password-reset', ['namespace' => 'Admin', 'controller' => 'UserController', 'action' => 'changePassword', 'middleware' => 'Guest']);
$router->add('admin/logout', ['namespace' => 'Admin', 'controller' => 'UserController', 'action' => 'logout', 'middleware' => 'Auth']);
$router->add('admin/dashboard', ['namespace' => 'Admin', 'controller' => 'UserController', 'action' => 'dashboard', 'middleware' => 'Auth']);

$router->add('admin/users', ['namespace' => 'Admin', 'controller' => 'UserController', 'action' => 'getUsers', 'middleware' => ['Auth', 'Permission']]);
$router->add('admin/users-ajax-paginate', ['namespace' => 'Admin', 'controller' => 'UserController', 'action' => 'userPaginate', 'middleware' => 'Auth']);
$router->add('admin/bulk-delete-users', ['namespace' => 'Admin', 'controller' => 'UserController', 'action' => 'bulkDeleteUsers', 'middleware' => ['Auth', 'Permission']]);
$router->add('admin/add-user', ['namespace' => 'Admin', 'controller' => 'UserController', 'action' => 'storeUser', 'middleware' => ['Auth', 'Permission']]);
$router->add('admin/edit-user/{id:\d+}', ['namespace' => 'Admin', 'controller' => 'UserController', 'action' => 'storeUser', 'middleware' => ['Auth', 'Permission']]);
$router->add('admin/update-user', ['namespace' => 'Admin', 'controller' => 'UserController', 'action' => 'storeUser', 'middleware' => ['Auth', 'Permission']]);

$router->add('admin/flow-flow', ['namespace' => 'Admin', 'controller' => 'FlowFlowController', 'action' => 'index', 'middleware' => ['Auth', 'Permission']]);

$router->add('admin/categories', ['namespace' => 'Admin', 'controller' => 'CategoryController', 'action' => 'index', 'middleware' => ['Auth', 'Permission']]);
$router->add('admin/categories-ajax-paginate', ['namespace' => 'Admin', 'controller' => 'CategoryController', 'action' => 'categoryPaginate', 'middleware' => 'Auth']);
$router->add('admin/bulk-delete-categories', ['namespace' => 'Admin', 'controller' => 'CategoryController', 'action' => 'bulkDeleteCategories', 'middleware' => ['Auth', 'Permission']]);
$router->add('admin/add-category', ['namespace' => 'Admin', 'controller' => 'CategoryController', 'action' => 'storeCategory', 'middleware' => ['Auth', 'Permission']]);
$router->add('admin/edit-category/{id:\d+}', ['namespace' => 'Admin', 'controller' => 'CategoryController', 'action' => 'index', 'middleware' => ['Auth', 'Permission']]);

$router->add('admin/add-post', ['namespace' => 'Admin', 'controller' => 'PostController', 'action' => 'store', 'middleware' => ['Auth', 'Permission']]);
$router->add('admin/edit-post/{id:\d+}', ['namespace' => 'Admin', 'controller' => 'PostController', 'action' => 'store', 'middleware' => ['Auth', 'Permission']]);
$router->add('admin/uploadImage', ['namespace' => 'Admin', 'controller' => 'PostController', 'action' => 'uploadImage', 'middleware' => 'Auth']);
$router->add('admin/posts', ['namespace' => 'Admin', 'controller' => 'PostController', 'action' => 'getPosts', 'middleware' => ['Auth', 'Permission']]);
$router->add('admin/tags', ['namespace' => 'Admin', 'controller' => 'TagController', 'action' => 'index', 'middleware' => 'Auth']);
$router->add('admin/post-ajax-paginate', ['namespace' => 'Admin', 'controller' => 'PostController', 'action' => 'postPaginate', 'middleware' => 'Auth']);
$router->add('admin/bulk-delete-post', ['namespace' => 'Admin', 'controller' => 'PostController', 'action' => 'bulkDeletePost', 'middleware' => ['Auth', 'Permission']]);

$router->add('admin/add-page', ['namespace' => 'Admin', 'controller' => 'PageController', 'action' => 'store', 'middleware' => ['Auth', 'Permission']]);
$router->add('admin/edit-page/{id:\d+}', ['namespace' => 'Admin', 'controller' => 'PageController', 'action' => 'store', 'middleware' => ['Auth', 'Permission']]);
$router->add('admin/pages', ['namespace' => 'Admin', 'controller' => 'PageController', 'action' => 'getPages', 'middleware' => ['Auth', 'Permission']]);
$router->add('admin/page-ajax-paginate', ['namespace' => 'Admin', 'controller' => 'PageController', 'action' => 'pagePaginate', 'middleware' => 'Auth']);
$router->add('admin/bulk-delete-page', ['namespace' => 'Admin', 'controller' => 'PageController', 'action' => 'bulkDeletePage', 'middleware' => ['Auth', 'Permission']]);

$router->add('admin/add-menu', ['namespace' => 'Admin', 'controller' => 'MenuController', 'action' => 'store', 'middleware' => ['Auth', 'Permission']]);
$router->add('admin/edit-menu/{id:\d+}', ['namespace' => 'Admin', 'controller' => 'MenuController', 'action' => 'store', 'middleware' => ['Auth', 'Permission']]);
$router->add('admin/menus', ['namespace' => 'Admin', 'controller' => 'MenuController', 'action' => 'getMenus', 'middleware' => ['Auth', 'Permission']]);
$router->add('admin/menu-ajax-paginate', ['namespace' => 'Admin', 'controller' => 'MenuController', 'action' => 'menuPaginate', 'middleware' => 'Auth']);
$router->add('admin/bulk-delete-menu', ['namespace' => 'Admin', 'controller' => 'MenuController', 'action' => 'bulkDeleteMenu', 'middleware' => ['Auth', 'Permission']]);
$router->add('admin/update-menu-sort-order', ['namespace' => 'Admin', 'controller' => 'MenuController', 'action' => 'updateMenuSortOrder', 'middleware' => 'Auth']);

$router->add('admin/add-advertise', ['namespace' => 'Admin', 'controller' => 'AdvertiseController', 'action' => 'store', 'middleware' => ['Auth', 'Permission']]);
$router->add('admin/edit-advertise/{id:\d+}', ['namespace' => 'Admin', 'controller' => 'AdvertiseController', 'action' => 'store', 'middleware' => ['Auth', 'Permission']]);
$router->add('admin/advertise', ['namespace' => 'Admin', 'controller' => 'AdvertiseController', 'action' => 'index', 'middleware' => ['Auth', 'Permission']]);
$router->add('admin/advertise-ajax-paginate', ['namespace' => 'Admin', 'controller' => 'AdvertiseController', 'action' => 'advertisePaginate', 'middleware' => ['Auth', 'Permission']]);
$router->add('admin/bulk-delete-advertise', ['namespace' => 'Admin', 'controller' => 'AdvertiseController', 'action' => 'bulkDeleteAdvertise', 'middleware' => ['Auth', 'Permission']]);

$router->add('admin/error', ['namespace' => 'Admin', 'controller' => 'UserController', 'action' => 'error']);
/*$router->add('admin/checkuser', ['namespace' => 'Admin','controller' => 'UserController', 'action' => 'checkuser', 'middleware' => 'Auth']);*/

// Front routes
$router->add('feed/{postid:[a-zA-Z\d\W\w]+}/{feedid:[a-zA-Z\d\W\w]+}', ['namespace' => 'Front', 'controller' => 'CMSController', 'action' => 'feedDetail']);
$router->add('search/{s:[a-zA-Z\d\W]+}/{p:\d+}', ['namespace' => 'Front', 'controller' => 'SearchController', 'action' => 'search']);
$router->add('search/{s:[a-zA-Z\d\W]+}', ['namespace' => 'Front', 'controller' => 'SearchController', 'action' => 'search']);
$router->add('search-data', ['namespace' => 'Front','controller' => 'SearchController', 'action' => 'index']);
$router->add('', ['namespace' => 'Front', 'controller' => 'IndexController', 'action' => 'index']);
$router->add('contact-us', ['namespace' => 'Front', 'controller' => 'ContactUsController', 'action' => 'index']);
$router->add('{slug:[a-zA-Z\d\W\w]+}', ['namespace' => 'Front', 'controller' => 'CMSController', 'action' => 'index']);

$router->add('error', ['namespace' => 'Admin', 'controller' => 'UserController', 'action' => 'error']);





