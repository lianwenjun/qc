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

        $groupModel = new Groups;
        $users = $groupModel->addGroupName($users);

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
     * 管理员编辑
     * GET /admin/users/{id}/edit
     *
     * @param $id int 管理员ID
     * 
     * @return Response
     */
    public function edit($id)
    {

        $user = User::find($id);
        if(empty($user)) {
            $tips = ['success' => false, 'message' => "亲，ID：{$id}的管理员不存在"];
            Session::flash('tips', $tips);

            return Redirect::back();
        }

        $roles = Groups::all();

        $userGroupsModel = new UserGroups;
        $groupIds = $userGroupsModel->userGroupIds($id);

        return View::make('admin.users.edit')
                   ->with('roles', $roles)
                   ->with('user', $user)
                   ->with('groupIds', $groupIds);
    }

    /**
     * 管理员编辑保存
     * PUT /admin/users/{id}/edit
     *
     * @param $id int 管理员ID
     *
     * @return Response
     */
    public function update($id)
    {

        try{
            $user = Sentry::findUserById($id);

            $user->email = Input::get('email');
            $user->username = Input::get('username');
            $user->realname = Input::get('realname');

            // 密码
            if(!empty(Input::get('password'))) {
                $userModel = new User;
                $userModel->changePwd($id, Input::get('password'));
            }

            // 用户组
            $groups = $user->getGroups();
            foreach($groups as $group) {
                $user->removeGroup($group);
            }
            $newGroup = Sentry::findGroupById(Input::get('group_id'));
            $user->addGroup($newGroup);

            if ($user->save()) {
                $tips = ['success' => true, 'message' => "亲，" . Input::get('username') . "管理员修改成功"];
                Session::flash('tips', $tips);

                return Redirect::route('users.index');
            } else {
                $tips = ['success' => false, 'message' => "亲，" . Input::get('username') . "修改失败"];
                Session::flash('tips', $tips);

                return Redirect::back();
            }
        } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
            $tips = ['success' => false, 'message' => "亲，" . Input::get('username') . "的管理员已存在"];
            Session::flash('tips', $tips);

            return Redirect::back();
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $tips = ['success' => false, 'message' => "亲，" . Input::get('username') . "的管理员不存在"];
            Session::flash('tips', $tips);

            return Redirect::back();
        }

    }

    /**
     * 删除管理员
     * DELETE /admin/users/{id}/delete
     *
     * @param $id int 管理员ID 
     *
     * @return Response
     */
    public function destroy($id)
    {
        try {

            $user = Sentry::findUserById($id);
            $user->delete();

            $tips = ['success' => true, 'message' => "亲，ID:{$id}的管理员已删除"];
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $tips = ['success' => false, 'message' => "亲，ID:{$id}的管理员不存在"];
        }
        Session::flash('tips', $tips);

        return Redirect::back();
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

        try {
            $credentials = [
                'username' => Input::get('username'),
                'password' => Input::get('password'),
            ];
            $user = Sentry::authenticate($credentials, false);

            return Redirect::route('admin.index');
        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            Session::flash('tips', ['success' => false, 'message' => "用户名必填"]);
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            Session::flash('tips', ['success' => false, 'message' => "密码必填"]);
        } catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
            Session::flash('tips', ['success' => false, 'message' => "用户名密码不正确"]);
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            Session::flash('tips', ['success' => false, 'message' => "用户不存在"]);
        } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            Session::flash('tips', ['success' => false, 'message' => "用户未激活"]);
        } catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
            Session::flash('tips', ['success' => false, 'message' => "用户已挂起"]);
        } catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
            Session::flash('tips', ['success' => false, 'message' => "用户已冻结"]);
        }

        return Redirect::route('users.signin');
    }

    /**
     * 修改密码
     * GET /admin/users/changePwd
     * 
     * @return Response
     */
    public function changePwd()
    {
        return View::make('admin.users.changePwd');
    }

    /**
     * 修改密码
     * PUT /admin/users/changePwd
     * 
     * @return Response
     */
    public function doChangePwd()
    {

        $id = Sentry::getUser()->id;
        $userModel = new User;
        $userModel->changePwd($id, Input::get('password'));

        $tips = ['success' => true, 'message' => "亲，密码修改成功"];
        Session::flash('tips', $tips);

        return Redirect::back();
    }

    /**
     * 管理员登出
     * GET /admin/users/signout
     * 
     * @return Response
     */
    public function signout()
    {
        Sentry::logout();

        return Redirect::route('users.signin');
    }
}