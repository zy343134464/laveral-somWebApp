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
Route::get('/news/{id}', 'Home\IndexController@news');
Route::get('/a', function () {
    return view('test');
})->middleware('login');
Route::get('/b/{show}', 'Admin\MatchController@index')->middleware('login');

//资讯页
Route::get('informations/{id}', 'InformationConroller@show_information');
//首页ajax获取资讯
Route::get('get_information', 'InformationConroller@get_information');
//首页ajax赛事(搜索$kw,$cat)
Route::get('get_match', 'IndexConroller@get_match');

//登录注册模块
Route::get('/login', 'UserController@login');
Route::post('/dologin', 'UserController@dologin');
Route::get('/logout', 'UserController@logout');
Route::get('/reg', 'UserController@reg');
Route::post('/doreg', 'UserController@doreg');
Route::get('admin/user/find/{account}', 'Admin\UserController@account');





//用户中心
Route::middleware(['login'])->prefix('user')->group(function () {
    Route::get('/', 'Home\UserController@product');
    Route::get('/info', 'Home\UserController@info');
    Route::get('/award', 'Home\UserController@award');
    Route::get('/consumes', 'Home\UserController@consumes');
    Route::get('/organ', 'Home\UserController@organ');
    Route::post('/editInfo/{id}', 'Home\UserController@editInfo');
});




//赛事模块
Route::middleware(['login'])->prefix('match')->group(function () {
    Route::get('/detail/{id}', 'Home\MatchController@detail');
    Route::get('/join/{id}', 'Home\MatchController@join');
    Route::get('/uploadimg/{id}', 'Home\MatchController@uploadimg');
    Route::post('/douploadimg/{id}', 'Home\MatchController@douploadimg');
    Route::get('/editimg/{id}', 'Home\MatchController@editimg');
    Route::post('/doeditimg/{id}', 'Home\MatchController@doeditimg');
});


//评委
Route::middleware(['login','rater'])->prefix('rater')->group(function () {
    Route::get('/room', 'Home\IndexController@room');
    Route::get('/history', 'Home\IndexController@history');
    Route::get('/review/{mid}/{round}', 'Home\IndexController@review');
    Route::get('/rater_pic/{id}', 'Home\IndexController@rater_pic');
    Route::post('/pic', 'Home\IndexController@pic');
    Route::post('/pic_score', 'Home\IndexController@pic_score');


});



