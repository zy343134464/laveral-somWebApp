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

Route::get('/', 'Admin\UserController@index');
Route::get('/dashboard', 'UserController@index');
Route::get('/login', 'UserController@login');
Route::post('/dologin', 'UserController@dologin');
Route::get('/logout', 'UserController@logout');
Route::get('/reg', 'UserController@reg');
Route::post('/doreg', 'UserController@doreg');
Route::prefix('admin')->group(function () {
    Route::get('/', 'Admin\UserController@index');

    //user模块
    Route::get('/user', 'Admin\UserController@index')->name('user_index');
    Route::get('/user/create', 'Admin\UserController@create');
    Route::post('/user/store', 'Admin\UserController@store');
    Route::get('/user/edit/{id}', 'Admin\UserController@edit');
    Route::post('/user/update', 'Admin\UserController@update');
    Route::get('/user/del/{id}', 'Admin\UserController@destroy');
    Route::get('/user/find/{account}', 'Admin\UserController@account');

    //根据id，用户信息导出
    Route::get('/user/info/{id}', 'Admin\UserController@info');
    //所有用户信息导出
    Route::get('/user/infoall', 'Admin\UserController@infoall');
    Route::post('/user/addusers', 'Admin\UserController@addusers');
    //下载Excel表格（用于填写导入用户信息）
    Route::get('/user/getfeild', 'Admin\UserController@getfeild');

    //role模块
    Route::get('/role','Admin\RoleController@index');
    Route::get('/role/create', 'Admin\roleController@create');
    Route::post('/role/store', 'Admin\roleController@store');
    Route::get('/role/edit/{id}', 'Admin\roleController@edit');
    Route::post('/role/update', 'Admin\roleController@update');
    Route::get('/role/del/{id}', 'Admin\roleController@destroy');
    Route::get('/role/find/{account}', 'Admin\roleController@account');
});
