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
Route::get('/', function()
{
    return View::make('hello');
});


// 后台处理
Route::group(['prefix' => 'admin'], function()
{
    Route::get('/',        ['as' => 'admin.index',   'uses' => 'Admin_IndexController@index']);
    Route::get('/menu',    ['as' => 'admin.menu',    'uses' => 'Admin_IndexController@menu']);
    Route::get('/welcome', ['as' => 'admin.welcome', 'uses' => 'Admin_IndexController@welcome']);

     // 游戏APP列表
    Route::group(['prefix' => 'apps'], function()
    {
        // 列表
        Route::get('onshelf',  ['as' => 'apps.onshelf',  'uses' => 'Admin_AppsController@onshelf']);
        Route::get('draft',    ['as' => 'apps.draft',    'uses' => 'Admin_AppsController@draft']);
        Route::get('pending',  ['as' => 'apps.pending',  'uses' => 'Admin_AppsController@pending']);
        Route::get('nopass',   ['as' => 'apps.nopass',   'uses' => 'Admin_AppsController@nopass']);
        Route::get('offshelf', ['as' => 'apps.offshelf', 'uses' => 'Admin_AppsController@offshelf']);

        // 编辑
        Route::get('{id}/edit',          ['as' => 'apps.edit',      'uses' => 'Admin_AppsController@edit']);
        Route::put('{id}/edit/{status}', ['as' => 'apps.edit',      'uses' => 'Admin_AppsController@update'])
             ->where('id', '[0-9]+')->where('status', '[A-Za-z]+');
        Route::delete('{id}/delete', ['as' => 'apps.delete',    'uses' => 'Admin_AppsController@destroy']);

        // 历史

        // 全选
        Route::get('allpass', ['uses' => 'Admin_AppsController@allpass']);
        Route::get('allnopass', ['uses' => 'Admin_AppsController@allnopass']);

        // 上传
        Route::post('imageupload', ['as' => 'apps.imageupload', 'uses' => 'Admin_AppsController@imageUpload']);
        Route::post('appupload/{dontSave?}', ['as' => 'apps.appupload', 'uses' => 'Admin_AppsController@appUpload']);

    });


    Route::group(['prefix' => 'user'], function() //用户列表
    {
        Route::post('signin', ['uses' => 'UserController@showProfile']);
        Route::get('signout', ['uses' => 'UserController@showProfile']);

        Route::get('create', ['uses' => 'UserController@showProfile']);
        Route::post('create', ['uses' => 'UserController@showProfile']);
        Route::get('delete', ['uses' => 'UserController@showProfile']);
        Route::post('repassword', ['uses' => 'UserController@showProfile']);
    });

    Route::group(['prefix' => 'cate'], function() //游戏分类
    {
        Route::get('index', ['as' => 'cate.index', 'uses' => 'Admin_CatesController@index']);
        Route::get('create', ['as' => 'cate.create', 'uses' => 'Admin_CatesController@create']);
        Route::post('create', ['as' => 'cate.create', 'uses' => 'Admin_CatesController@store']);
        Route::post('{id}/edit', ['as' => 'cate.edit', 'uses' => 'Admin_CatesController@update']);
        Route::get('{id}/delete', ['as' => 'cate.delete', 'uses' => 'Admin_CatesController@destroy']);
        Route::get('{id}', ['as' => 'cate.show', 'uses' => 'Admin_CatesController@show']);
    });
    Route::group(['prefix' => 'tag'], function() //游戏标签
    {
        Route::get('index', ['as' => 'tag.index', 'uses' => 'Admin_CatesController@tagIndex']);
        Route::get('create', ['as' => 'tag.create', 'uses' => 'Admin_CatesController@tagCreate']);
        Route::post('create', ['as' => 'tag.create', 'uses' => 'Admin_CatesController@tagStore']);
        Route::post('{id}/edit', ['as' => 'tag.edit', 'uses' => 'Admin_CatesController@update']);
        Route::get('{id}/delete', ['as' => 'tag.delete', 'uses' => 'Admin_CatesController@destroy']);
        Route::get('{id}/show', ['as' => 'tag.show', 'uses' => 'Admin_CatesController@show']);
    });
    Route::group(['prefix' => 'rating'], function() //游戏评分
    {
        Route::get('index', ['uses' => 'UserController@showProfile']);
        Route::post('create', ['uses' => 'UserController@showProfile']);
        Route::post('{id}/edit', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/delete}', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/show', ['uses' => 'UserController@showProfile']);
    });
    Route::group(['prefix' => 'comment'], function() //游戏评论
    {
        Route::get('index', ['uses' => 'UserController@showProfile']);
        Route::post('{id}/edit', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/delete}', ['uses' => 'UserController@showProfile']);
    });
    Route::group(['prefix' => 'stopword'], function() //游戏屏蔽词
    {
        Route::get('index', ['uses' => 'UserController@showProfile']);
        Route::post('{id}/edit', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/delete', ['uses' => 'UserController@showProfile']);
    });
    Route::group(['prefix' => 'keyword'], function() //游戏关键词
    {
        Route::get('index', ['as' => 'keyword.index', 'uses' => 'Admin_KeywordsController@index']);
        Route::post('create', ['as' => 'keyword.store', 'uses' => 'Admin_KeywordsController@store']);
        Route::post('{id}/edit', ['as' =>'keyword.update', 'uses' => 'Admin_KeywordsController@update']);
        Route::get('{id}/delete', ['as' =>'keyword.delete', 'uses' => 'Admin_KeywordsController@destroy']);
    });
    Route::group(['prefix' => 'appsads'], function() //游戏位推广
    {
        Route::get('index', ['as' => 'appsads.index', 'uses' => 'Admin_AppsAdsController@index']);
        Route::get('create', ['as' => 'appsads.create', 'uses' => 'Admin_AppsAdsController@create']);
        Route::post('create', ['as' => 'appsads.create', 'uses' => 'Admin_AppsAdsController@store']);
        Route::get('{id}/edit', ['as' => 'appsads.edit', 'uses' => 'Admin_AppsAdsController@edit']);
        Route::post('{id}/edit', ['as' => 'appsads.update', 'uses' => 'Admin_AppsAdsController@update']);
        Route::get('{id}/delete', ['as' => 'appsads.delete', 'uses' => 'Admin_AppsAdsController@destroy']);
        Route::get('{id}/top', ['as' => 'appsads.top', 'uses' => 'Admin_AppsAdsController@top']);
        Route::get('{id}/notop', ['as' => 'appsads.notop', 'uses' => 'Admin_AppsAdsController@notop']);
        Route::get('{id}/onshelf', ['as' => 'appsads.onshelf', 'uses' => 'Admin_AppsAdsController@onshelf']);
        Route::get('{id}/offshelf', ['as' => 'appsads.offshelf', 'uses' => 'Admin_AppsAdsController@offshelf']);
        Route::post('imageupload', ['as' => 'appsads.upload', 'uses' => 'Admin_AppsAdsController@upload']);
    });
    Route::group(['prefix' => 'rankads'], function() //游戏位推广
    {
        Route::get('index', ['as' => 'rankads.index', 'uses' => 'AppsAdsController@index']);
        Route::post('create', ['as' => 'rankads.create', 'uses' => 'AppsAdsController@showProfile']);
        Route::get('{id}/delete}', ['as' => 'rankads.delete', 'uses' => 'AppsAdsController@showProfile']);
        Route::get('{id}/top}', ['as' => 'rankads.index', 'uses' => 'AppsAdsController@showProfile']);
        Route::get('{id}/notop}', ['as' => 'rankads.index', 'uses' => 'AppsAdsController@showProfile']);
        Route::get('{id}/onshelf}', ['as' => 'rankads.index', 'uses' => 'AppsAdsController@showProfile']);
        Route::get('{id}/offshelf}', ['as' => 'rankads.index', 'uses' => 'AppsAdsController@showProfile']);
    });
    Route::group(['prefix' => 'indexads'], function() //首页图片位推广
    {
        Route::get('index', ['uses' => 'UserController@showProfile']);
        Route::post('create', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/delete}', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/top}', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/notop}', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/onshelf}', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/offshelf}', ['uses' => 'UserController@showProfile']);
    });
    Route::group(['prefix' => 'editorads'], function() //编辑推荐
    {
        Route::get('index', ['uses' => 'UserController@showProfile']);
        Route::post('create', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/delete}', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/top}', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/notop}', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/onshelf}', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/offshelf}', ['uses' => 'UserController@showProfile']);
    });
    Route::group(['prefix' => 'cateads'], function() //分类推广
    {
        Route::get('index', ['as' => 'cateads.index', 'uses' => 'Admin_CateAdsController@index']);
        Route::post('imageupload', ['as' => 'cateads.upload', 'uses' => 'Admin_CateAdsController@upload']);
        Route::post('{id}/edit', ['as' => 'cateads.edit', 'uses' => 'Admin_CateAdsController@update']);
    });


    Route::get('searchapps', ['as' => 'searchapps', 'uses' => 'Admin_IndexController@searchApps']);//智能匹配列表
    Route::get('appsinfo/{id}', ['as' => 'appsinfo', 'uses' => 'Admin_IndexController@appsinfo']);//近期添加列表
});

// 404 跳转
Event::listen('404', function()
{
    return Response::error('404');
});
