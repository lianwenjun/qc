<?php

class Admin_AppsAdsController extends \BaseController {

    protected $user_id = 1;
    protected $layout = 'admin.layout';
    protected $pagesize = 5;
    /**
     * 首页游戏位广告列表
     * 
     * @method GET
     * @return Response
     */
    public function index()
    {
        $adsModel = new Ads;
        $where = $adsModel->where('type', 'app');
        $ads = $where->orderBy('id', 'desc')->paginate($this->pagesize);
        
        $status = [
                    'inline' => '线上展示',
                    'onshelf' => '上架',
                    'expired' => '已过期',
                    'offshelf' => '已下架'];
        $datas = ['ads' => $ads, 'status' => $status, 'location' => Config::get('status.ads.applocation')];
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
     * @param string location
     * @param string image
     * @param string is_top
     * @param string onshelfed_at
     * @param string offshelfed_at
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     * GET /admin/appads/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
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
        $adsModel = new Ads;
        $ad = $adsModel->where('id', $id)->where('type', 'app')->first();
        //检测广告是否存在
        if (!$ad) {
            return Redirect::route('appsads.index');
        }
        //检测游戏是否存在
        $appsModel = new Apps;
        $app = $appsModel->find($ad->app_id);
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
        //
    }

    /**
     * 下架首页游戏位广告
     * DELETE /admin/appads/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function offshelf($id)
    {
        $adsModel = new Ads;
        $ad = $adsModel->find($id);
        if (!$ad) {
            $msg = '亲，你要下架的数据不存在';
            return Redirect::back();
        }
        $msg = '亲，下架失败了';
        $ad->is_onshelf = 'no';
        if (!$ad->save()){
            $msg = '亲，下架成功了';
        }
        return Redirect::back();
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
        $adsModel = new Ads;
        $ad = $adsModel->where('id', $id)->where('type', 'app');
        if (!$ad) {
            $msg = '亲，你要删除的数据不存在';
            return Redirect::back();
        }
        $msg = '亲，删除失败了';
        if (!$ad->delete()){
            $msg = '亲，删除成功了';
        }
        return Redirect::back();
    }

}