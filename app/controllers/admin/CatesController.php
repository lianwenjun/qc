<?php

class Admin_CatesController extends \Admin_BaseController {

    /**
     * 
     * GET /admin/cates
     *
     * @return Response
     */
    public function index()
    {
        $cateModel = new Cates;
        $cates = $cateModel->allCates();
        $cateIds = [];
        foreach ($cates as $cate) {
            $cateIds[] = $cate->id;
        }
        //为空的时候判断
        if (empty($cateIds)){
            $cateIds = [0];
        }
        $tags = $cateModel->whereIn('parent_id', $cateIds)->get();
        $cateData = [];
        foreach ($cates as $index => $cate) {
            $cateData[$cate->id]['data'] = $cate->toarray();
            $cateData[$cate->id]['appcount'] = 0;
            $cateData[$cate->id]['list'] = [];
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
        $datas = ['cates' => $cateData, 'allcates' => $cates];
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
        $cateModel = new Cates;
        $query = $cateModel;
        if (Input::get('word')) {
            $words = ['%', Input::get('word'), '%'];
            $query = $cateModel->where('title', 'like', join($words));
        }
        if (Input::get('parent_id')) {
            $query = $query->where('parent_id', '=', Input::get('parent_id'));
        } else {
            $query = $query->where('parent_id', '!=', 0);
        }
        $tags = $query->orderBy('id', 'desc')->paginate($this->pagesize);
        $cates = $cateModel->allCates();
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
    /*public function create()
    {
        $datas = [];
        $this->layout->content = View::make('admin.cates.create', $datas);
    }*/

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
        //保存到分类库中
        $cateAdsModel = new CateAds;
        $cateAdsModel->cate_id = $cateModel->id;
        $cateAdsModel->title = $cateModel->title;
        $cateAdsModel->save();
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
            $tagDatas[$tag->id]['data'] = $tag->toarray();
            $tagDatas[$tag->id]['count'] = 0;
            $tagDatas[$tag->id]['editurl'] = route('tag.edit', $tag->id);
            $tagDatas[$tag->id]['delurl'] = route('tag.delete', $tag->id);
        }
        //统计该标签游戏数量
        //空判断
        if (empty($tagIds)){
            $tagIds = [0];
        }
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
        $validator = Validator::make(Input::all(), $cateModel->TagsUpdateRules);
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
     * 删除分类
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

        //当删除的是分类的时候
        if ($cate->parent_id == 0){
            //属于所有的标签也删除
            $tags = $cateModel->where('parent_id', $cate->id)->get();
            foreach ($tags as $tag) {
                $tag->delete();
            }
            //删除广告的分类
            $cateAdsModel = new CateAds;
            $cateAds = $cateAdsModel->where('cate_id', $id)->first();
            isset($cateAds) ? $cateAds->delete() : '';
        }
        $cate->delete();
        return Response::json(['status' => 'ok', 'msg' => 'suss']);
    }
    
    /**
     * 
     * 删除标签
     *
     * @param  int  $id
     * @return Response
     */
    public function tagDestroy($id)
    {
        //检测是否存在该数据
        $cateModel = new Cates;
        $tag = $cateModel->where('id', $id)->where('parent_id', '!=', 0)->first();
        if(!$tag){
            return Redirect::route('tag.index')->with('msg', 'tag #' . $id . 'is valid');  
        }
        $tag->delete();
        return Redirect::route('tag.index')->with('msg', 'suss delete');
    }
}