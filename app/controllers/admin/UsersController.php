<?php

class Admin_UsersController extends \Admin_BaseController {

    /**
     * 管理员
     * GET /admin/users/index
     *
     * @return Response
     */
    public function index()
    {
        $userModel = new User();
        $users = $userModel->lists(Input::all())
                          ->paginate(20)
                          ->toArray();

        $roles = Groups::all();

        return View::make('admin.users.index')
                   ->with('roles', $roles)
                   ->with('users', $users);
    }

    /**
     * 管理员添加
     * GET /admin/users/create
     *
     * @return Response
     */
    public function create()
    {
        $roles = Groups::all();

        return View::make('admin.users.create')
                   ->with('roles', $roles);
    }

    /**
     * 管理员添加保存
     * POST /admin/users/create
     *
     * @return Response
     */
    public function store()
    {
        $userModel = new User;
        $userModel->store(Input::all());

        return Redirect::route('users.index');
    }

    /**
     * 管理员登陆页面
     * GET /admin/users/signin
     * 
     * @return Response
     */
    public function signin()
    {
        return View::make('admin.users.signin');
    }

    /**
     * 管理员登陆
     * PUT /admin/users/doSignin
     * 
     * @return Response
     */
    public function doSignin()
    {

        try{

            $credentials = array(
                'username' => Input::get('username'),
                'password' => Input::get('password'),
            );

            $user = Sentry::authenticate($credentials, false);
        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            echo 'Login field is required.';
            exit;
        }
        catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            echo 'Password field is required.';
            exit;
        }
        catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
        {
            echo 'Wrong password, try again.';
            exit;
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            echo 'User was not found.';
            exit;
        }
        catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
        {
            echo 'User is not activated.';
            exit;
        }

        // The following is only required if the throttling is enabled
        catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
        {
            echo 'User is suspended.';
            exit;
        }
        catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
        {
            echo 'User is banned.';
            exit;
        }

        return Redirect::route('admin.index');
    }
}