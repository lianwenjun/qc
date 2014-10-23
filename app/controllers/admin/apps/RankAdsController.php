<?php

class Admin_rankAdsController extends \Admin_BaseController {

    protected $type = 'rank';
    /**
     * 显示排行广告列表
     * GET /admin/rankads
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
        $appsModel = new Apps();
        foreach ($ads as &$ad) {
            $app = $appsModel->find($ad->app_id);
            if ($app) $ad->image = $app->icon;
        }

        $datas = ['ads' => $ads,
                'location' => Config::get('status.ads.ranklocation'),
                'is_top' => Config::get('status.ads.is_top')];
        $this->layout->content = View::make('admin.rankads.index', $datas);
    }

    /**
     * 打开排行游戏广告页面
     * GET /admin/rankads/create
     *
     * @return Response
     */
    public function create()
    {
        $datas = ['location' => Config::get('status.ads.ranklocation')];
        $this->layout->content = View::make('admin.rankads.create', $datas);
    }

    /**
     * 添加游戏到排行广告
     * POST /admin/rankads
     *
     * @return Response
     */
    public function store()
    {
        $adsModel = new Ads();
        $validator = Validator::make(Input::all(), $adsModel->rankadsCreateRules);
        $msg = "添加失败";
        if ($validator->fails()){
            Log::error($validator->messages());
            return Redirect::route('rankads.create')->with('msg', $msg)->with('input', Input::all());
        }
        $ad = $adsModel->createAds($this->type);
        if ($ad) {
            $msg = "添加成功";
            return Redirect::route('rankads.index')->with('msg', $msg);
        }
        return Redirect::route('rankads.create')->with('msg', $msg)->with('input', Input::all());
    }


    /**
     * 打开排行游戏编辑页面
     * GET /admin/rankads/{id}/edit
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
            return Redirect::route('rankads.index');
        }
        //检测游戏是否存在
        $appsModel = new Apps;
        $app = $appsModel->find($ad->app_id);
        if (!$app) {
            return Redirect::route('rankads.index')->with('msg', '游戏不存在');
        }
        $datas = ['ad' => $ad, 
            'location' => Config::get('status.ads.ranklocation'),
            'app' => $app];
        $this->layout->content = View::make('admin.rankads.edit', $datas);
    }

    /**
     * 编辑修改排行游戏广告位
     * PUT /admin/rankads/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $adsModel = new Ads();
        $ad = $adsModel->where('id', $id)->where('type', $this->type)->first();
        if (!$ad) {
            return Redirect::back()->with('msg', '亲，数据不存在');
        }
        $validator = Validator::make(Input::all(), $adsModel->rankadsUpateRules);
        if ($validator->fails()){
            return Redirect::back()->with('msg', '修改失败');
        }
        $ad = $adsModel->UpdateAds($ad);
        if ($ad->save()){
            return Redirect::route('rankads.index')->with('msg', '修改成功');
        } else {
            return Redirect::back()->with('msg', '没什么改变');
        }
    }

    /**
     * 下架排行游戏位广告
     * DELETE /admin/appads/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function offshelf($id)
    {
        $adsModel = new Ads();
        $ad = $adsModel->offshelf($id, $this->type);
        if ($ad) {
            return  Redirect::back()->with('msg', '亲，#' . $id . '下架成功了');
        } else {
            return Redirect::route('rankads.index')->with('msg', '亲，#' . $id . '下架失败了');
        }    
    }
    
    /**
     * 删除排行游戏广告
     * DELETE /admin/rankads/{id}
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
            return  Redirect::back()->with('msg', '#' . $id . '不存在');
        }
        $msg = '#' . $id . '删除失败';
        if ($ad->delete()){
            $msg = '#' . $id . '删除成功';
        }
        return Redirect::back()->with('msg', $msg);
    }

}