<?php

class Admin_Apps_IndexController extends \Admin_BaseController {

    /**
     * 上架游戏列表
     * GET /admin/apps/stock
     *
     * @return Response
     */
    public function stock()
    {
        $apps = new Apps();
        $apps = $apps->lists(['stock'], Input::all())
                          ->paginate(20)
                          ->toArray();

        $cats = new Cats;
        $apps = $cats->addCatsInfo($apps);
        $cats = $cats->allCats();

        // TODO 空提示

        return View::make('admin.apps.index.stock')
                   ->with('apps', $apps)
                   ->with('cats', $cats);
    }

    /**
     * 添加编辑游戏列表(草稿)
     * GET /admin/apps/draft
     *
     * @return Response
     */
    public function draft()
    {
        
        $apps = new Apps();
        $apps = $apps->lists(['publish', 'draft'], Input::all())
                     ->paginate(20)
                     ->toArray();

        $cats = new Cats;
        $apps = $cats->addCatsInfo($apps);
        $cats = $cats->allCats();

        return View::make('admin.apps.index.draft')
                   ->with('apps', $apps)
                   ->with('cats', $cats);
    }

    /**
     * 待审核游戏列表
     * GET /admin/apps/pending
     *
     * @return Response
     */
    public function pending()
    {

        $apps = new Apps();
        $apps = $apps->lists(['pending'], Input::all())
                     ->paginate(20)
                     ->toArray();

        $cats = new Cats;
        $apps = $cats->addCatsInfo($apps);
        $cats = $cats->allCats();

        return View::make('admin.apps.index.pending')
                   ->with('apps', $apps)
                   ->with('cats', $cats);
    }

    /**
     * 审核不通过列表
     * GET /admin/apps/notpass
     *
     * @return Response
     */
    public function notpass()
    {
        $apps = new Apps();
        $apps = $apps->lists(['notpass'], Input::all())
                     ->paginate(20)
                     ->toArray();

        $cats = new Cats;
        $apps = $cats->addCatsInfo($apps);
        $cats = $cats->allCats();

        return View::make('admin.apps.index.notpass')
                   ->with('apps', $apps)
                   ->with('cats', $cats);
    }

    /**
     * 下架游戏列表
     * GET /admin/apps/unstock
     *
     * @return Response
     */
    public function unstock()
    {
        $apps = new Apps();
        $apps = $apps->lists(['unstock'], Input::all())
                     ->paginate(20)
                     ->toArray();

        $cats = new Cats;
        $apps = $cats->addCatsInfo($apps);
        $cats = $cats->allCats();

        $user = new User;
        $apps = $user->addOperator($apps);

        return View::make('admin.apps.index.unstock')
                   ->with('apps', $apps)
                   ->with('cats', $cats);
    }

    /**
     * 游戏编辑页面
     * GET /admin/apps/{id}
     *
     * @param  int  $id 游戏ID
     *
     * @return Response
     */
    public function edit($id)
    {

        $apps = new Apps;
        $app = $apps->info($id);

        $cats = new Cats;
        $cats = $cats->allCats();
        $tags  = $cats->allTagsWithCate();

        if(empty($app)) {
            $tips = ['success' => false, 'message' => "亲，ID：{$id}的游戏不存在"];
            Session::flash('tips', $tips);

            return Redirect::back();
        }

        return View::make('admin.apps.index.edit')
                   ->with('app', $app)
                   ->with('cats', $cats)
                   ->with('tags', $tags);
    }

