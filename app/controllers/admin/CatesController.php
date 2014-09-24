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
        $cateModel = new Cates;
        $cates = $cateModel->where('parent_id', 0)->get();
        $cateIds = [];
        foreach ($cates as $cate) {
            $cateIds[] = $cate->id;
        }
        $tags = $cateModel->whereIn('parent_id', $cateIds)->get();
        $cateData = [];
        $i = 1;
        foreach ($cates as $index => $cate) {
            $cateData[$cate->id]['data'] = $cate->toarray();
            $cateData[$cate->id]['appcount'] = 0;
            $cateData[$cate->id]['one'] = 1;
            $cateData[$cate->id]['list'] = [];
            if ($i % 2 == 0){
                $cateData[$cate->id]['one'] = 0;
            }
            $i = $i + 1;
        }
        foreach ($tags as $tag) {
            $cateData[$tag->parent_id]['list'][] = $tag->toarray(); 
        }
        $appsCount = DB::table('app_cates')
                     ->select(DB::raw('count(*) as app_count, cate_id'))
                     ->whereIn('cate_id', $cateIds)
                     ->groupBy('cate_id')
                     ->get();
        foreach ($appsCount as $app) {
                $cateData[$app->cate_id]['appcount'] = $app->app_count;
        }
        $datas = ['cates' => $cateData];
        $this->layout->content = View::make('admin.cates.index', $datas);
    }

    /**
     * 获得标签的列表
     * @method GET
     * @param  
     * @return Response
     */
    public function tagIndex()
    {
        $C = new Cates;
        $query = $C;
        if (Input::get('word')) {
            $words = ['%', Input::get('word'), '%'];
            $query = $C->where('title', 'like', join($words));
        }
        if (Input::get('parent_id')) {
            $query = $query->where('parent_id', '=', Input::get('parent_id'));
        } else {
            $query = $query->where('parent_id', '!=', 0);
        }
        $tags = $query->orderBy('id', 'desc')->paginate($this->pagesize);
        $cates = Cates::where('parent_id', 0)->get();
        $catesArr = [];
        foreach ($cates as $cate) {
            $catesArr[$cate->id] = $cate->title;
        }
        $datas = ['tags' => $tags, 'cates' => $catesArr];
        $this->layout->content = View::make('admin.cates.tagIndex', $datas);
    }

    /**
     * 添加分类
     * @method GET
     * @param int parent_id
     * @param string word
     * @return Response
     */
    public function create()
    {
        $datas = [];
        $this->layout->content = View::make('admin.cates.create', $datas);
    }

    /**
     * 添加标签
     * @method GET
     * @param int parent_id
     * @param string word
     * @return Response
     */
    public function tagCreate()
    {
        $cateModel = new Cates;
        $cates = $cateModel->where('parent_id', 0)->get();
        $datas = ['cates' => $cates];
        $this->layout->content = View::make('admin.cates.tagCreate', $datas);
    }

    /**
     * 添加分类
     * @method POST
     * @param string word
     * @return Response
     */
    public function store()
    {
        //检测输入
        //Log::error(Input::all());
        $cateModel = new Cates;
        $validator = Validator::make(Input::all(), $cateModel->CatesRules);
        if ($validator->fails()){
            Log::error($validator->messages());
            return Response::json(['status'=>'error', 'msg'=>'word is must need']);
        }
        //保存数据
        $cateModel->title = Input::get('word');
        $cateModel->save();
        return Response::json(['status'=>'ok', 'msg'=>'suss']);
    }
    /**
     * 添加标签
     * @method POST
     * @param int parent_id
     * @param string word
     * @return Response
     */
    public function tagStore()
    {
        //检测输入
        Log::error(Input::all());
        $cateModel = new Cates;
        $validator = Validator::make(Input::all(), $cateModel->TagsCreateRules);
        if ($validator->fails()){
            Log::error($validator->messages());
            return Response::json(['status'=>'error', 'msg'=>'word is must need']);
        }
        //保存数据
        $cateModel->title = Input::get('word');
        $cateModel->parent_id = Input::get('parent_id');
        $cateModel->save();
        return Response::json(['status'=>'ok', 'msg'=>'suss']);
    }

    /**
     * 分类获得
     * @method GET
     * 
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $cateModel = new Cates;
        $cate = $cateModel->where('id', $id)->where('parent_id', 0)->first();
        if (empty($cate)){
            return Response::json(['status'=>'error', 'msg'=>'id is valid']);
        }
        $tags = $cateModel->where('parent_id', $cate->id)->get();
        $tagIds = [];
        $tagDatas = [];
        foreach ($tags as $tag) {
            $tagIds[] = $tagIds;
            $tagDatas[$tag->id]['data'] = $tag;
            $tagDatas[$tag->id]['count'] = 0;
        }
        //统计该标签游戏数量
        $appsCount = DB::table('app_cates')
                     ->select(DB::raw('count(*) as app_count, cate_id'))
                     ->whereIn('cate_id', $tagIds)
                     ->groupBy('cate_id')
                     ->get();
        foreach ($appsCount as $app) {
            $tagDatas[$app->cate_id]['count'] = $app->app_count;
        }
        return Response::json(['status'=>'ok', 'msg'=>'suss', 'data'=>$tagDatas]);
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
        $cate = Cates::find($id);
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
        $cateModel = new Cates;
        $cate = $cateModel->find($id);
        if(!$cate){
            return Response::json(['status' => 'error', 'msg' => 'cate is valid']);   
        }
        //检测输入
        //Log::error(Input::all());
        $validator = Validator::make(Input::all(), $cateModel->TagsCreateRules);
        if ($validator->fails()){
            Log::error($validator->messages());
            return Response::json(['status'=>'error', 'msg'=>'word is must need']);
        }
        //保存数据
        $cate->title = Input::get('word');
        if (!empty(Input::get('sort', 0))){
            $cate->sort = Input::get('sort', 0);
        }
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
        $cateModel = new Cates;
        $cate = $cateModel->find($id);
        if(!$cate){
            return Response::json(['status' => 'error', 'msg' => 'cate is valid']);   
        }
        $cate->delete();
        return Response::json(['status' => 'ok', 'msg' => 'suss']);
    }

}