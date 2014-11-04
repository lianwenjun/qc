<?php

class Admin_rankAdsController extends \Admin_AdsController {

    protected $type = 'rank';
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
                ->whereType($this->type)
                ->orderBy('id', 'desc')
                ->paginate($this->pagesize);
        //下面的需要改下
        $appsModel = new Apps();
        foreach ($ads as &$ad) {
            $app = $appsModel->find($ad->app_id);
            if ($app) $ad->image = $app->icon;
        }

        $datas = [
                'ads' => $ads,
                'status' =>  Config::get('status.ads.status'), 
                'location' => Config::get('status.ads.ranklocation'),
                'is_top' => Config::get('status.ads.is_top')
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
        if (!(new Ads)->isValid(Input::all())) {
            return Redirect::route('rankads.create')
                ->with('msg', '添加失败')
                ->with('input', Input::all());
        }
        //检测游戏是否存在
        $app = Apps::find(Input::get('app_id'));
        if (!$app) {
            return Redirect::route('indexads.create')
                ->with('msg', '#' . Input::get('app_id') . '游戏不存在')
                ->with('input', Input::all());
        }
        //存储
        $ad = (new Ads)->ofCreate($this->type);
        if ($ad->save()) {
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
        $ad = Ads::whereType($this->type)->find($id);
        //检测广告是否存在
        if (!$ad) {
            return Redirect::route('rankads.index')->with('msg', '广告不存在');
        }
        //检测游戏是否存在
        $app = Apps::find($ad->app_id);
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
        $ad = Ads::whereType($this->type)->find($id);
        if (!$ad) {
            return Redirect::back()->with('msg', '亲，数据不存在');
        }
        $valid = (new Ads)->isValid(Input::all(), 'update');
        if (!$valid){
            return Redirect::back()->with('msg', '修改失败');
        }
        $ad = (new Ads)->ofUpdate($ad);
        if ($ad->save()){
            return Redirect::route('rankads.index')->with('msg', '修改成功');
        } else {
            return Redirect::back()->with('msg', '没什么改变');
        }
    }

}