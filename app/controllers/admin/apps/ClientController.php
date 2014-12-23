<?php

class Admin_Apps_ClientController extends \Admin_BaseController {
    protected $pagesize = 20;
    /**
     * 本地APK的版本列表
     * GET 
     *
     * @return Response
     */
    public function index()
    {
        $apps = Client::OrderBy('id', 'desc')
                ->paginate($this->pagesize);
        $this->layout->content = View::make('admin.client.index', ['apps' => $apps]);
    }

    /**
     * 本地apk的添加页面
     *
     * @return Response
     */
    public function create()
    {
        $datas = [];
        $this->layout->content = View::make('admin.client.create', $datas);
    }

    /**
     * 本地apk的新增
     * POST
     * @return Response
     */
    public function store()
    {
        $isvalid = (new CClient)->isValid(Input::all(), 'create');
        if ($isvalid->fails()) {
            return Redirect::route('client.create')->with('msg', '缺少数据');
        }
        //检测重复
        $count = Client::where('version_code', Input::get('version_code', 0))
                ->where('title', Input::get('title', ''))
                ->count();
        if ($count > 0) {
            return Redirect::route('client.create')->with('msg', 'APK重复了');
        }        
        $app = (new CClient)->create();
        return Redirect::route('client.index')->with('msg', '添加 #' . $app->id . '成功');
    }

    /**
     * 
     * 编辑APK页面
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $app = Client::find($id);
        if (!$app) {
            return Redirect::route('client.index')->with('msg', '未找到#' . $id . '数据');
        }
        $this->layout->content = View::make('admin.client.edit', ['app' => $app]);
    }

    /**
     * 更细APK数据
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $app = Client::where('version_code', Input::get('version_code', 0))
                ->where('title', Input::get('title', ''))
                ->find($id);
        if (!$app) {
            return Redirect::route('client.index')->with('msg', '未找到符合#' . $id . '的数据');
        }
        if ((new CClient)->isValid(Input::all(), 'update')->fails()) {
            return Redirect::route('client.edit', $id)->with('msg', '缺少数据');
        }
        $app = (new CClient)->update($app);
        return Redirect::route('client.index')->with('msg', '修改 #' . $app->id . '成功');
    }

    /**
     * 上传APK文件
     * 
     */
    public function apkupload() {
        $uploader = (new CUpload)->instance('client', 'client')->upload();
        $data = $uploader['result']['data'];  
        // 获取MD5
        $uploader['result']['data']['md5'] = md5_file(public_path() . $data['download_link']);
        $uploader['result']['data']['created_at'] = date('Y-m-d H:i:s', time());
        return $uploader;
    }

}