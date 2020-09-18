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
});

// 认证中间件
$router->group([
    'prefix' => 'api',
    'namespace' => 'Api',
    'middleware' => 'auth:api'
], function () use ($router) {
    $router->post('/posts', 'PostsController@store');
    $router->get('/posts', 'PostsController@index');
});
