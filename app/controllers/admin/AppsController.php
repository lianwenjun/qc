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
        $appsModel = new Apps();

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
        
        $appsModel = new Apps();
        $apps = $appsModel -> lists(['new', 'draft']);

        return View::make('admin.apps.draft')->with('apps', $apps);
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
     * 上传游戏APK
     * POST /admin/apps/appupload
     *
     * @param $dontSave string 是否入库（空是入库）
     *
     * @return Response
     */
    public function appUpload($dontSave = '')
    {
        $appModel = new Apps();

        return $appModel->appUpload($dontSave);
    }


    /**
     * 上传游戏APK
     * POST /admin/apps/imageupload
     *
     * @return Response
     */
    public function imageUpload()
    {
        $appModel = new Apps();

        return $appModel->imageUpload();
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

        $appsModel = new Apps;
        $app = $appsModel->info($id);

        $catesModel = new Cates;
        $cates = $catesModel->allCates();
        $tags  = $catesModel->allTagsWithCate();

        if(empty($app)) {
            $tips = ['success' => false, 'message' => "亲，ID：{$id}的游戏不存在"];
            Session::flash('tips', $tips);

            return Redirect::back();
        }

        return View::make('admin.apps.edit')
                   ->with('app', $app)
                   ->with('cates', $cates)
                   ->with('tags', $tags);
    }

    /**
     * Update the specified resource in storage.
     * PUT /admin/apps/{id}
     *
     * @param  int  $id
     * @param  string $status
     *
     * @return Response
     */
    public function update($id, $status)
    {

        if(! Apps::find($id)) {
            Session::flash('tips', ['success' => false, 'message' => "亲，ID：{$id}不存在"]);
        }

        $appsModel = new Apps();
        
        // 验证表单
        $validFail = false;
        $data = Input::all();
        if(isset($appsModel->rules[$status])) {
            $validator = Validator::make($data, $appsModel->rules[$status]);
            $validFail = $validator->fails();
        }
        
        if(! $validFail) {
            if( $appsModel->store($id, $status, $data) ) {
                Session::flash('tips', ['success' => true, 'message' => "修改成功"]);
            } else {
                Session::flash('tips', ['success' => false, 'message' => "修改失败"]);
            }
        } else {
            Session::flash('tips', ['success' => false, 'message' => "请按要求填写表单"]);
            return Redirect::back();
        }

        return Redirect::to('admin/apps/' . $status);
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
        if(! $app = Apps::find($id)) {
            Session::flash('tips', ['success' => false, 'message' => "亲，ID：{$id}不存在"]);
            return Redirect::back();
        }
        
        if($app->delete()) {
            Session::flash('tips', ['success' => true, 'message' => "亲，ID：{$id}已经删除掉了"]);
        } else {
            Session::flash('tips', ['success' => false, 'message' => "亲，ID：{$id}删除失败了"]);
        }

        return Redirect::back();
    }
}