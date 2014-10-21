<?php

class Admin_indexAdsController extends \Admin_BaseController {

    protected $type = 'index';
    /**
     * 显示首页图片位管理
     * GET /admin/ads
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
                'location' => Config::get('status.ads.applocation'),
                'is_top' => Config::get('status.ads.is_top') ];
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
        $datas = ['location' => Config::get('status.ads.applocation')];
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
        $adsModel = new Ads();
        $msg = "添加失败";
        $validator = Validator::make(Input::all(), $adsModel->adsCreateRules);
        if ($validator->fails()){
            Log::error($validator->messages());
            return Redirect::route('indexads.create')->with('msg', $msg)->with('input', Input::all());
        }
        //检测游戏是否存在
        $appsModel = new Apps;
        $app = $appsModel->find(Input::get('app_id'));
        if (!$app) {
            $msg = '#' . Input::get('app_id') . '游戏不存在';
            return Redirect::route('indexads.create')->with('msg', $msg)->with('input', Input::all());
        }
        $ad = $adsModel->createAds($this->type);
        if ($ad) {
            $msg = "添加成功";
            return Redirect::route('indexads.index')->with('msg', $msg);
        }
        return Redirect::route('indexads.create')->with('msg', $msg)->with('input', Input::all());
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
        $ad = $adsModel->where('id', $id)->where('type', $this->type)->first();
        //检测广告是否存在
        if (!$ad) {
            return Redirect::route('indexads.index');
        }
        //检测游戏是否存在
        $appsModel = new Apps;
        $app = $appsModel->find($ad->app_id);
        if (!$app) {
            return Redirect::route('indexads.index');
        }
        $datas = ['ad' => $ad, 
            'location' => Config::get('status.ads.applocation'),
            'app' => $app];
        $this->layout->content = View::make('admin.indexads.edit', $datas);
    }

    /**
     * 更新首页图片位广告
     * PUT /admin/ads/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $adsModel = new Ads();
        $ad = $adsModel->where('id', $id)->where('type', $this->type)->first();
        if (!$ad) {
            $msg = '亲，数据不存在';
            return Redirect::back()->with('msg', $msg);
        }
        $validator = Validator::make(Input::all(), $adsModel->adsUpdateRules);
        if ($validator->fails()){
            Log::error($validator->messages());
            $msg = "添加失败";
            return Redirect::back()->with('msg', $msg);
        }
        $ad->location = Input::get('location', $ad->location);
        $ad->image = Input::get('image', $ad->image);
        $ad->is_top = Input::get('is_top', 'no');
        $ad->onshelfed_at = Input::get('onshelfed_at', $ad->onshelfed_at);
        $ad->offshelfed_at = Input::get('offshelfed_at', $ad->offshelfed_at);
        $ad->is_onshelf = 'yes';
        if ($ad->save()){
            $msg = "修改成功";
            return Redirect::route('indexads.index')->with('msg', $msg);
        }
        $msg = "没什么改变";
        return Redirect::route('indexads.index')->with('msg', $msg);
    }

    /**
     * 下架首页图片位广告
     * DELETE /admin/ads/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function offshelf($id)
    {
        $adsModel = new Ads();
        $ad = $adsModel->offshelf($id, $this->type);
        if (!$ad) {
            $msg = '亲，#'.$id.'下架失败了';
            return Request::header('referrer') ? Redirect::back()
                ->with('msg', $msg) : Redirect::route('indexads.index')->with('msg', $msg);
        }
        $msg = '亲，#'.$id.'下架成功';
        return Request::header('referrer') ? Redirect::back()
                ->with('msg', $msg) : Redirect::route('indexads.index')->with('msg', $msg);
    }

    /**
     * 删除首页图片位广告
     * DELETE /admin/ads/{id}
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
                ->with('msg', $msg) : Redirect::route('indexads.index')->with('msg', $msg);
        }
        $msg = '#' . $id . '删除失败';
        if ($ad->delete()){
            $msg = '#' . $id . '删除成功';
        }
        return Request::header('referrer') ? Redirect::back()
            ->with('msg', $msg) : Redirect::route('indexads.index')->with('msg', $msg);
    }
    
    /**
    * 上传图片
    */
    public function upload(){
        $adsModel = new Ads();
        return $adsModel->imageUpload();
    }
}