<?php

class V1_AppsController extends \V1_BaseController {

    /**
     * Display a listing of the resource.
     * GET /api/apps
     *
     * @return Response
     */
    public function index()
    {
        //
    }
    /**
     * 获得单个游戏的信息
     * GET /api/v1/game/info/appid/{appid}
     *
     * @param  int  $appid
     * @return Response
     */
    public function info($appid)
    {
        $app = Api_Apps::find($appid);
        $data = [];
        if (!$app) {
            return $this->result(['data' => $data, 'msg' => 0, 'msgbox' => '数据不存在']);
        }
        $app = $app->toArray();
        //对应放哪去
        $fields = [
            'download_manual' => 'downloadCnt', 
            'id' => 'id',
            'md5' => 'md5', 
            'title' => 'name', 
            'pack' => 'packageName',
            'size_int' => 'size',
            'version' => 'version',
            'version_code' => 'versionCode',
            'author' => 'author',
            'summary' => 'description',
            'changes' => 'updateContent',
            
            'updated_at' => 'uploadTime', //
            'images' => 'screenshotImageUrls',//
            'is_verify' => 'secureVerify',//
            'has_ad' => 'ad', //
            'download_link' => 'downUrl', //
            'icon' => 'logoImageUrl', // 

            'comment' => 'commentCnt', //评论统计
            'rating' => 'score', // 评分
            'gameCategory' => 'gameCategory', //分类名
            'tagList' => 'tagList', //标签列表
            'categoryId' => 'categoryId',//分类ID
        ];
        foreach ($fields as $key => $value) {
            $data[$value] = '';
        }
        foreach ($app as $key => $value) {
            if (isset($fields[$key])) $data[$fields[$key]] = $value;
        };
        return $this->result(['data' => $data, 'msg' => 1, 'msgbox' => '数据获取成功']);
    }

    /**
     * 根据关键字自动匹配游戏名称
     * GET /api/v1/game/search/autocomplete/{keyword}
     *
     * @param  string  $keyword
     * @return Response json
     */
    public function autoComplete($keyword)
    {
        $apps = Api_Apps::whereStatus('stock')
            ->ofTitle($keyword)
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();
        $data = [];
        foreach ($apps as $app) {
            $data[] = [
                'id' => $app->id, 
                'name' => $app->title,
                'type' => 1
            ];
        }
        return $this->result(['data' => $data, 'msg' => 1, 'msgbox' => '数据获取成功']);
    }

}