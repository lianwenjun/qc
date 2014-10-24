<?php

class Admin_EditorAdsController extends \Admin_BaseController {
    
    protected $type = 'editor';
    /**
     * 编辑精选广告列表
     * GET /admin/editorads
     *
     * @return Response
     */
    public function index()
    {
        $adsModel = new Ads();
        $query = $adsModel;
        //条件查询
        $query = $adsModel->indexQuery($query);
        if (Input::get('location')){
            $query = $query->where('location', Input::get('location'));
        }
        $query = $query->where('type', $this->type);
        $ads = $query->orderBy('id', 'desc')->paginate($this->pagesize);

        $datas = ['ads' => $ads, 'status' => Config::get('status.ads.status'), 
                'location' => Config::get('status.ads.applocation'),
                'is_top' => Config::get('status.ads.is_top')];
        $this->layout->content = View::make('admin.editorads.index', $datas);
    }

    /**
     * 编辑精选添加页面
     * GET /admin/editorads/create
     *
     * @return Response
     */
    public function create()
    {
        $datas = ['location' => Config::get('status.ads.applocation')];
        $this->layout->content = View::make('admin.editorads.create', $datas);
    }

    /**
     * 添加编辑精选广告
     * POST /admin/editorads
     *
     * @return Response
     */
    public function store()
    {
        $adsModel = new Ads();
        $msg = "添加失败";
        $validator = Validator::make(Input::all(), $adsModel->adsCreateRules);
        if ($validator->fails()){
            Log::error($validator->messages());
            return Redirect::route('editorads.create')->with('msg', $msg)->with('input', Input::all());
        }
        //检测游戏是否存在
        $appsModel = new Apps;
        $app = $appsModel->find(Input::get('app_id'));
        if (!$app) {
            $msg = '游戏不存在';
            return Redirect::route('editorads.create')->with('msg', $msg)->with('input', Input::all());
        }
        $ad = $adsModel->createAds($this->type);
        if ($ad) {
            $msg = "添加成功";
            return Redirect::route('editorads.index')->with('msg', $msg);
        }
        return Redirect::route('editorads.create')->with('msg', $msg)->with('input', Input::all());
    }

    /**
     * 编辑精选修改
     * GET /admin/editorads/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $adsModel = new Ads();
        $ad = $adsModel->where('id', $id)->where('type', $this->type)->first();
        //检测广告是否存在
        if (!$ad) {
            return Redirect::route('editorads.index')->with('msg', '没发现数据');
        }
        //检测游戏是否存在
        $appsModel = new Apps;
        $app = $appsModel->find($ad->app_id);
        if (!$app) {
            return Redirect::route('editorads.index')->with('msg', '没发现游戏数据');
        }
        $datas = ['ad' => $ad, 
            'location' => Config::get('status.ads.applocation'),
            'app' => $app];
        $this->layout->content = View::make('admin.editorads.edit', $datas);
    }

    /**
     * 编辑精选更新
     * PUT /admin/editorads/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $ad = Ads::where('id', $id)->where('type', $this->type)->first();
        //检测广告是否存在
        if (!$ad) {
            return Redirect::route('editorads.index')->with('msg', '#' . $id .'不存在');
        }
        $adsClass = new Admin_CadsClass;
        $validator = Validator::make(Input::all(), $adsClass->adsUpdateRules);
        if ($validator->fails()){
            Log::error($validator->messages());
            return Redirect::back()->with('msg', '修改失败,格式不对');
        }
        
        $ad = $adsClass->UpdateAds($ad);
        if ($ad->save()) {
            return Redirect::route('editorads.index')->with('msg', '修改成功');
        } else {
            return Redirect::back()->with('msg', '修改失败');
        }
        
    }

    /**
     * 下架编辑精选广告
     * DELETE /admin/appads/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function unstock($id)
    {
        $adsClass = new Admin_CadsClass;
        $ad = $adsClass->unstock($id, $this->type);
        if (!$ad) {
            $msg = '亲，#'.$id.'下架失败了';
            return Request::header('referrer') ? Redirect::back()
                ->with('msg', $msg) : Redirect::route('editorads.index')->with('msg', $msg);
        }
        $msg = '亲，#'.$id.'下架成功';
        return Request::header('referrer') ? Redirect::back()
                ->with('msg', $msg) : Redirect::route('editorads.index')->with('msg', $msg);
    }
    
    /**
     * 删除编辑精选广告
     * DELETE /admin/editorads/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $adsModel = new Ads();
        //单条查询
        $ad = $adsModel->where('id', $id)->where('type', $this->type)->first();
        //检查
        if (!$ad) {
            $msg = '#' . $id . '不存在';
            return Request::header('referrer') ? Redirect::back()
                ->with('msg', $msg) : Redirect::route('editorads.index')->with('msg', $msg);
        }
        $msg = '#' . $id . '删除失败';
        if ($ad->delete()){
            $msg = '#' . $id . '删除成功';
        }
        return Request::header('referrer') ? Redirect::back()
            ->with('msg', $msg) : Redirect::route('editorads.index')->with('msg', $msg);
    }
     /**
    * 上传图片
    */
    public function upload(){
        $cupload = new Admin_Cupload;
        return $upload->adsImageUpload();
    }
}