<?php

class Admin_Apps_AppsAdsController extends \Admin_BaseController {

    protected $type = 'app';
    /**
     * 首页游戏位广告列表
     * 
     * @method GET
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
        $this->layout->content = View::make('admin.appsads.index', $datas);
    }

    /**
     * 首页游戏位广告添加页面
     * GET /admin/appads/create
     *
     * @return Response
     */
    public function create()
    {
        $datas = ['location' => Config::get('status.ads.applocation')];
        $this->layout->content = View::make('admin.appsads.create', $datas);
    }

    /**
     * 增加首页游戏位广告
     * POST /admin/appads
     * @param int app_id
     * @param string title
     * @param string location
     * @param string image
     * @param string is_top
     * @param string onshelfed_at
     * @param string offshelfed_at
     * @return Response
     */
    public function store()
    {
        $adsModel = new Ads();
        $validator = Validator::make(Input::all(), $adsModel->adsCreateRules);
        if ($validator->fails()){
            //Log::error($validator->messages());
            $msg = "添加失败";
            return Redirect::route('appsads.create')->with('msg', $msg)->with('input', Input::all());
        }
        $ad = $adsModel->createAds($this->type);
        if ($ad) {
            $msg = "添加成功";
            return Redirect::route('appsads.index')->with('msg', $msg);
        }
        $msg = '添加失败';
        return Redirect::route('appsads.create')->with('msg', $msg)->with('input', Input::all());
    }

    /**
     * 首页游戏广告位编辑页面
     * GET /admin/appads/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $ad = Ads::where('id', $id)->where('type', $this->type)->first();
        //检测广告是否存在
        if (!$ad) {
            return Redirect::route('appsads.index');
        }
        //检测游戏是否存在
        $app = Apps::find($ad->app_id);
        if (!$app) {
            return Redirect::route('appsads.index');
        }
        $datas = ['ad' => $ad, 
            'location' => Config::get('status.ads.applocation'),
            'app' => $app];
        $this->layout->content = View::make('admin.appsads.edit', $datas);
    }

    /**
     * 修改首页游戏位广告
     * POST /admin/appads/1
     * @param string location
     * @param string image
     * @param string is_top
     * @param string onshelfed_at
     * @param string offshelfed_at
     * @return Response
     */
    public function update($id)
    {
        $ad = Ads::where('id', $id)->where('type', $this->type)->first();
        if (!$ad) {
            return Redirect::route('appsads.index')->with('msg', '亲，数据不存在');
        }
        $validator = Validator::make(Input::all(), Ads::adsUpdateRules);
        if ($validator->fails()){
            Log::error($validator->messages());
            $msg = "添加失败";
            return Redirect::route('appsads.edit', $id)->with('msg', $msg);
        }
        $ad->location = Input::get('location', $ad->location);
        $ad->image = Input::get('image', $ad->image);
        $ad->is_top = Input::get('is_top', 'no');
        $ad->onshelfed_at = Input::get('onshelfed_at', $ad->onshelfed_at);
        $ad->offshelfed_at = Input::get('offshelfed_at', $ad->offshelfed_at);
        $ad->is_onshelf = 'yes';
        if ($ad->save()) {
            return Redirect::route('appsads.index')->with('msg', '修改成功');
        }
        return Redirect::route('appsads.index')->with('msg', '没什么改变');
    }

    /**
     * 下架首页游戏位广告
     * DELETE /admin/appads/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function unstock($id)
    {
        $adsModel = new Ads();
        $ad = $adsModel->offshelf($id, $this->type);
        if (!$ad) {
            $msg = '亲，#'.$id.'下架失败了';
            return Redirect::route('appsads.index')->with('msg', $msg);
        }
        $msg = '亲，#'.$id.'下架成功';
        return Redirect::route('appsads.index')->with('msg', $msg);
    }

    /**
     * 删除首页游戏位广告
     * DELETE /admin/appads/{id}
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
            return App::abort(404);
        }
        $msg = '#' . $id . '删除失败';
        if ($ad->delete()){
            $msg = '#' . $id . '删除成功';
        }
        return Redirect::route('appsads.index')->with('msg', $msg);
    }

    /**
    * 上传图片
    */
    public function upload(){
        $adsModel = new Ads();
        return $adsModel->imageUpload();
    }

}