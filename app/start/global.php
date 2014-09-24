<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

    app_path().'/commands',
    app_path().'/controllers',
    app_path().'/models',
    app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

// Log::useFiles(storage_path().'/logs/laravel.log');
$logFile = 'log-'.php_sapi_name().'.txt';
Log::useDailyFiles(storage_path().'/logs/'.$logFile);

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
    Log::error($exception);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
    return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';

// 面包屑
require 'breadcrumbs.php';

/**
 * 获得上传 hash 目录
 * 
 * @param $type     string 上传目录配置
 * @param $filename string 文件名
 *
 * @return array 上传目录 ['dir', 'filename']
 */
function uploadPath($type, $filename)
{

    $config = Config::get('upload');
    if(! in_array($type, array_keys($config))) {
        $dir = public_path() . '/uploads';
        return [$dir, $filename];
    }

    $hash  = md5(microtime(true));
    $hashs = str_split($hash);
    $dir   = public_path() . Config::get('upload.'.$type);

    $dir    .=  sprintf('/%s/%s', $hashs[0], $hashs[1]);
    $info    = pathinfo($filename);
    $newName = sprintf('%s.%s', $hash, $info['extension']);

    return [$dir, $newName];
}
