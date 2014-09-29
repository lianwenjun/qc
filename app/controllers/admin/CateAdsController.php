<?php

class Admin_CateAdsController extends \BaseController {
    protected $user_id = 1;
    protected $layout = 'admin.layout';
    protected $pagesize = 5;
    /**
     * 分类广告图的列表
     * 
     *
     * @return Response
     */
    public function index()
    {
        $cateAdsModel = new CateAds();
        $cateAds = $cateAdsModel->orderBy('id', 'desc')->paginate($this->pagesize);
        $datas = ['cateads' => $cateAds];
        $this->layout->content = View::make('admin.cateads.index', $datas);
    }

    /**
     * 更新图片路径
     * POST /admin/cateads/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $cateAdsModel = new CateAds();
        $ads = $cateAdsModel->find($id);
        if (!$ads) {
            //不存在
            return ['status' => 'error', 'msg' => 'id is valid'];
        }
        $validator = Validator::make(Input::all(), $cateAdsModel->updateRules);
        if ($validator->fails()){
            return ['status' => 'error', 'msg' => 'validator'];
        }
        $ads->image = Input::get('image');
        $ads->save();
        return ['status' => 'ok', 'msg' => 'suss'];
        //return Redirect::route('cateads.index')->with('msg', '更新#' . $id . '成功');
    }

    /**
    * 上传图片
    */
    public function upload(){
        $cateAdsModel = new CateAds();
        return $cateAdsModel->imageUpload();
    }

}