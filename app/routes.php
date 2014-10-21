<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::pattern('id', '[0-9]+');
Route::pattern('status', '[0-9]+');
Route::get('/', function()
{
    return View::make('hello');
});

Route::get('/admin/users/signin', ['as' => 'users.signin', 'uses' => 'Admin_UsersController@signin']);
Route::put('/admin/users/signin', ['as' => 'users.signin', 'uses' => 'Admin_UsersController@doSignin']);

// 后台处理
Route::group(['prefix' => 'admin', 'before' => 'adminAuth'], function()
{
    Route::get('/',        ['as' => 'admin.index',   'uses' => 'Admin_IndexController@index']);
    Route::get('/menu',    ['as' => 'admin.menu',    'uses' => 'Admin_IndexController@menu']);
    Route::get('/welcome', ['as' => 'admin.welcome', 'uses' => 'Admin_IndexController@welcome']);
    Route::get('/accessDenied', ['as' => 'accessDenied', 'uses' => 'Admin_IndexController@accessDenied']);
    Route::get('/users/signout', ['as' => 'users.signout', 'uses' => 'Admin_UsersController@signout']);

    Route::get('/users/changePwd', ['as' => 'users.changePwd','uses' => 'Admin_UsersController@changePwd']);
    Route::put('/users/changePwd', ['as' => 'users.changePwd','uses' => 'Admin_UsersController@doChangePwd']);

     // 游戏APP列表
    Route::group(['prefix' => 'apps', 'before' => 'hasPermissions'], function()
    {
        // 列表
        Route::get('onshelf',  ['as' => 'apps.onshelf',  'uses' => 'Admin_AppsController@onshelf']);
        Route::get('draft',    ['as' => 'apps.draft',    'uses' => 'Admin_AppsController@draft']);
        Route::get('pending',  ['as' => 'apps.pending',  'uses' => 'Admin_AppsController@pending']);
        Route::get('nopass',   ['as' => 'apps.nopass',   'uses' => 'Admin_AppsController@nopass']);
        Route::get('offshelf', ['as' => 'apps.offshelf', 'uses' => 'Admin_AppsController@offshelf']);

        // 历史
        Route::get('onshelf/{id}/history', ['as' => 'apps.history', 'uses' => 'Admin_AppsController@history'])
             ->where('id', '[0-9]+');

        // 编辑
        Route::get('onshelf/{id}',  ['as' => 'apps.onshelf.edit',  'uses' => 'Admin_AppsController@edit'])
             ->where('id', '[0-9]+');
        Route::get('draft/{id}',    ['as' => 'apps.draft.edit',    'uses' => 'Admin_AppsController@edit'])
             ->where('id', '[0-9]+');
        Route::get('nopass/{id}',   ['as' => 'apps.nopass.edit',   'uses' => 'Admin_AppsController@edit'])
             ->where('id', '[0-9]+');
        Route::get('offshelf/{id}', ['as' => 'apps.offshelf.edit', 'uses' => 'Admin_AppsController@edit'])
             ->where('id', '[0-9]+');

        Route::put('onshelf/{id}', ['as' => 'apps.onshelf.edit',  'uses' => 'Admin_AppsController@update'])
             ->where('id', '[0-9]+');
        Route::put('draft/{id}', ['as' => 'apps.draft.edit',    'uses' => 'Admin_AppsController@update'])
             ->where('id', '[0-9]+');
        Route::put('pending/{id}', ['as' => 'apps.pending.edit',    'uses' => 'Admin_AppsController@update'])
             ->where('id', '[0-9]+');


        // 删除
        Route::delete('{id}', ['as' => 'apps.delete', 'uses' => 'Admin_AppsController@destroy'])
             ->where('id', '[0-9]+');

        // 审核
        Route::put('{id}/dopass', ['as' => 'apps.dopass',    'uses' => 'Admin_AppsController@dopass'])
             ->where('id', '[0-9]+');
        Route::put('{id}/donopass', ['as' => 'apps.donopass',    'uses' => 'Admin_AppsController@donopass'])
             ->where('id', '[0-9]+');
        Route::put('doallpass', ['as' => 'apps.doallpass',    'uses' => 'Admin_AppsController@doallpass']);
        Route::put('doallnopass', ['as' => 'apps.doallnopass',    'uses' => 'Admin_AppsController@doallnopass']);

        // 下架
        Route::put('{id}/dooffshelf', ['as' => 'apps.dooffshelf',    'uses' => 'Admin_AppsController@dooffshelf'])
             ->where('id', '[0-9]+');

        // 预览
        Route::get('{id}/preveiw', ['as' => 'apps.preview',      'uses' => 'Admin_AppsController@preview'])
             ->where('id', '[0-9]+');

        // 上传
        Route::post('imageupload', ['as' => 'apps.imageupload', 'uses' => 'Admin_AppsController@imageUpload']);
        Route::post('appupload/{dontSave?}', ['as' => 'apps.appupload', 'uses' => 'Admin_AppsController@appUpload']);

    });

     // 管理员
    Route::group(['prefix' => 'users', 'before' => 'hasPermissions'], function()
    {
        Route::get('index', ['as' => 'users.index', 'uses' => 'Admin_UsersController@index']);
        Route::get('create', ['as' => 'users.create', 'uses' => 'Admin_UsersController@create']);
        Route::post('create', ['as' => 'users.create', 'uses' => 'Admin_UsersController@store']);
        Route::get('{id}/edit', ['as' => 'users.edit', 'uses' => 'Admin_UsersController@edit'])
             ->where('id', '[0-9]+');
        Route::put('{id}/edit', ['as' => 'users.edit', 'uses' => 'Admin_UsersController@update'])
             ->where('id', '[0-9]+');
        Route::delete('{id}/delete', ['as' => 'users.delete', 'uses' => 'Admin_UsersController@destroy']);
    });

    // 角色组
    Route::group(['prefix' => 'roles', 'before' => 'hasPermissions'], function()
    {
        Route::get('index', ['as' => 'roles.index', 'uses' => 'Admin_RolesController@index']);
        Route::get('create', ['as' => 'roles.create', 'uses' => 'Admin_RolesController@create']);
        Route::post('create', ['as' => 'roles.create', 'uses' => 'Admin_RolesController@store']);
        Route::get('{id}/edit', ['as' => 'roles.edit', 'uses' => 'Admin_RolesController@edit'])
             ->where('id', '[0-9]+');
        Route::put('{id}/edit', ['as' => 'roles.edit', 'uses' => 'Admin_RolesController@update'])
             ->where('id', '[0-9]+');
        Route::delete('{id}/delete', ['as' => 'roles.delete', 'uses' => 'Admin_RolesController@destroy'])
             ->where('id', '[0-9]+');
    });

    Route::group(['prefix' => 'cate', 'before' => 'hasPermissions'], function() //游戏分类
    {
        Route::get('index', ['as' => 'cate.index', 'uses' => 'Admin_CatesController@index']);
        Route::post('create', ['as' => 'cate.create', 'uses' => 'Admin_CatesController@store']);
        Route::post('{id}/edit', ['as' => 'cate.edit', 'uses' => 'Admin_CatesController@update']);
        Route::get('{id}/delete', ['as' => 'cate.delete', 'uses' => 'Admin_CatesController@destroy']);
        Route::get('{id}', ['as' => 'cate.show', 'uses' => 'Admin_CatesController@show']);
    });

    Route::group(['prefix' => 'tag', 'before' => 'hasPermissions'], function() //游戏标签
    {
        Route::get('index', ['as' => 'tag.index', 'uses' => 'Admin_CatesController@tagIndex']);
        Route::post('create', ['as' => 'tag.create', 'uses' => 'Admin_CatesController@tagStore']);
        Route::post('{id}/edit', ['as' => 'tag.edit', 'uses' => 'Admin_CatesController@update']);
        Route::get('{id}/delete', ['as' => 'tag.delete', 'uses' => 'Admin_CatesController@destroy']);
        Route::delete('{id}/delete', ['as' => 'tag.delete', 'uses' => 'Admin_CatesController@tagDestroy']);
        Route::get('{id}/show', ['as' => 'tag.show', 'uses' => 'Admin_CatesController@show']);
    });
    Route::group(['prefix' => 'rating', 'before' => 'hasPermissions'], function() //游戏评分
    {
        Route::get('index', ['as' => 'rating.index', 'uses' => 'Admin_RatingsController@index']);
        Route::post('{id}/edit', ['as' => 'rating.edit', 'uses' => 'Admin_RatingsController@update']);
    });
    Route::group(['prefix' => 'comment', 'before' => 'hasPermissions'], function() //游戏评论
    {
        Route::get('index', ['as' => 'comment.index', 'uses' => 'Admin_CommentsController@index']);
        Route::post('{id}/edit', ['as' => 'comment.edit', 'uses' => 'Admin_CommentsController@update']);
        Route::delete('{id}/delete', ['as' => 'comment.delete', 'uses' => 'Admin_CommentsController@destroy']);
    });
    Route::group(['prefix' => 'stopword', 'before' => 'hasPermissions'], function() //游戏屏蔽词
    {
        Route::get('index', ['as' => 'stopword.index', 'uses' => 'Admin_StopwordsController@index']);
        Route::post('create', ['as' => 'stopword.create', 'uses' => 'Admin_StopwordsController@store']);
        Route::post('{id}/edit', ['as' => 'stopword.edit', 'uses' => 'Admin_StopwordsController@update']);
        Route::delete('{id}/delete', ['as' => 'stopword.delete', 'uses' => 'Admin_StopwordsController@destroy']);
    });
    Route::group(['prefix' => 'keyword', 'before' => 'hasPermissions'], function() //游戏关键词
    {
        Route::get('index', ['as' => 'keyword.index', 'uses' => 'Admin_KeywordsController@index']);
        Route::post('create', ['as' => 'keyword.store', 'uses' => 'Admin_KeywordsController@store']);
        Route::post('{id}/edit', ['as' =>'keyword.update', 'uses' => 'Admin_KeywordsController@update']);
        Route::delete('{id}/delete', ['as' =>'keyword.delete', 'uses' => 'Admin_KeywordsController@destroy']);
    });
    Route::group(['prefix' => 'appsads', 'before' => 'hasPermissions'], function() //游戏位推广
    {
        Route::get('index', ['as' => 'appsads.index', 'uses' => 'Admin_AppsAdsController@index']);
        Route::get('create', ['as' => 'appsads.create', 'uses' => 'Admin_AppsAdsController@create']);
        Route::post('create', ['as' => 'appsads.create', 'uses' => 'Admin_AppsAdsController@store']);
        Route::get('{id}/edit', ['as' => 'appsads.edit', 'uses' => 'Admin_AppsAdsController@edit']);
        Route::post('{id}/edit', ['as' => 'appsads.edit', 'uses' => 'Admin_AppsAdsController@update']);
        Route::delete('{id}/delete', ['as' => 'appsads.delete', 'uses' => 'Admin_AppsAdsController@destroy']);
        Route::get('{id}/offshelf', ['as' => 'appsads.offshelf', 'uses' => 'Admin_AppsAdsController@offshelf']);
        //Route::post('imageupload', ['as' => 'appsads.upload', 'uses' => 'Admin_AppsAdsController@upload']);
    });
    Route::group(['prefix' => 'rankads', 'before' => 'hasPermissions'], function() //游戏位推广
    {
        Route::get('index', ['as' => 'rankads.index', 'uses' => 'Admin_rankAdsController@index']);
        Route::get('create', ['as' => 'rankads.create', 'uses' => 'Admin_rankAdsController@create']);
        Route::post('create', ['as' => 'rankads.create', 'uses' => 'Admin_rankAdsController@store']);
        Route::get('{id}/edit', ['as' => 'rankads.edit', 'uses' => 'Admin_rankAdsController@edit']);
        Route::post('{id}/edit', ['as' => 'rankads.edit', 'uses' => 'Admin_rankAdsController@update']);
        Route::delete('{id}/delete', ['as' => 'rankads.delete', 'uses' => 'Admin_rankAdsController@destroy']);
        Route::get('{id}/offshelf', ['as' => 'rankads.offshelf', 'uses' => 'Admin_rankAdsController@offshelf']);
    });
    Route::group(['prefix' => 'indexads', 'before' => 'hasPermissions'], function() //首页图片位推广
    {
        Route::get('index', ['as' => 'indexads.index', 'uses' => 'Admin_indexAdsController@index']);
        Route::get('create', ['as' => 'indexads.create', 'uses' => 'Admin_indexAdsController@create']);
        Route::post('create', ['as' => 'indexads.create', 'uses' => 'Admin_indexAdsController@store']);
        Route::get('{id}/edit', ['as' => 'indexads.edit', 'uses' => 'Admin_indexAdsController@edit']);
        Route::post('{id}/edit', ['as' => 'indexads.edit', 'uses' => 'Admin_indexAdsController@update']);
        Route::delete('{id}/delete', ['as' => 'indexads.delete', 'uses' => 'Admin_indexAdsController@destroy']);
        Route::get('{id}/offshelf', ['as' => 'indexads.offshelf', 'uses' => 'Admin_indexAdsController@offshelf']);
    });
    Route::group(['prefix' => 'editorads', 'before' => 'hasPermissions'], function() //编辑推荐
    {
        Route::get('index', ['as'=>'editorads.index', 'uses' => 'Admin_EditorAdsController@index']);
        Route::get('create', ['as'=>'editorads.create', 'uses' => 'Admin_EditorAdsController@create']);
        Route::post('create', ['as'=>'editorads.create', 'uses' => 'Admin_EditorAdsController@store']);
        Route::get('{id}/edit', ['as'=>'editorads.edit', 'uses' => 'Admin_EditorAdsController@edit']);
        Route::post('{id}/edit', ['as'=>'editorads.edit', 'uses' => 'Admin_EditorAdsController@update']);
        Route::delete('{id}/delete', ['as'=>'editorads.delete', 'uses' => 'Admin_EditorAdsController@destroy']);
        Route::get('{id}/offshelf', ['as'=>'editorads.offshelf', 'uses' => 'Admin_EditorAdsController@offshelf']);
    });
    Route::group(['prefix' => 'cateads', 'before' => 'hasPermissions'], function() //分类推广
    {
        Route::get('index', ['as' => 'cateads.index', 'uses' => 'Admin_CateAdsController@index']);
        Route::post('imageupload', ['as' => 'cateads.upload', 'uses' => 'Admin_CateAdsController@upload']);
        Route::post('{id}/edit', ['as' => 'cateads.edit', 'uses' => 'Admin_CateAdsController@update']);
    });


    Route::get('searchapps', ['as' => 'searchapps', 'uses' => 'Admin_IndexController@searchApps']);//智能匹配列表
    Route::get('appsinfo/{id}', ['as' => 'appsinfo', 'uses' => 'Admin_IndexController@appsinfo']);//近期添加列表
});
//图片
Route::post('/admin/appsads/imageupload', ['as' => 'appsads.upload', 'uses' => 'Admin_AppsAdsController@upload']);

