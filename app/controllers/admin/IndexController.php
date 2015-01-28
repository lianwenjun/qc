<?php

class Admin_IndexController extends \Admin_BaseController {
    /**
     * 后台首页
     * GET /admin
     *
     * @return Response
     */
    public function index()
    {
        return View::make('admin.index');
        //return $this->layout->content = View::make('evolve.welcome');
    }

    /**
     * 后台菜单
     * GET /admin/menu
     *
     * @return Response
     */
    public function menu()
    {
        return View::make('admin.menu');
    }

    /**
     * 后台欢迎页
     * GET /admin/welcome
     *
     * @return Response
     */
    public function welcome()
    {
        $model = new UserGroups();
        $role = $model->getCurrentUserGroupName();
        
        return View::make('admin.welcome')->with('role', $role);
    }

    /**
     * 没有权限页
     * GET /admin/accessDenied
     */
    public function accessDenied()
    {
        return '没有权限';
    }

    /**
    * 后台搜索关键字
    * GET 
    * @return Response
    */
    public function searchApps() {
        if (Input::get('type') == 'appid') {
            $query =  Input::get('query', 0);
            $apps = Apps::select('id', 'title')->where('status', 'stock')->where('id', $query)
                ->orderBy('id', 'desc')->get();
        } else {
            $query = '%' . Input::get('query') . '%';
            $apps = Apps::select('id', 'title')->where('status', 'stock')->where('title', 'like', $query)
                ->orderBy('id', 'desc')->get();
        }
        $data = [];
        foreach ($apps as $app) {
            $data[] = ['data' => URL::route('appsinfo', $app->id), 
                        'value' => $app->title];
        }
        return Response::json(["query" => "Unit", "suggestions" => $data]);
    }

    /**
    * 后台APP单个
    * GET
    * @return Response
    */
    public function appsinfo($id) {
        $app = Apps::select('id', 'title', 'icon', 'pack', 'size', 'version', 'created_at')
                    ->whereStatus('stock')->find($id);
        if (!empty($app)) {
            return Response::json(['data' => $app, 'status'=>'ok']);
        }
        return Response::json(['status' => 'error']);
    }
    /**
    * 后台搜索最近添加
    * GET 
    * @return Response
    */
    public function lastApp() {

    }

}