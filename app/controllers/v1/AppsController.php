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
     * Show the form for creating a new resource.
     * GET /api/apps/create
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/apps
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     * GET /api/apps/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * GET /api/apps/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 获得单个游戏的信息
     * GET /api/v1/game/info/appid/{appid}
     *
     * @param  int  $id
     * @return Response
     */
    public function info($appid)
    {
        $app = Api_Apps::find($appid)->toArray();
        $data = [];
        if (!$app) {
            return $this->result(['data' => $data, 'msg' => '0', 'msgbox' => '数据不存在']);
        }
        //对应放哪去
        $fields = [
            'comment_count' => 'commentCnt',
            'link' => 'downUrl', 
            'download_counts' => 'downloadCnt', 
            'id' => 'id', 
            'icon' => 'logoImageUrl', 
            'md5' => 'md5', 
            'title' => 'name', 
            'pack' => 'packageName',
            'rating' => 'score',
            'size_int' => 'size',
            'version' => 'version',
            'version_code' => 'versionCode',
            'has_ad' => 'ad',
            'author' => 'author',
            'category' => 'categoryId',
            'summary' => 'description',
            'images' => 'screenshotImageUrls',//
            'is_verify' => 'secureVerify',
            'tagList' => 'tagList',
            'changes' => 'updateContent',
            'updated_at' => 'uploadTime',
        ];
        foreach ($fields as $key => $value) {
            $data[$value] = '';
        }
        foreach ($app as $key => $value) {
            if (isset($fields[$key])) $data[$fields[$key]] = $value;
        };
        return $this->result(['data' => $data, 'msg' => '1', 'msgbox' => '数据获取成功']);
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
        $apps = Api_Apps::whereStatus('stock')->ofTitle($keyword)->orderBy('id', 'desc')->get();
        $data = [];
        foreach ($apps as $app) {
            $data[] = [
                'id' => $app->id, 
                'name' => $app->title,
                'type' => 1
            ];
        }
        return $this->result(['data'=>$data, 'msg'=>'1', 'msgbox'=>'数据获取成功']);
    }

}