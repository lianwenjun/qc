<?php

class Admin_Apps_AppsAdsController extends \Admin_AdsController {

    protected $type = 'app';
    protected $indexRoute = 'appsads.index';
    /**
     * 首页游戏位广告列表
     * 
     * @method GET
     * @return Response
     */
    public function index()
    {
        //条件查询
        $ads = Ads::ofTitle(Input::get('word'))
                ->ofStatus(Input::get('status'))
                ->ofLocation(Input::get('location'))
                ->whereType($this->type)
                ->orderBy('id', 'desc')
                ->paginate($this->pagesize);
        //下面的需要改下
        $appsModel = new Apps();
        foreach ($ads as &$ad) {
            $app = $appsModel->find($ad->app_id);
            if ($app) $ad->image = $app->icon;
        }
        $datas = ['ads' => $ads, 
            'status' => Config::get('status.ads.status'), 
            'location' => Config::get('status.ads.applocation'),
            'is_top' => Config::get('status.ads.is_top')
        ];
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
     * @param string stocked_at
     * @param string unstocked_at
     * @return Response
     */
    public function store()
    {
        $ads = new Ads;
        if (!$ads->isValid(Input::all())){
            return Redirect::route('appsads.create')->with('msg', '添加失败')
                        ->with('input', Input::all());
        }

        $ad = $ads->ofCreate($this->type);
        if ($ad->save()) {
            return Redirect::route('appsads.index')->with('msg', '添加成功');
        } else {
            return Redirect::route('appsads.create')->with('msg', '添加失败')
                        ->with('input', Input::all());
        }
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
        $ad = Ads::whereType($this->type)->find($id);
        //检测广告是否存在
        if (!$ad) {
            return Redirect::route('appsads.index')->with('msg', '游戏不存在');
        }
        //检测游戏是否存在
        $app = Apps::find($ad->app_id);
        if (!$app) {
            return Redirect::route('appsads.index')->with('msg', '游戏不存在');
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
        $ad = Ads::whereType($this->type)->find($id);
        if (!$ad) {
            return Redirect::route('appsads.index')->with('msg', '亲，数据不存在');
        }
        $valid = (new Ads)->isValid(Input::all(), 'update');
        if (!$valid){
            Log::error('广告分类更新');
            return Redirect::route('appsads.edit', $id)->with('msg', '添加失败');
        }
        $ad = (new Ads)->ofUpdate($ad);
        if ($ad->save()) {
            return Redirect::route('appsads.index')->with('msg', '修改成功');
        }
        return Redirect::route('appsads.index')->with('msg', '没什么改变');
    }

}