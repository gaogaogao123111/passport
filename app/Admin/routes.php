<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->get('/Api/apilist', 'ApiController@apilist');
    $router->post('/Api/gocheck', 'ApiController@gocheck');
    $router->get('/Api/token', 'ApiController@token');



});
