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
Route::pattern('pageSize', '[0-9]+');
Route::pattern('pageIndex', '[0-9]+');
Route::get('/', function()
{
    return Redirect::route('admin.index');
});
// usage inside a laravel route
Route::get('/test/image', function()
{
    Image::configure(array('driver' => 'imagick'));
    $img = Image::make(public_path() . '/test1.png');
    // print_r($img);
    // $img->resize(222, 371);
    //$img->fit(720, 1200);
    //$img->heighten(371);
    //$img->widen(222);
    //$img->trim();
    $img->crop(480, 800, 0, 0);
    $w = $img->width();
    $h = $img->height();
    //$img = Image::canvas(32, 32, '#ffffff');
    //echo $w, $h;
    return $img->response('jpg');
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
        Route::get('stock', ['as' => 'apps.stock', 'uses' => 'Admin_Apps_IndexController@stock']);
        Route::get('draft', ['as' => 'apps.draft', 'uses' => 'Admin_Apps_IndexController@draft']);
        Route::get('pending', ['as' => 'apps.pending', 'uses' => 'Admin_Apps_IndexController@pending']);
        Route::get('notpass', ['as' => 'apps.notpass', 'uses' => 'Admin_Apps_IndexController@notpass']);
        Route::get('unstock', ['as' => 'apps.unstock', 'uses' => 'Admin_Apps_IndexController@unstock']);

        // 历史
        Route::get('stock/{id}/history', ['as' => 'apps.history', 'uses' => 'Admin_Apps_IndexController@history'])
             ->where('id', '[0-9]+');

        // 编辑页面
        Route::get('stock/{id}', ['as' => 'apps.stock.edit', 'uses' => 'Admin_Apps_IndexController@edit'])
             ->where('id', '[0-9]+');
        Route::get('draft/{id}', ['as' => 'apps.draft.edit', 'uses' => 'Admin_Apps_IndexController@edit'])
             ->where('id', '[0-9]+');
        Route::get('notpass/{id}', ['as' => 'apps.notpass.edit', 'uses' => 'Admin_Apps_IndexController@edit'])
             ->where('id', '[0-9]+');

        Route::get('unstock/{id}', ['as' => 'apps.unstock.edit', 'uses' => 'Admin_Apps_IndexController@edit'])
             ->where('id', '[0-9]+');

        // 编辑处理
        Route::put('stock/{id}', ['as' => 'apps.stock.edit', 'uses' => 'Admin_Apps_IndexController@update'])
             ->where('id', '[0-9]+');
        Route::put('draft/{id}', ['as' => 'apps.draft.edit', 'uses' => 'Admin_Apps_IndexController@update'])
             ->where('id', '[0-9]+');
        Route::put('pending/{id}', ['as' => 'apps.pending.edit', 'uses' => 'Admin_Apps_IndexController@update'])
             ->where('id', '[0-9]+');

        // 删除
        Route::delete('{id}', ['as' => 'apps.delete', 'uses' => 'Admin_Apps_IndexController@destroy'])
             ->where('id', '[0-9]+');

        // 审核
        Route::put('putStock', ['as' => 'apps.putStock', 'uses' => 'Admin_Apps_IndexController@putStock']);
        Route::put('putNotpass', ['as' => 'apps.putNotpass', 'uses' => 'Admin_Apps_IndexController@putNotpass']);


        // 下架
        Route::put('putUnstock', ['as' => 'apps.putUnstock', 'uses' => 'Admin_Apps_IndexController@putUnstock']);

        // 预览
        Route::get('{id}/preveiw', ['as' => 'apps.preview', 'uses' => 'Admin_Apps_IndexController@preview'])
             ->where('id', '[0-9]+');

        // 上传
        Route::post('imageupload', ['as' => 'apps.imageupload', 'uses' => 'Admin_Apps_IndexController@imageUpload']);
        Route::post('appupload/{id?}', ['as' => 'apps.appupload', 'uses' => 'Admin_Apps_IndexController@appUpload'])
             ->where('id', '[0-9]+');
        Route::post('iconupload', ['as' => 'apps.iconupload', 'uses' => 'Admin_Apps_IndexController@iconUpload']);// 游戏icon上传
    });

     // 管理员
    Route::group(['prefix' => 'users', 'before' => 'hasPermissions'], function()
    {
        Route::get('index', ['as' => 'users.index', 'uses' => 'Admin_UsersController@index']);
        Route::get('create', ['as' => 'users.create', 'uses' => 'Admin_UsersController@create']);
        Route::post('create', ['as' => 'users.create', 'uses' => 'Admin_UsersController@store']);
        Route::get('{id}', ['as' => 'users.edit', 'uses' => 'Admin_UsersController@edit'])
             ->where('id', '[0-9]+');
        Route::put('{id}', ['as' => 'users.edit', 'uses' => 'Admin_UsersController@update'])
             ->where('id', '[0-9]+');
        Route::delete('{id}', ['as' => 'users.delete', 'uses' => 'Admin_UsersController@destroy']);
    });

    // 角色组
    Route::group(['prefix' => 'roles', 'before' => 'hasPermissions'], function()
    {
        Route::get('index', ['as' => 'roles.index', 'uses' => 'Admin_RolesController@index']);
        Route::get('create', ['as' => 'roles.create', 'uses' => 'Admin_RolesController@create']);
        Route::post('create', ['as' => 'roles.store', 'uses' => 'Admin_RolesController@store']);
        Route::get('{id}', ['as' => 'roles.edit', 'uses' => 'Admin_RolesController@edit'])
             ->where('id', '[0-9]+');
        Route::put('{id}', ['as' => 'roles.edit', 'uses' => 'Admin_RolesController@update'])
             ->where('id', '[0-9]+');
        Route::delete('{id}', ['as' => 'roles.delete', 'uses' => 'Admin_RolesController@destroy'])
             ->where('id', '[0-9]+');
    });

    Route::group(['prefix' => 'cats', 'before' => 'hasPermissions'], function() //游戏分类
    {
        Route::get('/', ['as' => 'cats.index', 'uses' => 'Admin_Cat_CatsController@index']);
        Route::get('create', ['as' => 'cats.create', 'uses' => 'Admin_Cat_CatsController@create']);
        Route::post('/', ['as' => 'cats.create', 'uses' => 'Admin_Cat_CatsController@store']);
        Route::put('{id}', ['as' => 'cats.edit', 'uses' => 'Admin_Cat_CatsController@update']);
        Route::get('{id}/edit', ['as' => 'cats.edit', 'uses' => 'Admin_Cat_CatsController@edit']);
        Route::delete('{id}', ['as' => 'cats.delete', 'uses' => 'Admin_Cat_CatsController@destroy']);
        // Route::get('{id}', ['as' => 'cat.show', 'uses' => 'Admin_Cat_CatsController@show']);
    });

    Route::group(['prefix' => 'tags', 'before' => 'hasPermissions'], function() //游戏标签
    {
        Route::get('/', ['as' => 'tags.index', 'uses' => 'Admin_Cat_TagsController@index']);// 标签库首页
        Route::post('/', ['as' => 'tags.create', 'uses' => 'Admin_Cat_TagsController@store']);// 标签库添加
        Route::put('{id}', ['as' => 'tags.update', 'uses' => 'Admin_Cat_TagsController@update']);// 标签库排序编辑更新
        Route::delete('{id}', ['as' => 'tags.delete', 'uses' => 'Admin_Cat_TagsController@destroy']);// 游戏分类删除
    });

    Route::group(['prefix' => 'gamecattags', 'before' => 'hasPermissions'], function() //游戏分类标签
    {
        Route::get('/', ['as' => 'gamecattags.index', 'uses' => 'Admin_Cat_GameCatTagsController@index']);// 游戏分类标签首页
        Route::post('/', ['as' => 'gamecattags.create', 'uses' => 'Admin_Cat_GameCatTagsController@store']);// 游戏分类标签添加
        Route::delete('{id}', ['as' => 'gamecattags.delete', 'uses' => 'Admin_Cat_GameCatTagsController@destroy']);// 游戏分类删除
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
    Route::group(['prefix' => 'feedback', 'before' => 'hasPermissions'], function() //应用反馈
    {
        Route::get('index', ['as' => 'feedback.index', 'uses' => 'Admin_FeedbackController@index']);
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

    
    // 老版本广告路由
    Route::group(['prefix' => 'appsads', 'before' => 'hasPermissions'], function() //游戏位推广
    {
        Route::get('index', ['as' => 'appsads.index', 'uses' => 'Admin_Apps_AppsAdsController@index']);
        Route::get('create', ['as' => 'appsads.create', 'uses' => 'Admin_Apps_AppsAdsController@create']);
        Route::post('create', ['as' => 'appsads.create', 'uses' => 'Admin_Apps_AppsAdsController@store']);
        Route::get('{id}/edit', ['as' => 'appsads.edit', 'uses' => 'Admin_Apps_AppsAdsController@edit']);
        Route::post('{id}/edit', ['as' => 'appsads.edit', 'uses' => 'Admin_Apps_AppsAdsController@update']);
        Route::delete('{id}/delete', ['as' => 'appsads.delete', 'uses' => 'Admin_Apps_AppsAdsController@destroy']);
        Route::get('{id}/unstock', ['as' => 'appsads.unstock', 'uses' => 'Admin_Apps_AppsAdsController@unstock']);
        Route::post('imageupload', ['as' => 'appsads.upload', 'uses' => 'Admin_Apps_AppsAdsController@upload']);
    });
    
    Route::group(['prefix' => 'rankads', 'before' => 'hasPermissions'], function() //游戏位推广
    {
        Route::get('index', ['as' => 'rankads.index', 'uses' => 'Admin_rankAdsController@index']);
        Route::get('create', ['as' => 'rankads.create', 'uses' => 'Admin_rankAdsController@create']);
        Route::post('create', ['as' => 'rankads.create', 'uses' => 'Admin_rankAdsController@store']);
        Route::get('{id}/edit', ['as' => 'rankads.edit', 'uses' => 'Admin_rankAdsController@edit']);
        Route::post('{id}/edit', ['as' => 'rankads.edit', 'uses' => 'Admin_rankAdsController@update']);
        Route::delete('{id}/delete', ['as' => 'rankads.delete', 'uses' => 'Admin_rankAdsController@destroy']);
        Route::get('{id}/unstock', ['as' => 'rankads.unstock', 'uses' => 'Admin_rankAdsController@unstock']);
    });

    Route::group(['prefix' => 'indexads', 'before' => 'hasPermissions'], function() //首页图片位推广
    {
        Route::get('index', ['as' => 'indexads.index', 'uses' => 'Admin_indexAdsController@index']);
        Route::get('create', ['as' => 'indexads.create', 'uses' => 'Admin_indexAdsController@create']);
        Route::post('create', ['as' => 'indexads.create', 'uses' => 'Admin_indexAdsController@store']);
        Route::get('{id}/edit', ['as' => 'indexads.edit', 'uses' => 'Admin_indexAdsController@edit']);
        Route::post('{id}/edit', ['as' => 'indexads.edit', 'uses' => 'Admin_indexAdsController@update']);
        Route::delete('{id}/delete', ['as' => 'indexads.delete', 'uses' => 'Admin_indexAdsController@destroy']);
        Route::get('{id}/unstock', ['as' => 'indexads.unstock', 'uses' => 'Admin_indexAdsController@unstock']);
        Route::post('imageupload', ['as' => 'indexads.upload', 'uses' => 'Admin_indexAdsController@upload']);
    });

    Route::group(['prefix' => 'editorads', 'before' => 'hasPermissions'], function() //编辑推荐
    {
        Route::get('index', ['as'=>'editorads.index', 'uses' => 'Admin_EditorAdsController@index']);
        Route::get('create', ['as'=>'editorads.create', 'uses' => 'Admin_EditorAdsController@create']);
        Route::post('create', ['as'=>'editorads.create', 'uses' => 'Admin_EditorAdsController@store']);
        Route::get('{id}/edit', ['as'=>'editorads.edit', 'uses' => 'Admin_EditorAdsController@edit']);
        Route::post('{id}/edit', ['as'=>'editorads.edit', 'uses' => 'Admin_EditorAdsController@update']);
        Route::delete('{id}/delete', ['as'=>'editorads.delete', 'uses' => 'Admin_EditorAdsController@destroy']);
        Route::get('{id}/unstock', ['as'=>'editorads.unstock', 'uses' => 'Admin_EditorAdsController@unstock']);
        Route::post('imageupload', ['as' => 'editorads.upload', 'uses' => 'Admin_EditorAdsController@upload']);
    });

    // 新版本广告路由
    Route::group(['prefix' => 'banners', 'before' => 'hasPermissions'], function() //游戏位推广
    {
        Route::get('/', ['as' => 'banners.index', 'uses' => 'Admin_Ads_BannersController@index']);// 首页图片位管理首页
        Route::get('create', ['as' => 'banners.create', 'uses' => 'Admin_Ads_BannersController@create']);// 首页图片位管理添加页接口
        Route::post('create', ['as' => 'banners.create', 'uses' => 'Admin_Ads_BannersController@store']);// 首页图片位管理添加
        Route::get('{id}/edit', ['as' => 'banners.edit', 'uses' => 'Admin_Ads_BannersController@edit']);// 首页图片位管理编辑页接口
        Route::put('{id}/edit', ['as' => 'banners.edit', 'uses' => 'Admin_Ads_BannersController@update']);// 首页图片位管理更新
        Route::delete('{id}', ['as' => 'banners.delete', 'uses' => 'Admin_Ads_BannersController@destroy']);
        Route::put('{id}/unstock', ['as' => 'banners.unstock', 'uses' => 'Admin_Ads_BannersController@unstock']);
        Route::post('image', ['as' => 'banners.imageupload', 'uses' => 'Admin_Ads_BannersController@imageUpload']);// 首页图片位图片上传接口
    });

    Route::group(['prefix' => 'topics', 'before' => 'hasPermissions'], function() // 专题广告推广
    {
        Route::get('/', ['as' => 'edittopics.index', 'uses' => 'Admin_TopicsController@editTopics']);// 专题首页
        Route::get('stock', ['as' => 'stocktopics.index', 'uses' => 'Admin_TopicsController@stockTopics']);// 专题首页
        Route::get('create', ['as' => 'topics.create', 'uses' => 'Admin_TopicsController@create']);// 专题添加页
        Route::post('create', ['as' => 'topics.create', 'uses' => 'Admin_TopicsController@store']);// 专题添加接口
        Route::get('{id}/show', ['as' => 'topics.show', 'uses' => 'Admin_TopicsController@show']);// 查看详情
        Route::get('{id}/edit', ['as' => 'topics.edit', 'uses' => 'Admin_TopicsController@edit']);// 专题编辑页
        Route::put('{id}/edit', ['as' => 'topics.edit', 'uses' => 'Admin_TopicsController@update']);// 专题编辑页
        Route::put('{id}/unstock', ['as' => 'topics.unstock', 'uses' => 'Admin_TopicsController@unstock']);// 专题下架
        Route::put('{id}/revocate', ['as' => 'topics.revocate', 'uses' => 'Admin_TopicsController@revocate']);// 专题撤销
        Route::delete('{id}', ['as' => 'topics.delete', 'uses' => 'Admin_TopicsController@destroy']);// 专题删除
    });

    // 广告路由整合
    Route::group(['prefix' => 'ads', 'before' => 'hasPermissions'], function() 
    {
        Route::get('/ranks', ['as' => 'ads.ranks.index', 'uses' => 'Admin_Ads_GameAdsController@ranks']);
        Route::get('/apps', ['as' => 'ads.apps.index','uses' => 'Admin_Ads_GameAdsController@apps']); 
        Route::get('/choice', ['as' => 'ads.choice.index', 'uses' => 'Admin_Ads_GameAdsController@choice']);

        Route::get('/ranks/create', ['as' => 'ads.ranks.create', 'uses' => 'Admin_Ads_GameAdsController@create']);
        Route::get('/apps/create', ['as' => 'ads.apps.create', 'uses' => 'Admin_Ads_GameAdsController@create']);
        Route::get('/choice/create', ['as' => 'ads.choice.create', 'uses' => 'Admin_Ads_GameAdsController@create']);
        
        Route::post('/ranks/create', ['as' => 'ads.ranks.create', 'uses' => 'Admin_Ads_GameAdsController@store']);
        Route::post('/apps/create', ['as' => 'ads.apps.create', 'uses' => 'Admin_Ads_GameAdsController@store']);
        Route::post('/choice/create', ['as' => 'ads.choice.create', 'uses' => 'Admin_Ads_GameAdsController@store']);

        Route::get('/ranks/{id}/edit', ['as' => 'ads.ranks.edit', 'uses' => 'Admin_Ads_GameAdsController@edit']);
        Route::get('/apps/{id}/edit', ['as' => 'ads.apps.edit', 'uses' => 'Admin_Ads_GameAdsController@edit']);
        Route::get('/choice/{id}/edit', ['as' => 'ads.choice.edit', 'uses' => 'Admin_Ads_GameAdsController@edit']);

        Route::put('/ranks/{id}/edit', ['as' => 'ads.ranks.edit', 'uses' => 'Admin_Ads_GameAdsController@update']);
        Route::put('/apps/{id}/edit', ['as' => 'ads.apps.edit', 'uses' => 'Admin_Ads_GameAdsController@update']);
        Route::put('/choice/{id}/edit', ['as' => 'ads.choice.edit', 'uses' => 'Admin_Ads_GameAdsController@update']);

        Route::delete('/ranks/{id}', ['as' => 'ads.ranks.delete', 'uses' => 'Admin_Ads_GameAdsController@destroy']);
        Route::delete('/apps/{id}', ['as' => 'ads.apps.delete', 'uses' => 'Admin_Ads_GameAdsController@destroy']);
        Route::delete('/choice/{id}', ['as' => 'ads.choice.delete', 'uses' => 'Admin_Ads_GameAdsController@destroy']);

        Route::put('/ranks/{id}/unstock', ['as' => 'ads.ranks.unstock', 'uses' => 'Admin_Ads_GameAdsController@unstock']);
        Route::put('/apps/{id}/unstock', ['as' => 'ads.apps.unstock', 'uses' => 'Admin_Ads_GameAdsController@unstock']);
        Route::put('/choice/{id}/unstock', ['as' => 'ads.choice.unstock', 'uses' => 'Admin_Ads_GameAdsController@unstock']);
        // Route::post('/{type}/image', ['as' => 'ads.imageupload', 'uses' => 'Admin_Ads_GameAdsController@imageUpload']);
    });

    Route::group(['prefix' => 'catads', 'before' => 'hasPermissions'], function() //分类推广
    {
        Route::get('index', ['as' => 'catads.index', 'uses' => 'Admin_Cat_CatAdsController@index']);
        Route::post('imageupload', ['as' => 'catads.upload', 'uses' => 'Admin_Cat_CatAdsController@upload']);
        Route::post('{id}/edit', ['as' => 'catads.edit', 'uses' => 'Admin_Cat_CatAdsController@update']);
    });

    Route::group(['prefix' => 'appsapk', 'before' => 'hasPermissions'], function() //分类推广
    {
        Route::get('index', ['as' => 'appsapk.index', 'uses' => 'Admin_Cat_CatAdsController@index']);
        Route::post('upload', ['as' => 'catads.upload', 'uses' => 'Admin_Cat_CatAdsController@upload']);
        Route::post('{id}/edit', ['as' => 'catads.edit', 'uses' => 'Admin_Cat_CatAdsController@update']);
    });

    Route::get('searchapps', ['as' => 'searchapps', 'uses' => 'Admin_IndexController@searchApps']);//智能匹配列表
    Route::get('appsinfo/{id}', ['as' => 'appsinfo', 'uses' => 'Admin_IndexController@appsinfo']);//近期添加列表

    // 数据中心
    Route::group(['prefix' => 'statistics'], function()
    {
        Route::get('statistics/appdownloads', ['as' => 'statistics.appdownloads', 'uses' => 'Admin_StatisticsController@appDownloads']);
        Route::get('export/downloads', ['as' => 'statistics.exportdownloads', 'uses' => 'Admin_StatisticsController@exportDownloads']);
    });

    Route::group(['prefix' => 'log', 'before' => 'hasPermissions'], function()  // 日志管理
    {
        Route::get('index', ['as' => 'log.index', 'uses' => 'Admin_LogController@index']);
    });

    //游戏中心APP
    Route::group(['prefix' => 'client'], function()  // 日志管理
    {
        Route::get('index', ['as' => 'client.index', 'uses' => 'Admin_Apps_ClientController@index']);
        Route::get('create', ['as' => 'client.create', 'uses' => 'Admin_Apps_ClientController@create']);
        Route::post('create', ['as' => 'client.create', 'uses' => 'Admin_Apps_ClientController@store']);
        Route::get('edit/{id}', ['as' => 'client.edit', 'uses' => 'Admin_Apps_ClientController@edit']);
        Route::post('edit/{id}', ['as' => 'client.edit', 'uses' => 'Admin_Apps_ClientController@update']);
        Route::post('apkupload', ['as' => 'client.apkupload', 'uses' => 'Admin_Apps_ClientController@apkupload']);
    });

    Route::group(['prefix' => 'channels'], function()
    {
        Route::post('create', ['as' => 'channels.store', 'uses' => 'Admin_ChannelsController@store']);
    });
});
//图片
//Route::post('/admin/appsads/imageupload', ['as' => 'appsads.upload', 'uses' => 'Admin_Apps_AppsAdsController@upload']);


Route::group(['prefix' => 'api'], function() //V1版本
{
    Route::get('game/extend/{type}/{pageSize}/{pageIndex}', ['uses' => 'V1_AdsController@banner']);
    Route::get('game/cull/{type}/{pageSize}/{pageIndex}', ['uses' => 'V1_AdsController@editor']);
    Route::get('game/list/{area}/{pageSize}/{pageIndex}', ['uses' => 'V1_AdsController@app']);
    
    Route::get('game/info/appid/{appid}', ['uses' => 'V1_AppsController@info']);
    Route::get('game/search/{type}/{keyword}/{exclude}/{pageSize}/{pageIndex}', ['uses' => 'V1_AppsController@search']);
    Route::get('game/search/autocomplete/{keyword}', ['uses' => 'V1_AppsController@autoComplete']);
    
    Route::get('game/category/all', ['api.cats.index', 'uses' => 'V1_CatsController@index']);
    

    Route::get('game/info/edit/download/request', ['uses' => 'V1_AppDownloadController@request']);
    Route::get('game/info/edit/download/installed', ['uses' => 'V1_AppDownloadController@installed']);
    Route::get('game/info/edit/downcount/{appid}/{imei}', ['uses' => 'V1_AppDownloadController@download']);
    
    Route::post('client/apps/list', ['uses' => 'V1_AppsController@clientList']);
    Route::post('game/update', ['uses' => 'V1_AppsController@check']);

    Route::get('appclient/ver/update/{versionCode}', ['uses' => 'V1_ClientController@checkVersion']);
    Route::get('appclient/ver/info/{versionCode}', ['uses' => 'V1_ClientController@checkVersion']);
    Route::post('game/feedback/add', ['uses' => 'V1_FeedbacksController@store']);
    
    //Route::get('/', ['uses' => 'V1_BaseController@result']);
});


Route::group(['prefix' => 'darwin'], function() // darwin版本
{   
    Route::group(['prefix' => 'games'], function() {
        Route::get('/choice', ['uses' => 'Darwin_GamesController@choice']);// 第一次启动应用弹出精选必玩!
        Route::get('/rank', ['uses' => 'Darwin_GamesController@ranks']);// 游戏排行
    });

    Route::group(['prefix' => 'cats'], function() {
        Route::get('/', ['uses' => 'Darwin_CatsController@catIndex']);// 游戏分类
        Route::get('/{cat_id}', ['uses' => 'Darwin_CatsController@cats']);// 分类的游戏列表
    });

    Route::group(['prefix' => 'tags'], function() {
        Route::get('/{tags_id}', ['uses' => 'Darwin_CatsController@tags']);// 标签游戏列表
        Route::get('/hot', ['uses' => 'Darwin_CatsController@hotTags']);// 本周热门标签
    });

    Route::group(['prefix' => 'topics'], function() {
        Route::get('/', ['uses' => 'Darwin_TopicsController@oldTopics']);// 专题往期列表
        Route::get('/banner', ['uses' => 'Darwin_TopicsController@topicsBanner']);// 专题列表推广图[最新专题]
        Route::get('/{id}', ['uses' => 'Darwin_TopicsController@topics']);// 专题列表游戏
    });
});