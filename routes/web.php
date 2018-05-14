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
//首页
Route::get('/', 'Home\IndexController@index');
//赛事详情页
Route::get('/match/detail/{id}', 'Home\MatchController@detail');

Route::get('/news/{id}', 'Home\IndexController@news');
//test
Route::get('/b', 'Home\MatchController@b');



//资讯页
Route::get('informations/{id}', 'InformationConroller@show_information');
//首页ajax获取资讯
Route::get('get_information', 'InformationConroller@get_information');
//首页ajax赛事(搜索$kw,$cat)
Route::get('get_match', 'IndexConroller@get_match');

Route::get('mail/send', 'MailController@send');
//登录注册模块
Route::get('/login', 'UserController@login');

Route::get('/login/sms', 'UserController@sms');

Route::post('/login/sms', 'UserController@sms_login');

Route::post('/phone', 'UserController@phone');

Route::post('/dologin', 'UserController@dologin');

Route::get('/logout', 'UserController@logout');

Route::get('/forget', 'UserController@forget');

Route::post('/forget', 'UserController@set_password');

Route::post('/password', 'UserController@password');

Route::get('/reg', 'UserController@reg');

Route::post('/doreg', 'UserController@doreg');

Route::get('weixin','UserController@wechat_login');

Route::get('/username', 'UserController@username');

Route::post('/username', 'UserController@setusername');

Route::get('admin/user/find/{account}', 'Admin\UserController@account');






Route::get('/img/{id}', 'Admin\MatchController@img_user');
//用户中心
Route::middleware(['login'])->prefix('user')->group(function () {
    Route::get('/', function () {
        return redirect()->to('/user/match');
    });

    Route::get('/info', 'Home\UserController@info');

    Route::get('/award', 'Home\UserController@award');

    Route::get('/consumes', 'Home\UserController@consumes');

    Route::get('/organ', 'Home\UserController@organ');
    //参赛中心
    Route::get('/match', 'Home\UserController@user_match');

    Route::get('/match/del/{id}', 'Home\UserController@del_match');

    Route::get('/son/{id}', 'Home\UserController@son');
    //赛事作品
    Route::get('/match/{id}', 'Home\UserController@match_pic');

    Route::get('/member', 'Home\UserController@member');
    //编辑作品
    Route::get('/pic/{id}', 'Home\UserController@pic');
    //处理编辑作品
    Route::post('/pic/{id}', 'Home\UserController@editpic');

    Route::post('/del_pic', 'Home\UserController@del_pic');

    Route::post('/editInfo/{id}', 'Home\UserController@editInfo');

    Route::post('/edit_img', 'Home\UserController@edit_img');
   
    Route::post('/editPassword/{id}', 'Home\UserController@editPassword');

    Route::get('/match/img/{id}', 'Admin\MatchController@img_user');
});




//赛事模块---上传作品
Route::middleware(['login'])->prefix('match')->group(function () {   

    Route::get('/statement/{id}', 'Home\MatchController@statement');

    Route::get('/form/{id}', 'Home\MatchController@form');

    Route::get('/synthesize/{id}', 'Home\MatchController@synthesize');

    Route::post('/join/{id}', 'Home\MatchController@join');
    //上传图片
    Route::get('/uploadimg/{id}', 'Home\MatchController@uploadimg');
   
    //Route::post('/douploadimg/{id}', 'Home\MatchController@douploadimg');
    //ajax提交组图
    Route::post('/douploadimgs/{id}', 'Home\MatchController@douploadimgs');
    //组图上传图片插件
    Route::post('/upload', 'Home\MatchController@upload');
    //ajax获取用户在赛事中的所有作品
    Route::post('/ajax/pic/{id}', 'Home\MatchController@ajax_match_pic');
});


//评委
Route::middleware(['login','rater'])->prefix('rater')->group(function () {
    //评委室 审核中
    Route::get('/room', 'Home\RaterController@room');
    //评委室 历史
    Route::get('/history', 'Home\RaterController@history');
    // 评审赛事
    Route::get('/review/{mid}/{round}', 'Home\RaterController@review');
    //评审点击 获取图片详细信息
    Route::get('/rater_pic/{id}', 'Home\RaterController@rater_pic');
    //ajax评分
    Route::post('/pic', 'Home\RaterController@pic');
});



Route::get('/clear', 'Admin\IndexController@clear')->middleware('login');
Route::get('/clear_pic', 'Admin\IndexController@clear_pic')->middleware('login');
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

        Route::post('info', 'Admin\UserController@exc_info');
        //所有用户信息导出
        Route::get('infoall', 'Admin\UserController@infoall');
        //Excel导入用户
        Route::post('addusers', 'Admin\UserController@addusers');
        //下载Excel表格（用于填写导入用户信息）
        Route::get('getfeild', 'Admin\UserController@get_excel');

        Route::get('role_setting', 'Admin\UserController@role_setting');
        Route::post('set_role', 'Admin\UserController@set_role');
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
        Route::get('del_personal/{id}', 'Admin\MatchController@del_personal');
        Route::post('storerequire_personal/{id}', 'Admin\MatchController@storerequire_personal');
        //团体投稿设定
        Route::get('require_team/{id}', 'Admin\MatchController@require_team');
        Route::get('del_team/{id}', 'Admin\MatchController@del_team');
        Route::post('storerequire_team/{id}', 'Admin\MatchController@storerequire_team');

        Route::get('son/{id}', 'Admin\MatchController@son');

        Route::get('show_son/{id}', 'Admin\MatchController@show_son');

        Route::get('copy_son/{id}', 'Admin\MatchController@copy_son');


        //赛事评审
        Route::get('review/{id}', 'Admin\MatchController@review');

        Route::post('storereview/{id}', 'Admin\MatchController@storereview');

        Route::get('review_room/{id}', 'Admin\MatchController@review_room');
        
        Route::get('back_all_pic/{id}', 'Admin\MatchController@back_all_pic');

        Route::get('showedit/{id}', 'Admin\MatchController@showedit');

        Route::post('storeshow/{id}', 'Admin\MatchController@storeshow');

        Route::get('push_match/{id}', 'Admin\MatchController@push_match');

        Route::get('push_result/{id}', 'Admin\MatchController@push_result');

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
        //导出赛果图片
        Route::get('end_result_pdf/{id}', 'Admin\MatchController@end_result_pdf');
        //导出赛果信息
        Route::get('end_result_excel/{id}', 'Admin\MatchController@end_result_excel');
        //导出赛果参赛用户个人信息
        Route::get('end_user_excel/{id}', 'Admin\MatchController@end_user_excel');

        Route::get('end_user_excel/{id}', 'Admin\MatchController@end_user_excel');
        //导出参赛作品
        Route::get('match_pic_pdf/{id}', 'Admin\MatchController@match_pic_pdf');
        //导出参赛图片信息
        Route::get('match_pic_excel/{id}', 'Admin\MatchController@match_pic_excel');
        //导出参赛用户信息
        Route::get('match_user_excel/{id}', 'Admin\MatchController@match_user_excel');

        Route::get('get_rater_info/{id}', 'Admin\MatchController@get_rater_info');

        Route::post('edit_win_ajax', 'Admin\MatchController@edit_win_ajax');
        //管理员 评审额外添加奖项
        Route::post('add_award', 'Admin\MatchController@add_award');
        //ajax搜索评委
        Route::get('search_rater', 'Admin\MatchController@ajax_search_rater');
        //ajax新建评委
        Route::post('add_rater/{id}', 'Admin\MatchController@add_rater');
        //ajax获取作品信息
        Route::get('img/{id}', 'Admin\MatchController@img');
    });
});
