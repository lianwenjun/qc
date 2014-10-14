<?php

class Admin_RolesController extends \Admin_BaseController {

    /**
     * 角色
     * GET /admin/roles/index
     *
     * @return Response
     */
    public function index()
    {
        $groupModel = new Groups();
        $groups = $groupModel->lists(Input::all())
                          ->paginate(20)
                          ->toArray();

        $departments = Config::get('department');

        return View::make('admin.roles.index')
                   ->with('groups', $groups)
                   ->with('departments', $departments);
    }

    /**
     * 角色添加
     * GET /admin/roles/create
     *
     * @return Response
     */
    public function create()
    {

        $departments = Config::get('department');
        $permissions = Config::get('permissions');

        return View::make('admin.roles.create')
                   ->with('departments', $departments)
                   ->with('permissions', $permissions);
    }

    /**
     * 角色添加保存
     * POST /admin/roles/create
     *
     * @return Response
     */
    public function store()
    {
        $groupModel = new Groups;
        if($groupModel->store(Input::all())) {
            Session::flash('tips', ['success' => true, 'message' => "亲，角色添加成功了"]);

            return Redirect::route('roles.index');
        } else {
            Session::flash('tips', ['success' => false, 'message' => "亲，角色添加失败了"]);

            return Redirect::back();
        }
    }

    /**
     * 角色编辑
     * GET /admin/roles/{id}/edit
     *
     * @param $id int 角色ID
     *
     * @return Response
     */
    public function edit($id)
    {

        $group = Groups::find($id);

        $departments = Config::get('department');
        $permissions = Config::get('permissions');

        return View::make('admin.roles.edit')
                   ->with('departments', $departments)
                   ->with('permissions', $permissions)
                   ->with('group', $group);
    }

    /**
     * 角色信息更新
     * PUT /admin/roles/(id)/edit
     *
     * @param $id int 角色ID
     *
     * @return Response
     */
    public function update($id)
    {

        $permissions = [];
        foreach(Input::get('permissions', []) as $permission) {
            $permissions[$permission] = 1;
        }

        $data = [
            'name' => Input::get('name'),
            'department' => Input::get('department'),
            'permissions' => json_encode($permissions)
        ];

        // TODO 验证

        if(! $group = Groups::find($id)) {
            Session::flash('tips', ['success' => false, 'message' => "亲，ID：{$id}不存在"]);
        } elseif ($group->update($data)) {
            Session::flash('tips', ['success' => true, 'message' => "亲，ID：{$id}修改成功"]);
        } else {
            Session::flash('tips', ['success' => false, 'message' => "亲，ID：{$id}操作失败了"]);
            return Redirect::back();
        }

        return Redirect::route('roles.index');

    }

    /**
     * 角色删除
     * DELETE /admin/roles/{id}/delete
     *
     * @param $id int 角色ID
     *
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $group = Sentry::findGroupById($id);
            $group->delete();

            Session::flash('tips', ['success' => true, 'message' => "亲，ID：{$id}已经删除掉了"]);
        } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
            Session::flash('tips', ['success' => false, 'message' => "亲，ID：{$id}不存在"]);
        }

        return Redirect::back();
    }
}