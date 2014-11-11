<?php

class Admin_indexAdsController extends \Admin_AdsController {

    protected $type = 'banner';
    protected $location = ['banner_hot', 'banner_slide', 'banner_new'];
    protected $indexRoute = 'indexads.index';
    /**
     * 显示首页图片位管理
     * GET /admin/ads
     *
     * @return Response
     */
    public function index()
    {
        $ads = Ads::ofTitle(Input::get('word'))
                ->ofStatus(Input::get('status'))
                ->ofLocation(Input::get('location'))
                ->isTop(Input::get('is_top'))
                ->IsLocation($this->location)
                ->whereType($this->type)
                ->orderBy('id', 'desc')
                ->paginate($this->pagesize);
        $datas = ['ads' => $ads, 
            'status' =>  Config::get('status.ads.status'), 
            'location' => Config::get('status.ads.bannerLocation'),
            'is_top' =>  Config::get('status.ads.is_top')
        ];
        $this->layout->content = View::make('admin.indexads.index', $datas);
    }

    /**
     * 打开添加首页图片位管理广告
     * GET /admin/ads/create
     *
     * @return Response
     */
    public function create()
    {
        $location = Config::get('status.ads.bannerLocation');
        $location = array_slice($location, 1);
        $datas = ['location' => $location];
        $this->layout->content = View::make('admin.indexads.create', $datas);
    }

    /**
     * 保存新添加的首页图片位广告
     * POST /admin/ads
     *
     * @return Response
     */
    public function store()
    {
        $valid = (new Ads)->isValid(Input::all());
        if (!$valid) {
            return Redirect::route('indexads.create')
                ->with('msg', '添加失败')
                ->with('input', Input::all());
        }
        //检测游戏是否存在
        $app = Apps::whereStatus('stock')->find(Input::get('app_id'));
        if (!$app) {
            return Redirect::route('indexads.create')
                ->with('msg', '#' . Input::get('app_id') . '游戏不存在')
                ->with('input', Input::all());
        }
        //检查该游戏广告是否重复了
        $ad = Ads::whereType($this->type)->IsLocation(Input::get('location'))->
                where('app_id', Input::get('app_id'))->get();
        if ($ad){
            return Redirect::route('indexads.create')
                ->with('msg', '该分类游戏已经存在')
                ->with('input', Input::all());
        }
        $ad = (new Ads)->ofCreate($this->type);
        if ($ad->save()) {
            return Redirect::route('indexads.index')->with('msg', '添加成功');
        }
        return Redirect::route('indexads.create')
            ->with('msg', '添加失败')
            ->with('input', Input::all());
    }
    /**
     * 编辑选定的首页图片位广告
     * GET /admin/ads/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $adsModel = new Ads();
        $ad = Ads::whereType($this->type)->find($id);
        //检测广告是否存在
        if (!$ad) {
            return Redirect::route('indexads.index');
        }
        //检测游戏是否存在
        $app = Apps::whereStatus('stock')->find($ad->app_id);
        if (!$app) {
            return Redirect::route('indexads.index');
        }
        $location = Config::get('status.ads.bannerLocation');
        $location = array_slice($location, 1);
        $datas = ['location' => $location];
        $datas = ['ad' => $ad, 
            'location' => $location,
            'app' => $app];
        $this->layout->content = View::make('admin.indexads.edit', $datas);
    }

    /**
     * 更新首页图片位广告
     * PUT /admin/ads/{id}
     *
     * @param  int  
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
            return Redirect::route('indexads.index')->with('msg', '亲，数据不存在');
        }
        $valid = (new Ads)->isValid(Input::all(), 'update');
        if (!$valid) {
            return Redirect::route('indexads.edit', $id)->with('msg', '添加失败');
        }
        //检测游戏是否存在
        $app = Apps::whereStatus('stock')->find($ad->app_id);
        if (!$app) {
            $ad->is_stock = 'no';
            $ad->save();
            return Redirect::route('indexads.index')->with('msg', 'APP不存在了');
        }
        $ad = (new Ads)->ofUpdate($ad);
        if ($ad->save()){
            return Redirect::route('indexads.index')->with('msg', '修改成功');
        }
        return Redirect::route('indexads.index')->with('msg', '没什么改变');
    }
}