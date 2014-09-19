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

}