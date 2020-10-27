<?php
/** @var \Laravel\Lumen\Routing\Router $router */

// 创建用户和登录
$router->group([
    'prefix' => 'auth',
    'namespace' => 'Api',
], function () use ($router) {
    $router->post('/store', 'UserController@store');
    $router->post('/login', 'UserController@login');
    $router->get('/user', 'UserController@index');
    $router->get('/me', 'UserController@me');
    $router->get('/logout', 'UserController@logout');
    $router->get('/changeLocale', 'UserController@changeLocale');
});

// 认证中间件
$router->group([
    'prefix' => 'api',
    'namespace' => 'Api',
    'middleware' => ['auth:api', 'SwitchLan']
], function () use ($router) {
//    $router->post('/posts', 'PostsController@store');
    $router->post('/posts', 'PostsController@store_with_mq');
    $router->get('/posts', 'PostsController@index');
});