    /**
     * 更新游戏
     * PUT /admin/apps/status/{id}
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function update($id)
    {
        $route = Route::current()->getName();
        $paths = explode('.', $route);

        if(!isset($paths[1]) && !in_array($paths[1], ['stock', 'draft', 'pending'])) {
            App::abort(404);
        }

        $status = $paths[1];

        if(! Apps::find($id)) {
            Session::flash('tips', ['success' => false, 'message' => "亲，ID：{$id}不存在"]);
        }

        $apps = new Apps();
        
        // 验证表单
        $validFail = false;
        $data = Input::all();
        if(isset($apps->rules[$status])) {
            $validator = Validator::make($data, $apps->rules[$status]);
            $validFail = $validator->fails();
        }
        
        if(! $validFail) {
            if( $apps->store($id, $status, $data) ) {
                Session::flash('tips', ['success' => true, 'message' => "修改成功"]);
            } else {
                Session::flash('tips', ['success' => false, 'message' => "修改失败"]);
            }
        } else {
            Session::flash('tips', ['success' => false, 'message' => "请按要求填写表单"]);
            return Redirect::back();
        }

        return Redirect::to(URL::route('apps.'.$status));
    }

    /**
     * 游戏历史
     * GET /admin/apps/{id}/history
     *
     * @param $id int 游戏ID
     *
     * @return Response
     */
    public function history($id)
    {

        $apps = new Histories();
        $apps = $apps->lists($id, Input::all())
                          ->paginate(20)
                          ->toArray();

        $history = new Histories;
        $apps = $history->addCatsInfo($apps);

        $user = new User;
        $apps = $user->addOperator($apps);

        return View::make('admin.apps.index.history')
                   ->with('apps', $apps)
                   ->with('id', $id);
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

        if(Input::get('type') == 'history') {
            $history = new Histories();
            $app = $history->preview($id);

        } else {
            $app = new Apps();
            $app = $app->preview($id);
        }

        $app['updated_at'] = date('Y-m-d', strtotime($app['updated_at']));

        if($app) {
            $info = ['success' => true, 'data' => $app];
        } else {
            $info = ['success' => false];
        }

        return json_encode($info);
    }

    /**
     * 删除游戏
     * DELETE /admin/apps/{id}
     *
     * @param int $id
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
     * 上传游戏APK
     * POST /admin/apps/appupload
     *
     * @param $dontSave string 是否入库（空是入库）
     *
     * @return Response
     */
    public function appUpload($dontSave = '')
    {
        $app = new Apps();

        return $app->appUpload($dontSave);
    }
    
    /**
     * 上传游戏图片
     * POST /admin/apps/imageupload
     *
     * @return Response
     */
    public function imageUpload()
    {
        $app = new Apps();

        return $app->imageUpload();
    }

    /**
     * 审核通过（上架）
     * PUT /admin/apps/putStock
     *
     *
     * @return Response
     */
    public function putStock()
    {
        $ids = Input::get('ids');

        if(empty($ids)) {
            Session::flash('tips', ['success' => false, 'message' => "参数不正确"]);
            return Redirect::back();
        }

        if(! $apps = Apps::whereIn('id', $ids)) {
            Session::flash('tips', ['success' => false, 'message' => "亲，找不到游戏"]);
        } elseif ($apps->update(['status' => 'stock'])) {
            Session::flash('tips', ['success' => true, 'message' => "亲，全部已经审核通过"]);
        } else {
            Session::flash('tips', ['success' => false, 'message' => "亲，操作失败了"]);
        }

        return Redirect::back();
    }

    /**
     * 下架游戏
     * PUT /admin/apps/putUnstock
     *
     * @return Response
     */
    public function putUnstock()
    {
        if(! $app = Apps::find($id)) {
            Session::flash('tips', ['success' => false, 'message' => "亲，ID：{$id}不存在"]);
        } elseif ($app->update(['status' => 'offshelf', 'offshelfed_at' => date('Y-m-d H:i:s')])) {
            Session::flash('tips', ['success' => true, 'message' => "亲，ID：{$id}已经下架"]);
        } else {
            Session::flash('tips', ['success' => false, 'message' => "亲，ID：{$id}下架操作失败了"]);
        }
   
        return Redirect::back();
    }

    /**
     * 审核不通过
     * PUT /admin/apps/putNotpass
     *
     * @return Response
     */
    public function putNotpass()
    {
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