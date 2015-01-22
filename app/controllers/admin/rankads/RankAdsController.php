<?php

class Admin_rankAdsController extends \Admin_AdsController {

    protected $type = 'app';
    protected $location = ['app_hot', 'app_rise', 'app_new'];
    protected $indexRoute = 'rankads.index';
    /**
     * 显示排行广告列表
     * GET /admin/rankads
     *
     * @return Response
     */
    public function index()
    {
        $ads = Ads::ofTitle(Input::get('word'))
                ->ofStatus(Input::get('status'))
                ->ofLocation(Input::get('location'))
                ->where('is_top', 'no')
                ->whereIn('location', $this->location)
                ->whereType($this->type)
                ->orderBy('sort', 'desc')
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
        $datas = [
                'ads' => $ads,
                'status' =>  Config::get('status.ads.status'), 
                'location' => Config::get('status.ads.ranklocation'),
        ];
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
        $datas = ['location' => array_slice(Config::get('status.ads.ranklocation'), 1)];
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
        if (!(new Ads)->isValid(Input::all())) {
            return Redirect::route('rankads.create')
                ->with('msg', '添加失败')
                ->with('input', Input::all());
        }
        //检测游戏是否存在
        $app = Apps::whereStatus('stock')->find(Input::get('app_id'));
        if (!$app) {
            return Redirect::route('rankads.create')
                ->with('msg', '游戏不存在')
                ->with('input', Input::all());
        }
        //检查该游戏广告是否重复了
        $ad = Ads::whereType($this->type)->whereLocation(Input::get('location'))
                ->where('is_top', 'no')
                ->where('app_id', Input::get('app_id'))->first();
        if ($ad){
            return Redirect::route('rankads.create')
                ->with('msg', '该分类游戏已经存在')
                ->with('input', Input::all());
        }
        //存储
        $ad = (new Ads)->ofCreate($this->type);
        if ($ad->save()) {

            // 记录操作日志
            $logData['action_field'] = '广告位管理-排行游戏位管理';
            $logData['description'] = '新增了广告 广告ID为' . $ad->id;
            Base::dolog($logData);

            return Redirect::route('rankads.index')->with('msg', '添加成功');
        }
        return Redirect::route('rankads.create')
            ->with('msg', '添加失败')
            ->with('input', Input::all());
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
        $ad = Ads::whereType($this->type)->where('is_top', 'no')->find($id);
        //检测广告是否存在
        if (!$ad) {
            return Redirect::route('rankads.index')->with('msg', '广告不存在');
        }
        //检测游戏是否存在
        $app = Apps::whereStatus('stock')->find($ad->app_id);
        if (!$app) {
            return Redirect::route('rankads.index')->with('msg', '游戏不存在');
        }
        $datas = ['ad' => $ad, 
            'location' => array_slice(Config::get('status.ads.ranklocation'), 1),
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
        $ad = Ads::whereType($this->type)->where('is_top', 'no')->find($id);
        if (!$ad) {
            return Redirect::back()->with('msg', '亲，数据不存在');
        }
        $valid = (new Ads)->isValid(Input::all(), 'update');
        if (!$valid){
            return Redirect::back()->with('msg', '修改失败');
        }
        //检测游戏是否存在
        $app = Apps::whereStatus('stock')->find($ad->app_id);
        if (!$app) {
            return Redirect::route('rankads.edit', $id)
                ->with('msg', '游戏不存在');
        }
        $ad = (new Ads)->ofUpdate($ad);
        if ($ad->save()){

            // 记录操作日志
            $logData['action_field'] = '广告位管理-排行游戏位管理';
            $logData['description'] = '编辑了广告 广告ID为' . $ad->id;
            Base::dolog($logData);
            
            return Redirect::route('rankads.index')->with('msg', '修改成功');
        } else {
            return Redirect::back()->with('msg', '没什么改变');
        }
    }

}