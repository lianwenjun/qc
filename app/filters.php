<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
    //
});


App::after(function($request, $response)
{
    //
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
    if (Auth::guest())
    {
        if (Request::ajax())
        {
            return Response::make('Unauthorized', 401);
        }
        else
        {
            return Redirect::guest('login');
        }
    }
});

Route::filter('adminAuth', function()
{
    if (! Sentry::check())
    {
        return Redirect::route('users.signin');
    }
});

Route::filter('hasPermissions', function()
{
    // if(
    //     !Sentry::getUser()->hasAccess(Route::current()->getName())
    //     &&  Route::current()->getName() != 'accessDenied'
    //   ) {
    //     return Redirect::route('accessDenied');
    // }
});


Route::filter('auth.basic', function()
{
    return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
    if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
    if (Session::token() != Input::get('_token'))
    {
        throw new Illuminate\Session\TokenMismatchException;
    }
});

//过滤浏览器IE10以下
Route::filter('IE10', function()
{
    $userAgent = Request::header('User-Agent');
    $userAgentRegx = '/MSIE/i';
    $versionRegx = '/MSIE\s[5|6|7|8|9].\d*/i';
    $isIE = preg_match($userAgentRegx, $userAgent);
    $isLowIE10 = preg_match($versionRegx, $userAgent);
    if ($isIE && $isLowIE10){
        return '由于使用了HTML5功能，请使用不低于IE10版本的IE浏览器或者其他支持HTML5的浏览器';
    }
});