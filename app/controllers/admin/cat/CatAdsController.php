<?php

class Admin_Cat_CatAdsController extends \Admin_BaseController {
    
    /**
     * 分类广告图的列表
     * 
     *
     * @return Response
     */
    public function index()
    {
        $catAds = CatAds::orderBy('id', 'desc')->paginate($this->pagesize);
        $datas = ['catads' => $catAds];
        $this->layout->content = View::make('admin.catads.index', $datas);
    }

    /**
     * 更新图片路径
     * POST /admin/catads/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $catAdsModel = new CatAds();
        $ads = CatAds::find($id);
        if (!$ads) {
            //不存在
            return ['status' => 'error', 'msg' => 'id is valid'];
        }
        
        $validator = Validator::make(Input::all(), $catAdsModel->updateRules);
        if ($validator->fails()) {
            return ['status' => 'error', 'msg' => 'validator'];
        }
        
        $ads->image = Input::get('image');
        if (!$ads->save()) {
            return ['status' => 'error', 'msg' => 'id is valid'];
        }
        return ['status' => 'ok', 'msg' => 'suss'];
        //return Redirect::route('catads.index')->with('msg', '更新#' . $id . '成功');
    }

    /**
    * 上传图片
    */
    public function upload(){
        $catAdsModel = new CatAds();
        return $catAdsModel->imageUpload();
    }

}