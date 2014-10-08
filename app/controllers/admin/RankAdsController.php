<?php

class Admin_rankAdsController extends \BaseController {

    protected $user_id = 1;
    protected $layout = 'admin.layout';
    protected $pagesize = 5;
    protected $type = 'rank';
    /**
     * Display a listing of the resource.
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
        $statusArray = ['online' => '线上展示',
                    'onshelf' => '上架',
                    'expired' => '已过期',
                    'offshelf' => '已下架'];
        $datas = ['ads' => $ads, 'status' => $statusArray, 
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
        if ($validator->fails()){
            Log::error($validator->messages());
            $msg = "添加失败";
            return Redirect::route('rankads.create')->with('msg', $msg);
        }
        $fields = [
            'app_id' => Input::get('app_id'),
            'title' => Input::get('title'),
            'location' => Input::get('location'),
            'sort' => Input::get('sort'),
            //'is_top' => Input::get('is_top', 'no'),
            'onshelfed_at' => Input::get('onshelfed_at'),
            'offshelfed_at' => Input::get('offshelfed_at'),
            'type' => $this->type,
            'is_onshelf' => 'yes',
            ];
        //creater用法出错了？？？
        foreach ($fields as $key => $value) {
            $adsModel->$key = $value;
        }
        if ($adsModel->save()) {
            $msg = "添加成功";
            return Redirect::route('appsads.index')->with('msg', $msg);
        }
        return Redirect::route('rankads.index')->with('msg', $msg);
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
            return Redirect::route('rankads.index');
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
        $ads = $adsModel->where('id', $id)->where('type', $this->type)->first();
        if (!$ads) {
            $msg = '亲，数据不存在';
            return Redirect::back()->with('msg', $msg);
        }
        $validator = Validator::make(Input::all(), $adsModel->rankadsUpateRules);
        if ($validator->fails()){
            Log::error($validator->messages());
            $msg = "添加失败";
            return Redirect::back()->with('msg', $msg);
        }
        $ads->location = Input::get('location', $ads->location);
        $ads->is_top = Input::get('is_top', 'no');
        $ads->sort = Input::get('sort', $ads->sort);
        $ads->onshelfed_at = Input::get('onshelfed_at', $ads->onshelfed_at);
        $ads->offshelfed_at = Input::get('offshelfed_at', $ads->offshelfed_at);
        if ($ads->save()){
            $msg = "添加成功";
            return Redirect::route('rankads.index')->with('msg', $msg);
        }
        $msg = "没什么改变";
        return Redirect::route('rankads.index')->with('msg', $msg);
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
        $ad = $adsModel->where('id', $id)->where('type', $this->type)->first();
        if (!$ad) {
            $msg = '亲，你要下架的' . $id . '数据不存在';
            return Redirect::back();
        }
        $msg = '亲，下架失败了';
        $ad->is_onshelf = 'no';
        if (!$ad->save()){
            $msg = '亲，#' . $id . '下架成功了';
        }
        return Redirect::back();
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
            $msg = '#' . $id . '不存在';
            return Request::header('referrer') ? Redirect::back()
                ->with('msg', $msg) : Redirect::route('rankads.index')->with('msg', $msg);
        }
        $msg = '#' . $id . '删除失败';
        if ($ad->delete()){
            $msg = '#' . $id . '删除成功';
        }
        return Request::header('referrer') ? Redirect::back()
            ->with('msg', $msg) : Redirect::route('rankads.index')->with('msg', $msg);
    }

}