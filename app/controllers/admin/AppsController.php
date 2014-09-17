<?php

class Admin_AppsController extends \Admin_BaseController {

    /**
     * 上架游戏列表
     * GET /admin/apps/onshelf
     *
     * @return Response
     */
    public function onshelf()
    {
        return View::make('admin.apps.onshelf');
    }

    /**
     * 添加编辑游戏列表
     * GET /admin/apps/draft
     *
     * @return Response
     */
    public function draft()
    {
        return View::make('admin.apps.draft');
    }

    /**
     * 待审核游戏列表
     * GET /admin/apps/pending
     *
     * @return Response
     */
    public function pending()
    {
        return View::make('admin.apps.pending');
    }

    /**
     * 审核不通过列表
     * GET /admin/apps/nopass
     *
     * @return Response
     */
    public function nopass()
    {
        return View::make('admin.apps.nopass');
    }

    /**
     * 下架游戏列表
     * GET /admin/apps/offshelf
     *
     * @return Response
     */
    public function offshelf()
    {
        return View::make('admin.apps.offshelf');
    }

    /**
     * Show the form for creating a new resource.
     * GET /admin/apps/create
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * POST /admin/apps
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * GET /admin/apps/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * PUT /admin/apps/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /admin/apps/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}