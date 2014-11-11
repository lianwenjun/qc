<?php

class V1_CatsController extends \V1_BaseController {
    /**
     * 获得分类列表信息
     * GET /v1/game/category/all
     * @return Response json
     */
    public function index()
    {
        $cats = Api_Cats::where('parent_id', 0)->orderBy('sort', 'desc')->get();
        $catIds = [];
        $catsTmp = [];
        //这循环有点糟糕
        foreach ($cats as $cat) {
            $catIds[] = $cat->id;
            $catsTmp[$cat->id]['id'] = $cat->id;
            $catsTmp[$cat->id]['title'] = $cat->title;
            $catsTmp[$cat->id]['ImgUrl'] = '';
            $catsTmp[$cat->id]['GameCount'] = 0;
        }
        if (!$catIds) {
            return $this->result(['data'=>'[]', 'msg'=>0, 'msgbox'=>'没分类']);
        }
        //这个请求可以合并到MODEL里去
        $catImgs = Api_CatAds::whereIn('cat_id', $catIds)->get();
        $imgTmp = [];
        //
        foreach ($catImgs as $catImg) {
            $catsTmp[$catImg->cat_id]['ImgUrl'] = $catImg->image;
        }
        //这步需要精简
        $appsCount = DB::table('app_cats')
                     ->select(DB::raw('count(*) as app_count, cat_id'))
                     ->whereIn('cat_id', $catIds)
                     ->groupBy('cat_id')
                     ->get();
        foreach ($appsCount as $app) {
                $catsTmp[$app->cat_id]['GameCount'] = $app->app_count;
        }
        $datas = [];
        foreach ($catsTmp as $index => $catTmp) {
            $datas[] = $catTmp;
        }
        return $this->result(['data'=>$datas, 'msg'=>1, 'msgbox'=>'数据获取成功']);
    }
}