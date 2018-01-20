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

Route::get('/', 'Home\IndexController@index')->middleware('login');
//登录注册模块
Route::get('/login', 'UserController@login');
Route::post('/dologin', 'UserController@dologin');
Route::get('/logout', 'UserController@logout');
Route::get('/reg', 'UserController@reg');
Route::post('/doreg', 'UserController@doreg');
Route::get('admin/user/find/{account}', 'Admin\UserController@account');


Route::middleware(['login'])->prefix('user')->group(function () {
    Route::get('/','Home\UserController@product');
    Route::get('/info','Home\UserController@info');
    Route::get('/consumes','Home\UserController@consumes');
    Route::get('/organ','Home\UserController@organ');
});




//后台模块
Route::middleware(['login','admin'])->prefix('admin')->group(function () {

    Route::get('/', 'Admin\UserController@index');
    Route::prefix('user')->group(function () {
        //后台用户模块
        Route::get('/', 'Admin\UserController@index')->name('user_index');
        Route::get('create', 'Admin\UserController@create');
        // Route::post('store', 'Admin\UserController@store');
        // Route::get('edit/{id}', 'Admin\UserController@edit');
        // Route::post('update', 'Admin\UserController@update');
        // Route::get('del/{id}', 'Admin\UserController@destroy');
        // //根据id，用户信息导出
        // Route::get('info/{id}', 'Admin\UserController@info');
        // //所有用户信息导出
        // Route::get('infoall', 'Admin\UserController@infoall');
        // Route::post('addusers', 'Admin\UserController@addusers');
        //下载Excel表格（用于填写导入用户信息）
        Route::get('getfeild', 'Admin\UserController@getfeild');
    });

    //后台赛事模块
    Route::prefix('match')->group(function () {
        //后台赛事模块
        //创建比赛页面
        Route::get('create/{type}','Admin\MatchController@create');
        //处理创建比赛
        Route::post('store/{type}','Admin\MatchController@store');
        //合作方和联系方式
        Route::get('partner/{id}','Admin\MatchController@partner');
        Route::post('storepartner/{id}','Admin\MatchController@storepartner');
        //评委设定
        Route::get('rater/{id}','Admin\MatchController@rater');
        Route::get('findrater/{id}','Admin\MatchController@findrater');
        Route::post('storerater/{id}','Admin\MatchController@rater');
        //嘉宾设定
        Route::get('guest/{id}','Admin\MatchController@guest');
        Route::get('findguest/{id}','Admin\MatchController@findguest');
        Route::post('storeguest/{id}','Admin\MatchController@guest');
        //奖项设定
        Route::get('award/{id}','Admin\MatchController@award');
        Route::post('storeaward/{id}','Admin\MatchController@award');
        //个人投稿设定
        Route::get('require_personal/{id}','Admin\MatchController@require_personal');
        Route::post('storerequire_personal/{id}','Admin\MatchController@require_personal');
        //团体投稿设定
        Route::get('require_team/{id}','Admin\MatchController@require_team');
        Route::post('storerequire_team/{id}','Admin\MatchController@require_team');

    });

});
