<?php
use Illuminate\Http\Request;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1',[
    'namespace' => 'App\Http\Controllers\Admin', //定义命名空间
], function ($api) {
    $api->group(['prefix' => 'admin'], function ($api) {
        //示例路由 http://www.test.com/admin/account
        $api->post('/register', 'Auth\RegisterController@create')->name('register');//注册

        $api->post('/login', 'Auth\AuthController@login')->name('login'); //登录


       // $api->group(['middleware' => ['auth','Cors']], function($api){
            $api->post('/logout', 'AuthController@logout')->name('logout'); //退出

            $api->post('/upload','HomeController@upload')->name('upload'); //图片上传

            $api->post('/detail','UserInfoController@detail')->name('detail'); //用户信息详情
            $api->post('/update','UserInfoController@update')->name('update'); //用户信息修改
            $api->get('/list','UserInfoController@index')->name('info'); //用户信息列表
            $api->post('/check','UserInfoController@check')->name('check'); //会员信息列表（普通会员）


            $api->group(['prefix' => 'company'], function ($api) {
                $api->post('/member/add', 'CompanyInfoController@add'); //机构添加会员
                $api->post('/member/memberList', 'CompanyInfoController@memberList'); //机构会员列表

            });




            $api->get('/banners','UserController@index')->name('banners'); //轮播图列表
            $api->post('/banners','UserController@add')->name('banners.add'); //轮播图新增
            $api->delete('/banners/d','UserController@del')->name('banners.del'); //轮播图新增

       // });

    });
});