//api
Route::group(['prefix' => 'api'], function()
{   
    Route::group(['prefix' => 'v1'], function() //V1版本
    {
        Route::get('game/extend/{type}/{pageSize}/{pageIndex}', ['uses' => '']);
        Route::get('game/cull/{type}/{pageSize}/{pageIndex}', ['uses' => '']);
        Route::get('game/list/{area}/{pageSize}/{pageIndex}', ['uses' => '']);
        Route::get('game/info/edit/downcount/{appid}/{imei}', ['uses' => '']);
        Route::get('game/info/appid/{appid}', ['uses' => '']);
        Route::get('appclient/ver/info/{versionCode}', ['uses' => '']);
        Route::post('game/feedback/add', ['uses' => '']);
        Route::get('game/search/{type}/{keyword}/{exclude}/{pageSize}/{pageIndex}', ['uses' => '']);
        Route::get('game/search/autocomplete/{keyword}', ['uses' => '']);
        Route::get('game/category/all', ['uses' => '']);
        Route::post('game/update', ['uses' => '']);
    });
});

// 404 跳转
Event::listen('404', function()
{
    return '找不到该路径。';
});

// 500 跳转
Event::listen('500', function()
{   
    return '亲，服务器私奔了，工程狮们正在努力寻回。';
});
