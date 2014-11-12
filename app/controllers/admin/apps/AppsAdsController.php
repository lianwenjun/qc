<?php

class Admin_Apps_AppsAdsController extends \Admin_AdsController {

    protected $type = 'app';
    protected $location = ['app_hot', 'app_search', 'app_new'];
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
                ->isTop('yes')
                ->IsLocation($this->location)
                ->whereType($this->type)
                ->orderBy('id', 'desc')
                ->paginate($this->pagesize);
        //下面的需要改下
        $appIds = [0];
        foreach ($ads as $ad) {
            $appIds[] = $ad->app_id;
        }
        $appsModel = new Apps();
        $apps = Apps::whereIn('id', $appIds)->get();
        $list = [];
        foreach ($apps as $app) {
            $list[$app->id] = $app->icon;
        }
        foreach ($ads as $ad) {
            $ad->image = isset($list[$ad->app_id]) ? $list[$ad->app_id] : '';
        }
        $datas = ['ads' => $ads, 
            'status' => Config::get('status.ads.status'), 
            'location' => Config::get('status.ads.applocation'),
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
        $datas = ['location' => array_slice(Config::get('status.ads.applocation'), 1)];
        
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
        //检测游戏是否存在
        $app = Apps::whereStatus('stock')->find(Input::get('app_id'));
        if (!$app) {
            return Redirect::route('appsads.create')
                ->with('msg', '#' . Input::get('app_id') . '游戏不存在')
                ->with('input', Input::all());
        }
        //检查该游戏广告是否重复了
        $ad = Ads::whereType($this->type)->IsLocation(Input::get('location'))
                ->isTop('yes')
                ->whereLocation(Input::get('location'))
                ->where('app_id', Input::get('app_id'))->first();
        if ($ad){
            return Redirect::route('appsads.create')
                ->with('msg', '该分类游戏已经存在')
                ->with('input', Input::all());
        }
        $ad = $ads->ofCreate($this->type);
        $ad->is_top = 'yes';
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
        $ad = Ads::whereType($this->type)->IsLocation(Input::get('location'))
                ->isTop('yes')->find($id);
        //检测广告是否存在
        if (!$ad) {
            return Redirect::route('appsads.index')->with('msg', '游戏不存在');
        }
        //检测游戏是否存在
        $app = Apps::whereStatus('stock')->find($ad->app_id);
        if (!$app) {
            return Redirect::route('appsads.index')->with('msg', '游戏不存在');
        }
        $datas = ['ad' => $ad, 
            'location' => array_slice(Config::get('status.ads.applocation'), 1),
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
        $ad = Ads::whereType($this->type)->IsLocation(Input::get('location'))
                ->isTop('yes')->find($id);
        if (!$ad) {
            return Redirect::route('appsads.index')->with('msg', '亲，数据不存在');
        }
        $valid = (new Ads)->isValid(Input::all(), 'update');
        if (!$valid){
            Log::error('广告分类更新');
            return Redirect::route('appsads.edit', $id)->with('msg', '添加失败');
        }
        //检测游戏是否存在
        $app = Apps::whereStatus('stock')->find($ad->app_id);
        if (!$app) {
            $ad->is_stock = 'no';
            $ad->save();
            return Redirect::route('indexads.index')->with('msg', 'APP不存在了');
        }
        $ad = (new Ads)->ofUpdate($ad);
        $ad->is_top = 'yes';
        if ($ad->save()) {
            return Redirect::route('appsads.index')->with('msg', '修改成功');
        }
        return Redirect::route('appsads.index')->with('msg', '没什么改变');
    }

}