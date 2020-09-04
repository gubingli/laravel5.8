<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Admin',
    'prefix' => 'admin'
], function($api) {
    $api->get('/login', 'AuthController@login')->name('api.home.login'); //登录

    $api->group(['middleware' => ['verifyToken']], function($api) {
        $api->get('/', 'HomeController@index')->name('api.home.index');

        $api->group(['namespace' => 'User','prefix' => 'user'], function($api) {
            $api->get('/detail', 'RoleController@detail')->name('user.list'); //用户详情


        });
    });
});
