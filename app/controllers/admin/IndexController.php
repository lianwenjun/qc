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
        return View::make('admin.welcome');
    }

    /**
    * 后台搜索关键字
    * GET 
    * @return Response
    */
    public function searchApps() {
        $appsModel = new Apps();
        $query = '%' . Input::get('word') . '%';
        $apps = $appsModel->select('id', 'title')->where('status', 'onshelf')->where('title', 'like', $query)
                    ->orderBy('id', 'desc')->get()->toarray();
        return ['data' => $apps];
    }

    /**
    * 后台搜索最近添加
    * GET 
    * @return Response
    */
    public function lastApp() {
        
    }

}