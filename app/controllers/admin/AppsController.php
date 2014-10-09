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
        $apps = $appsModel->lists(['new', 'draft'], Input::all())
                          ->paginate(20)
                          ->toArray();

        $catesModel = new Cates;
        $apps  = $catesModel->addCatesInfo($apps);
        $cates = $catesModel->allCates();

        return View::make('admin.apps.draft')
                   ->with('apps', $apps)
                   ->with('cates', $cates);
    }

    /**
     * 待审核游戏列表
     * GET /admin/apps/pending
     *
     * @return Response
     */
    public function pending()
    {

        $appsModel = new Apps();
        $apps = $appsModel->lists(['pending'], Input::all())
                          ->paginate(20)
                          ->toArray();

        $catesModel = new Cates;
        $apps  = $catesModel->addCatesInfo($apps);
        $cates = $catesModel->allCates();

        return View::make('admin.apps.pending')
                   ->with('apps', $apps)
                   ->with('cates', $cates);
    }

    /**
     * 审核不通过列表
     * GET /admin/apps/nopass
     *
     * @return Response
     */
    public function nopass()
    {
        $appsModel = new Apps();
        $apps = $appsModel->lists(['nopass'], Input::all())
                          ->paginate(20)
                          ->toArray();

        $catesModel = new Cates;
        $apps  = $catesModel->addCatesInfo($apps);
        $cates = $catesModel->allCates();

        return View::make('admin.apps.nopass')
                   ->with('apps', $apps)
                   ->with('cates', $cates);
    }

    /**
     * 下架游戏列表
     * GET /admin/apps/offshelf
     *
     * @return Response
     */
    public function offshelf()
    {
        $appsModel = new Apps();
        $apps = $appsModel->lists(['offshelf'], Input::all())
                          ->paginate(20)
                          ->toArray();

        $catesModel = new Cates;
        $apps  = $catesModel->addCatesInfo($apps);
        $cates = $catesModel->allCates();

        return View::make('admin.apps.offshelf')
                   ->with('apps', $apps)
                   ->with('cates', $cates);
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
     * 预览游戏数据
     * GET /admin/apps/{id}/preview
     *
     * @param $id int APPID
     *
     * @return Response
     */
    public function preview($id)
    {
        $appModel = new Apps();
        $app = $appModel->preview($id);

        if($app) {
            $info = ['success' => true, 'data' => $app];
        } else {
            $info = ['success' => false];
        }

        return json_encode($info);
    }


    /**
     * 上传游戏图片
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
     * 游戏编辑页面
     * GET /admin/apps/{id}/edit
     *
     * @param  int  $id 游戏ID
     *
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
     * 更新游戏
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
     * 删除游戏
     * DELETE /admin/apps/{id}
     *
     * @param  int  $id
     *
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

    /**
     * 审核通过
     * PUT /admin/apps/{id}/dopass
     *
     * @param $id int 游戏ID
     *
     * @return Response
     */
    public function dopass($id)
    {
        if(! $app = Apps::find($id)) {
            Session::flash('tips', ['success' => false, 'message' => "亲，ID：{$id}不存在"]);
        } elseif ($app->update(['status' => 'onshelf'])) {
            Session::flash('tips', ['success' => true, 'message' => "亲，ID：{$id}已经审核通过"]);
        } else {
            Session::flash('tips', ['success' => false, 'message' => "亲，ID：{$id}审核操作失败了"]);
        }
   
        return Redirect::back();
    }

    /**
     * 批量审核通过
     * PUT /admin/apps/doallpass
     *
     * @return Response
     */
    public function doallpass() {
        $ids = Input::get('ids');

        if(empty($ids)) {
            Session::flash('tips', ['success' => false, 'message' => "参数不正确"]);
            return Redirect::back();
        }

        if(! $apps = Apps::whereIn('id', $ids)) {
            Session::flash('tips', ['success' => false, 'message' => "亲，找不到游戏"]);
        } elseif ($apps->update(['status' => 'onshelf'])) {
            Session::flash('tips', ['success' => true, 'message' => "亲，全部已经审核通过"]);
        } else {
            Session::flash('tips', ['success' => false, 'message' => "亲，操作失败了"]);
        }

        return Redirect::back();
    }

    /**
     * 审核不通过
     * PUT /admin/apps/{id}/donopass
     *
     * @param $id int 游戏ID
     *
     * @return Response
     */
    public function donopass($id)
    {
        if(! $app = Apps::find($id)) {
            Session::flash('tips', ['success' => false, 'message' => "亲，ID：{$id}不存在"]);
            return Redirect::back();
        }
        
        if($app->update(['status' => 'nopass', 'reason' => Input::get('reason')])) {
            Session::flash('tips', ['success' => true, 'message' => "亲，ID：{$id}已经审核不通过"]);
        } else {
            Session::flash('tips', ['success' => false, 'message' => "亲，ID：{$id}审核操作失败了"]);
        }

        return Redirect::back();
    }

    /**
     * 批量审核不通过
     * PUT /admin/apps/doallnopass
     *
     * @return Response
     */
    public function doallnopass() {
        $ids = Input::get('ids');
        $reason = Input::get('reason');

        if(empty($ids) || empty($reason)) {
            Session::flash('tips', ['success' => false, 'message' => "参数不正确"]);
            return Redirect::back();
        }

        if(! $apps = Apps::whereIn('id', $ids)) {
            Session::flash('tips', ['success' => false, 'message' => "亲，找不到游戏"]);
        } elseif ($apps->update(['status' => 'nopass', 'reason' => $reason])) {
            Session::flash('tips', ['success' => true, 'message' => "亲，全部已经审核不通过"]);
        } else {
            Session::flash('tips', ['success' => false, 'message' => "亲，操作失败了"]);
        }

        return Redirect::back();
    }
}