<?php

class Admin_EditorAdsController extends \Admin_AdsController {
    
    protected $type = 'banner';
    protected $location = ['banner_suggest'];
    protected $indexRoute = 'editorads.index';
    /**
     * 编辑精选广告列表
     * GET /admin/editorads
     *
     * @return Response
     */
    public function index()
    {
        $ads = Ads::ofTitle(Input::get('word'))
                ->ofStatus(Input::get('status'))
                ->isTop(Input::get('is_top'))
                ->whereType($this->type)
                ->isLocation($this->location)
                ->orderBy('id', 'desc')
                ->paginate($this->pagesize);
        $datas = ['ads' => $ads, 
            'status' => Config::get('status.ads.status'), 
            'is_top' => Config::get('status.ads.is_top')
        ];
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
        $datas = ['location' => Config::get('status.ads.location')];
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
        $valid = (new Ads)->isValid(Input::all());
        if (!$valid) {
            return Redirect::route('editorads.create')
                ->with('msg', '添加失败')
                ->with('input', Input::all());
        }
        //检测游戏是否存在
        $app = Apps::whereStatus('stock')->find(Input::get('app_id'));
        if (!$app) {
            return Redirect::route('editorads.create')
                ->with('msg', '游戏不存在')
                ->with('input', Input::all());
        }
        //检查该游戏广告是否重复了
        $ad = Ads::whereType($this->type)->whereIn('location', $this->location)
            ->where('app_id', Input::get('app_id'))
            ->isTop(Input::get('is_top', 'no'))
            ->count();
        if ($ad > 0){
            return Redirect::route('editorads.create')
                ->with('msg', '该分类游戏已经存在')
                ->with('input', Input::all());
        }
        $ad = (new Ads)->ofCreate($this->type, 'banner_suggest');
        if ($ad->save()) {
            return Redirect::route('editorads.index')->with('msg', '添加成功');
        }
        return Redirect::route('editorads.create')
            ->with('msg', '添加失败')
            ->with('input', Input::all());
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
        $ad = Ads::whereType($this->type)->find($id);
        //检测广告是否存在
        if (!$ad) {
            return Redirect::route('editorads.index')->with('msg', '没发现广告数据');
        }
        //检测游戏是否存在
        $app = Apps::whereStatus('stock')->find($ad->app_id);
        if (!$app) {
            return Redirect::route('editorads.index')->with('msg', '游戏不存在');
        }
        $datas = ['ad' => $ad, 
            'location' => Config::get('status.ads.location'),
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
        $ad = Ads::whereType($this->type)->whereLocation($this->location)->find($id);
        //检测广告是否存在
        if (!$ad) {
            return Redirect::route('editorads.index')->with('msg', '#' . $id .'不存在');
        }
        $valid = (new Ads)->isValid(Input::all(), 'update');
        if (!$valid) {
            Log::error($validator->messages());
            return Redirect::route('editorads.edit', $id)->with('msg', '修改失败,格式不对');
        }
        $app = Apps::whereStatus('stock')->find($ad->app_id);
        if (!$app) {
            $ad->is_stock = 'no';
            $ad->save();
            return Redirect::route('indexads.index')->with('msg', 'APP不存在了');
        }
        $ad = (new Ads)->ofUpdate($ad);
        if ($ad->save()) {
            return Redirect::route('editorads.index')->with('msg', '修改成功');
        } else {
            return Redirect::route('editorads.edit', $id)->with('msg', '修改失败');
        }
        
    }
}