<?php

class Admin_Cate_CateAdsController extends \Admin_BaseController {
    
    /**
     * 分类广告图的列表
     * 
     *
     * @return Response
     */
    public function index()
    {
        $cateAds = CateAds::orderBy('id', 'desc')->paginate($this->pagesize);
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
        $ads = CateAds::find($id);
        if (!$ads) {
            //不存在
            return ['status' => 'error', 'msg' => 'id is valid'];
        }
        
        $validator = Validator::make(Input::all(), $cateAdsModel->updateRules);
        if ($validator->fails()) {
            return ['status' => 'error', 'msg' => 'validator'];
        }
        
        $ads->image = Input::get('image');
        if (!$ads->save()) {
            return ['status' => 'error', 'msg' => 'id is valid'];
        }
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