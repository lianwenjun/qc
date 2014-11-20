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
        $ads = CatAds::find($id);
        if (!$ads) {
            //不存在
            return ['status' => 'error', 'msg' => 'id is valid'];
        }
        
        $validator = Validator::make(Input::all(), (new CatAds)->updateRules);
        if ($validator->fails()) {
            return ['status' => 'error', 'msg' => 'validator'];
        }
        
        $ads->image = Input::get('image');
        if (!$ads->save()) {
            return ['status' => 'error', 'msg' => 'id is valid'];
        }

        // 记录操作日志
        $logData['action_field'] = '广告位管理-分类页图片位推广';
        $logData['description'] = '编辑了广告 广告ID为' . $ads->id;
        Base::dolog($logData);

        return ['status' => 'ok', 'msg' => 'suss'];
    }

    /**
    * 上传图片
    * 返回图片字段 result : {data, path, fullPath}
    */
    public function upload(){
        return (new CUpload)->instance('image', 'catads')->upload();
    }

}