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
        return "<script>window.parent.location.href='".URL::route('users.signin')."';</script>";
    }
});

Route::filter('hasPermissions', function()
{
    if(
        !Sentry::getUser()->hasAccess(Route::current()->getName())
        &&  Route::current()->getName() != 'accessDenied'
      ) {
        return Redirect::route('accessDenied');
    }
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

/*
|--------------------------------------------------------------------------
| activityLog Filter
|--------------------------------------------------------------------------
| 根据条件判断是否触发事件
|
*/

// Route::filiter('activityLog', function()
// {
//     $method = Request::method();
//     $routeName = Route::getCurrentRoute();
//     $activity = $method . '_' . $routeName;
//     if ($activity == 'put_apps.pending.edit') {
//         $status = DB::table('apps')
//                     ->find(Route::input('id'))
//                     ->status;

//         $activity = $status . '_' . $activity;
//     }
//     $activityLogs = Config::get('activityLogs');

//     if (Route::input('id')) {
//         $contentId = Route::input('id');
//     } elseif (Route::input('ids')) {
//         $contentId = Route::input('ids');
//     } elseif (Session::has('log.contentId')) {
//         $contentId = Session::get('log.contentId');
//     }

//     if (isset($contentId) && in_array($activity, $activityLogs)) {
//         Event::fire('actionLog', [$activity, $contentId]);
//     }
// });