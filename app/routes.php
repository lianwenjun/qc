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

Route::get('/', function()
{
    return View::make('hello');
});

Route::get('/routes', function()
{
    $routeCollection = Route::getRoutes();

    foreach ($routeCollection as $value) {
        echo $value->getActionName();
        echo $value->getName();
        //print_r($value->getAction());
        //dd("<br />");
        echo "<br />";
        //exit;
    }
});

// 后台处理
Route::group(['prefix' => 'admin'], function()
{

    Route::group(['prefix' => 'apps'], function() //游戏APP列表
    {
        //列表
        Route::get('index', ['as' => 'apps.index', 'uses' => 'UserController@showProfile']);
        Route::get('onshelf', ['as' => 'apps.onshelf', 'uses' => 'UserController@showProfile']);
        Route::get('offshelf', ['uses' => 'UserController@showProfile']);
        Route::get('review', ['uses' => 'UserController@showProfile']);
        Route::get('nopass', ['uses' => 'UserController@showProfile']);
        //操作
        Route::get('create', ['uses' => 'UserController@showProfile']);
        Route::post('create', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/edit', ['uses' => 'UserController@showProfile']);
        Route::post('{id}/edit', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/delete', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/onshelf', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/reonshelf', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/offshelf', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/pass', ['uses' => 'UserController@showProfile']);
        Route::post('{id}/nopass', ['uses' => 'UserController@showProfile']);
        //全选
        Route::get('allpass', ['uses' => 'UserController@showProfile']);
        Route::get('allnopass', ['uses' => 'UserController@showProfile']);
        //上传
        Route::post('imageupload', ['uses' => 'UserController@showProfile']);
        Route::post('appupload', ['uses' => 'UserController@showProfile']);
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
        Route::get('index', ['uses' => 'UserController@showProfile']);
        Route::get('create', ['uses' => 'UserController@showProfile']);
        Route::post('create', ['uses' => 'UserController@showProfile']);
        Route::post('{id}/edit', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/delete}', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/show', ['uses' => 'UserController@showProfile']);
    });
    Route::group(['prefix' => 'tag'], function() //游戏标签
    {
        Route::get('index', ['uses' => 'UserController@showProfile']);
        Route::post('create', ['uses' => 'UserController@showProfile']);
        Route::post('{id}/edit', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/delete}', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/show', ['uses' => 'UserController@showProfile']);
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
        Route::get('{id}/delete}', ['uses' => 'UserController@showProfile']);
    });
    Route::group(['prefix' => 'kewword'], function() //游戏关键词
    {
        Route::get('index', ['uses' => 'UserController@showProfile']);
        Route::post('{id}/edit', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/delete}', ['uses' => 'UserController@showProfile']);
    });
    Route::group(['prefix' => 'appsads'], function() //游戏位推广
    {
        Route::get('index', ['uses' => 'UserController@showProfile']);
        Route::post('create', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/delete}', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/top}', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/notop}', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/onshelf}', ['uses' => 'UserController@showProfile']);
        Route::get('{id}/offshelf}', ['uses' => 'UserController@showProfile']);
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
        Route::get('index', ['uses' => 'UserController@showProfile']);
        Route::post('{id}/imageupload', ['uses' => 'UserController@showProfile']);
    });


    Route::get('index', ['uses' => 'UserController@showProfile']);//智能匹配列表
    Route::get('lastapps', ['uses' => 'UserController@showProfile']);//近期添加列表
});

//SQL记录
if (Config::get('database.log', false))
{           
    Event::listen('illuminate.query', function($query, $bindings, $time, $name)
    {
        $data = compact('bindings', 'time', 'name');

        // Format binding data for sql insertion
        foreach ($bindings as $i => $binding)
        {   
            if ($binding instanceof \DateTime)
            {   
                $bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
            }
            else if (is_string($binding))
            {   
                $bindings[$i] = "'$binding'";
            }
        }   

        // Insert bindings into query
        $query = str_replace(array('%', '?'), array('%%', '%s'), $query);
        $query = vsprintf($query, $bindings); 

        Log::info($query, $data);
    });
}
// 404 跳转
Event::listen('404', function()
{
    return Response::error('404');
});
