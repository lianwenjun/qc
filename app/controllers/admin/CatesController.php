<?php

class Admin_CatesController extends \Admin_BaseController {

    protected $user_id = 1;
    protected $layout = 'admin.layout';
    protected $pagesize = 5;
    /**
     * 
     * GET /admin/cates
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * 获得标签的列表
     * @method GET
     * @param  
     * @return Response
     */
    public function tagIndex()
    {
        $query = ['id', '>', '0'];
        //查询，默认分页
        $total = Cates::where('parent_id', '!=', 0)->whereNull('deleted_at')
                ->count();
        $cates = Cates::where('parent_id', '=', 0)->whereNull('deleted_at')
                ->get();
        $catesArr = [];
        foreach ($cates as $cate) {
            //echo $cate->title;
            $catesArr[$cate->id] = $cate->title;
        }
        $tags = Cates::where('parent_id', '!=', 0)->whereNull('deleted_at')
            ->orderBy('id', 'desc')->paginate($this->pagesize);
        $datas = ['tags' => $tags, 'total' => $total, 'cates' => $catesArr];
        $this->layout->content = View::make('admin.cates.tagIndex', $datas);
    }

    /**
     * 添加标签
     * @method GET
     * @param int parent_id
     * @param string word
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * 添加标签
     * @method POST
     * @param int parent_id
     * @param string word
     * @return Response
     */
    public function store()
    {
        //检测输入
        Log::error(Input::all());
        $cates = new Cates;
        $validate = $cates->validateCatesCreate();
        if ($validate->fails()){
            Log::error($validate->messages());
            return Response::json(['status'=>'error', 'msg'=>'word is must need']);
        }
        //保存数据
        $cates->operator = $this->user_id;
        $cates->creator = $this->user_id;
        $cates->title = Input::get('word');
        $cates->parent_id = Input::get('parent_id', 0);
        $cates->save();
        return Response::json(['status'=>'ok', 'msg'=>'suss']);
    }

    /**
     * Display the specified resource.
     * GET /admin/cates/{id}
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
     * GET /admin/cates/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //检测是否存在该数据
        $cate = Cates::where('id', $id)->whereNull('deleted_at')->first();
        if(!$cate){
            return ['status' => 'error', 'msg' => 'cate is valid'];   
        }
    }

    /**
     * Update the specified resource in storage.
     * PUT /admin/cates/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //检测是否存在该数据
        $cates = new Cates;
        $cate = $cates->where('id', $id)->whereNull('deleted_at')->first();
        if(!$cate){
            return Response::json(['status' => 'error', 'msg' => 'cate is valid']);   
        }
        //检测输入
        Log::error(Input::all());
        $validate = $cates->validateCatesCreate();
        if ($validate->fails()){
            Log::error($validate->messages());
            return Response::json(['status'=>'error', 'msg'=>'word is must need']);
        }
        //保存数据
        $cate->operator = $this->user_id;
        $cate->title = Input::get('word');
        $cate->sort = Input::get('sort', 0);
        $cate->save();
        return Response::json(['status'=>'ok', 'msg'=>'suss']);
    }

    /**
     * 
     * 删除标签
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //检测是否存在该数据
        $cate = Cates::where('id', $id)->whereNull('deleted_at')->first();
        if(!$cate){
            return Response::json(['status' => 'error', 'msg' => 'cate is valid']);   
        }
        $cate->delete();
        return Response::json(['status' => 'ok', 'msg' => 'suss']);
    }

}