//后台模块
Route::middleware(['login','admin'])->prefix('admin')->group(function () {
    Route::get('/', 'Admin\IndexController@index');
    Route::prefix('user')->group(function () {
        //后台用户模块
        Route::get('/', 'Admin\UserController@index')->name('user_index');

        Route::get('create', 'Admin\UserController@create');

        Route::post('store', 'Admin\UserController@store');

        Route::get('edit/{id}', 'Admin\UserController@edit');
        Route::post('update', 'Admin\UserController@update');

        Route::get('del/{id}', 'Admin\UserController@destroy');
        //根据id，用户信息导出
        Route::get('info/{id}', 'Admin\UserController@info');
        //所有用户信息导出
        Route::get('infoall', 'Admin\UserController@infoall');
        Route::post('addusers', 'Admin\UserController@addusers');
       //下载Excel表格（用于填写导入用户信息）
        Route::get('getfeild', 'Admin\UserController@getfeild');

        Route::get('role_setting', 'Admin\UserController@role_setting');

    });
    //后台咨询模块
    Route::get('information', 'InformationController@index');
    Route::get('information/create', 'InformationController@create');
    Route::get('information/edit/{id}', 'InformationController@edit');
    Route::post('information/edit/{id}', 'InformationController@doedit');
    Route::post('information/store', 'InformationController@store');
    Route::get('information/del/{id}', 'InformationController@del');
    //后台赛事模块
    Route::prefix('match')->group(function () {
        //后台赛事模块
        Route::get('/', function () {
            return redirect()->to('admin/match/show/block');
        });
        //后台赛事展示页
        Route::get('show/{show}', 'Admin\MatchController@index');
        //删除
        Route::get('del/{id}', 'Admin\MatchController@del');
        //copy
        Route::get('copy/{id}', 'Admin\MatchController@copy');

        //创建比赛页面
        Route::get('create/{type}', 'Admin\MatchController@create');
        Route::get('edit/{id}', 'Admin\MatchController@edit');
        //处理新建比赛
        Route::post('store/{type}', 'Admin\MatchController@store');
        //处理修改比赛
        Route::post('mainedit/{id}', 'Admin\MatchController@mainedit');
        //合作方和联系方式
        Route::get('partner/{id}', 'Admin\MatchController@partner');
        Route::post('storepartner/{id}', 'Admin\MatchController@storepartner');

        //评委设定
        Route::get('rater/{id}', 'Admin\MatchController@rater');
        //搜索评委
        Route::get('findrater/{id}', 'Admin\MatchController@findrater');
        //批量加入评委
        Route::post('storerater/{id}', 'Admin\MatchController@storerater');
        //新增评委
        Route::post('newrater/{id}', 'Admin\MatchController@newrater');
        Route::post('editnewrater', 'Admin\MatchController@editnewrater');
        Route::get('delrater/{id}', 'Admin\MatchController@delrater');

        //嘉宾设定
        Route::get('guest/{id}', 'Admin\MatchController@guest');
        //搜索嘉宾
        Route::get('findguest/{id}', 'Admin\MatchController@findguest');
        //批量加入嘉宾
        Route::post('storeguest/{id}', 'Admin\MatchController@storeguest');
        //新增嘉宾
        Route::post('newguest/{id}', 'Admin\MatchController@newguest');
        Route::post('editnewguest', 'Admin\MatchController@editnewguest');
        Route::get('delguest/{id}', 'Admin\MatchController@delguest');
        //奖项设定
        Route::get('award/{id}', 'Admin\MatchController@award');
        Route::post('storeaward/{id}', 'Admin\MatchController@storeaward');
        //个人投稿设定
        Route::get('require_personal/{id}', 'Admin\MatchController@require_personal');
        Route::post('storerequire_personal/{id}', 'Admin\MatchController@storerequire_personal');
        //团体投稿设定
        Route::get('require_team/{id}', 'Admin\MatchController@require_team');
        Route::post('storerequire_team/{id}', 'Admin\MatchController@storerequire_team');

        Route::get('son/{id}','Admin\MatchController@son');

        Route::get('show_son/{id}','Admin\MatchController@show_son');

        Route::get('copy_son/{id}','Admin\MatchController@copy_son');
        //赛事评审
        Route::get('review/{id}', 'Admin\MatchController@review');
        Route::post('storereview/{id}', 'Admin\MatchController@storereview');

        Route::get('review_room/{id}', 'Admin\MatchController@review_room');

        Route::get('showedit/{id}', 'Admin\MatchController@showedit');
        Route::post('storeshow/{id}', 'Admin\MatchController@storeshow');

        Route::get('push_match/{id}', 'Admin\MatchController@push_match');

        Route::get('end_collect/{id}', 'Admin\MatchController@end_collect');

        Route::get('start_collect/{id}', 'Admin\MatchController@start_collect');

        Route::get('result/{id}', 'Admin\MatchController@result');
        
        Route::get('next_round/{id}', 'Admin\MatchController@next_round');

        Route::get('re_review/{id}', 'Admin\MatchController@re_review');
        
        Route::get('clear_result/{id}', 'Admin\MatchController@clear_result');

        Route::get('prev_round/{id}', 'Admin\MatchController@prev_round');

        Route::get('edit_result/{id}', 'Admin\MatchController@edit_result');

        Route::get('edit_win/{id}', 'Admin\MatchController@edit_win');

        Route::get('reset_result/{id}', 'Admin\MatchController@reset_result');

        Route::post('badboy', 'Admin\MatchController@badboy');

        Route::get('end_match/{id}', 'Admin\MatchController@end_match');

        Route::get('show_end/{id}', 'Admin\MatchController@show_end');

        Route::get('get_end_result/{id}', 'Admin\MatchController@get_end_result');
        
        Route::get('end_result_pdf/{id}', 'Admin\MatchController@end_result_pdf');

        //ajax搜索评委
        Route::get('search_rater', 'Admin\MatchController@ajax_search_rater');
        //ajax新建评委
        Route::post('add_rater/{id}', 'Admin\MatchController@add_rater');

        Route::get('get_rater_info/{id}', 'Admin\MatchController@get_rater_info');
    });
});
