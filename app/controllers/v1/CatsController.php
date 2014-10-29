<?php

class V1_CatsController extends \V1_BaseController {
    /**
     * 获得分类列表信息
     * GET /api/v1/game/category/all
     * @return Response json
     */
    public function index()
    {
        $cats = Api_Cats::where('parent_id', 0)->get();
        $catIds = [0];
        $catsTmp = [];
        //这循环有点糟糕
        foreach ($cats as $cat) {
            $catIds[] = $cat->id;
            $catsTmp[$cat->id]['id'] = $cat->id;
            $catsTmp[$cat->id]['title'] = $cat->title;
            $catsTmp[$cat->id]['ImgUrl'] = '';
        }
        //这个请求可以合并到MODEL里去
        $catImgs = Api_CatAds::whereIn('cat_id', $catIds)->get();
        $imgTmp = [];
        //
        foreach ($catImgs as $catImg) {
            $catsTmp[$catImg->cat_id]['ImgUrl'] = $catImg->image;
        }
        $datas = [];
        foreach ($catsTmp as $index => $catTmp) {
            $datas[] = $catTmp;
        }
        return $this->result(['data'=>$datas, 'msg'=>'1', 'msgbox'=>'数据获取成功']);
    }
}