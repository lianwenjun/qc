<?php

class Admin_Cat_CatsController extends \Admin_BaseController {

    /**
     * 分类列表
     * GET /cats
     *
     * @return Response
     */
    public function index() 
    {
        $cats = Cats::lists($this->pagesize);

        foreach($cats as $cat) {
            // 根据分类id获取标签ids
            $gameCatTags = GameCatTags::rewordTagIds($cat->id);
            // 根据标签ids获取相应的tags
            foreach ($gameCatTags as $gameCatTag) {
                $tagIds[] = $gameCatTag->tag_id;
                $tags = Tags::relevantTags($tagIds);
                $tagTitle = [];
                // 将标签数组分解
                foreach ($tags as $tag) {
                    $tagTitle[] = $tag->title;
                    $cat->tags = implode(',', $tagTitle);
                }
            }

        }

        $position = Config::get('catsposition');

        return View::make('evolve.system.cats')->with('cats', $cats)
                                               ->with('position', $position);
    }

    /**
     * 分类添加接口
     * POST /cats/store
     *
     * @return Response 
     */
    public function store() 
    {
        $data = Input::all();
        $validator = Cats::isNewValid($data);

        if ($validator->fails()) {
             return Redirect::to('admin/cat/index')->withErrors($validator);
        } else {
            $catModel = new Cats;
            //保存数据
            $catModel->title = Input::get('title');
            $catModel->sort = Input::get('sort');
            $catModel->position = Input::get('position');
            $catModel->save();
            //保存到分类库中
            $catAdsModel = new CatAds;
            $catAdsModel->cat_id = $catModel->id;
            $catAdsModel->title = $catModel->title;
            $catAdsModel->save();

            return Redirect::to('admin/cat/index')->withSuccess('添加成功!');
        }

    }

    /**
     * 分类编辑页
     * GET /cats/{id}/edit
     *
     * @param $id int 分类id
     *
     * @return Response
     */
    public function edit($id) 
    {
        $cat = Cats::find($id);

        if ($cat) {
            // 根据分类id获取标签ids
            $gameCatTags = GameCatTags::rewordTagIds($id);
            // 根据标签ids获取相应的tags
            foreach ($gameCatTags as $gameCatTag) {
                $tagIds[] = $gameCatTag->tag_id;
                $cat->tags = Tags::relevantTags($tagIds);
            }

            return View::make('evolve.system.edit')->with('cat', $cat);
                                                
        } else {
            return Response::make('404 页面找不到', 404);
        }
    }

    /**
     * 分类更新接口
     * PUT cats/{id}/update
     *
     * @param $id int 分类id
     *
     * @return Response
     */
    public function update($id) 
    {
        $data = Input::all();
        $validator = Cats::isNewValid($data);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } 

        $cats = Cats::find($id);

        if ($cats) {
            $cats->title = Input::get('title');
            $cats->save();

            return Redirect::to('admin/cats')->withSuccess('# ' .$id. ' 更新成功!');
        } else {
            return Response::make('404 页面找不到', 404);
        }
    }

    /**
     * 分类删除接口
     * DELETE /cat/{id}
     *
     * @param $id int 分类id
     *
     * @return Response
     */
    public function destroy($id) 
    {
        if(Cat::destroy($id)) {
            // 分类删除后，分类标签也将删除相应的分类
            GameCatTags::destroy($id);

            return Redirect::to('admin/cats/index')->withSuccess('# ' .$id. ' 删除成功!'); 
        }

        return Response::make('404 页面找不到', 404);
    }

    /**
     * 分类预览接口
     * DELETE /cats/preview
     *
     * @return json 
     */
    public function preview() 
    {
        // 获取热门分类和游戏分类时数据
        $hotCats = Cats::hotCats();
        $gameCats = Cats::gameCats();
        $data = ['hotcats' => $hotCats, 'gamecats' => $gameCats];

        // return $this->result(['msg' => '数据返回成功', 'data'  => $data]);
    }

    // /**
    //  * 分类列表
    //  * GET /admin/cats
    //  *
    //  * @return Response
    //  */
    // public function index()
    // {
    //     $Cats = new Cats;
    //     $cats = $Cats->allcats();
    //     $catIds = [];
    //     foreach ($cats as $cat) {
    //         $catIds[] = $cat->id;
    //     }
    //     //为空的时候判断
    //     if (empty($catIds)){
    //         $catIds = [0];
    //     }
    //     $tags = $Cats->whereIn('parent_id', $catIds)->get();
    //     $catData = [];
    //     foreach ($cats as $index => $cat) {
    //         $catData[$cat->id]['data'] = $cat->toarray();
    //         $catData[$cat->id]['appcount'] = 0;
    //         $catData[$cat->id]['list'] = [];
    //     }
    //     foreach ($tags as $tag) {
    //         $catData[$tag->parent_id]['list'][] = $tag->toarray(); 
    //     }
    //     $appsCount = (new AppCats)->getCountByTagIds($catIds);
    //     foreach ($appsCount as $app) {
    //             $catData[$app->cat_id]['appcount'] = $app->app_count;
    //     }
    //     $datas = ['cats' => $catData, 'allcats' => $cats];
    //     $this->layout->content = View::make('admin.cats.index', $datas);
    // }
    
    // /**
    //  * 获得标签的列表
    //  * @method GET
    //  * @param  
    //  * @return Response
    //  */
    // public function tagIndex()
    // {
    //     $catModel = new Cats;
    //     $query = $catModel;
    //     if (Input::get('word')) {
    //         $words = ['%', Input::get('word'), '%'];
    //         $query = $catModel->where('title', 'like', join($words));
    //     }
    //     if (Input::get('parent_id')) {
    //         $query = $query->where('parent_id', '=', Input::get('parent_id'));
    //     } else {
    //         $query = $query->where('parent_id', '!=', 0);
    //     }
    //     $tags = $query->orderBy('id', 'desc')->paginate($this->pagesize);
    //     $cats = $catModel->allcats();
    //     $catsArr = [];
    //     foreach ($cats as $cat) {
    //         $catsArr[$cat->id] = $cat->title;
    //     }
    //     $datas = ['tags' => $tags, 'cats' => $catsArr,
    //     'cats1' => ['' => '所有分类'] + $catsArr];
    //     $this->layout->content = View::make('admin.cats.tagIndex', $datas);
    // }

    // /**
    //  * 添加分类
    //  * @method POST
    //  * @param string word
    //  * @return Response
    //  */
    // public function store()
    // {
    //     //检测输入
    //     $catModel = new Cats;
    //     $validator = Validator::make(Input::all(), $catModel->catsRules);
    //     if ($validator->fails()){
    //         Log::error($validator->messages());
    //         return Response::json(['status'=>'error', 'msg'=>'word is must need']);
    //     }
    //     //保存数据
    //     $catModel->title = Input::get('word');
    //     $catModel->save();
    //     //保存到分类库中
    //     $catAdsModel = new CatAds;
    //     $catAdsModel->cat_id = $catModel->id;
    //     $catAdsModel->title = $catModel->title;
    //     $catAdsModel->save();

    //     // 记录操作日志
    //     $logData['action_field'] = '系统管理-游戏分类管理';
    //     $logData['description'] = '新增了分类 分类ID为' . $catAdsModel->id;
    //     Base::dolog($logData);

    //     return Response::json(['status'=>'ok', 'msg'=>'suss']);
    // }
    // /**
    //  * 添加标签
    //  * @method POST
    //  * @param int parent_id
    //  * @param string word
    //  * @return Response
    //  */
    // public function tagStore()
    // {
    //     //检测输入
    //     Log::error(Input::all());
    //     $catModel = new Cats;
    //     $validator = Validator::make(Input::all(), $catModel->tagsCreateRules(Input::get('parent_id')));
    //     if ($validator->fails()){
    //         Log::error($validator->messages());
    //         return Response::json(['status'=>'error', 'msg'=>'标签重复了']);
    //     }
    //     //保存数据
    //     $catModel->title = Input::get('word');
    //     $catModel->parent_id = Input::get('parent_id');
    //     $catModel->save();

    //     // 记录操作日志
    //     $logData['action_field'] = '系统管理-游戏标签管理';
    //     $logData['description'] = '新增了标签 标签ID为' . $catModel->id;
    //     Base::dolog($logData);

    //     return Response::json(['status'=>'ok', 'msg'=>'suss']);
    // }

    // /**
    //  * 分类获得
    //  * @method GET
    //  * 
    //  * @param  int  $id
    //  * @return Response
    //  */
    // public function show($id)
    // {
    //     $catModel = new Cats;
    //     $cat = $catModel->where('id', $id)->where('parent_id', 0)->first();
    //     if (empty($cat)){
    //         return Response::json(['status'=>'error', 'msg'=>'id is valid']);
    //     }
        
    //     $tags = $catModel->where('parent_id', $cat->id)->get();
    //     $tagIds = [];
    //     $tagDatas = [];
    //     foreach ($tags as $tag) {
    //         $tagIds[] = $tag->id;
    //         $tagDatas[$tag->id]['data'] = $tag->toarray();
    //         $tagDatas[$tag->id]['count'] = 0;
    //         $tagDatas[$tag->id]['editurl'] = route('tag.edit', $tag->id);
    //         $tagDatas[$tag->id]['delurl'] = route('tag.delete', $tag->id);
    //     }
        
    //     //统计该标签游戏数量
    //     //空判断
    //     if (empty($tagIds)){
    //         $tagIds = [0];
    //     }
        
    //     $appsCount = (new AppCats)->getCountByTagIds($tagIds);
                     
    //     foreach ($appsCount as $app) {
    //         $tagDatas[$app->cat_id]['count'] = $app->app_count;
    //     }
        
    //     return Response::json(['status'=>'ok', 'msg'=>'suss', 'data'=>$tagDatas]);
    // }

    // /**
    //  * 更新分类
    //  * PUT /admin/cats/{id}
    //  *
    //  * @param  int  $id
    //  * @return Response
    //  */
    // public function update($id)
    // {
    //     //检测是否存在该数据
    //     $catModel = new Cats;
    //     $cat = Cats::find($id);
    //     if(!$cat){
    //         return Response::json(['status' => 'error', 'msg' => 'cat is valid']);   
    //     }
    //     //检测输入
    //     $validator = Validator::make(Input::all(), $catModel->tagsUpdateRules($id, $cat->parent_id));
    //     if ($validator->fails()){
    //         Log::error($validator->messages());
    //         return Response::json(['status'=>'error', 'msg'=>'标签重复了']);
    //     }
    //     //保存数据
    //     $cat->title = Input::get('word', $cat->title);
    //     $cat->sort = Input::get('sort', $cat->sort);
    //     $cat->save();

    //     // 记录操作日志
    //     if (Cats::find($id)->parent_id == 0) {
    //         $contentType = '分类';
    //     } else {
    //         $contentType = '标签';
    //     }
    //     $logData['action_field'] = '系统管理-游戏' . $contentType . '管理';
    //     $logData['description'] = '编辑了' . $contentType . ' ' . $contentType . 'ID为' . $cat->id;
    //     Base::dolog($logData);

    //     return Response::json(['status'=>'ok', 'msg'=>'suss']);
    // }

    // /**
    //  * 
    //  * 删除分类
    //  *
    //  * @param  int  $id
    //  * @return Response
    //  */
    // public function destroy($id)
    // {
    //     //检测是否存在该数据
    //     $catModel = new Cats;
    //     $cat = $catModel->find($id);
    //     if(!$cat){
    //         return Response::json(['status' => 'error', 'msg' => 'cat is valid']);   
    //     }

    //     //当删除的是分类的时候
    //     if ($cat->parent_id == 0){
    //         //属于所有的标签也删除
    //         $tags = $catModel->where('parent_id', $cat->id)->get();
    //         foreach ($tags as $tag) {
    //             $tag->delete();
    //         }
    //         //删除广告的分类
    //         $catAdsModel = new CatAds;
    //         $catAds = $catAdsModel->where('cat_id', $id)->first();
    //         isset($catAds) ? $catAds->delete() : '';
    //     }
    //     $cat->delete();

    //     // 记录操作日志
    //     $logData['action_field'] = '系统管理-游戏分类管理';
    //     $logData['description'] = '删除了分类 分类ID为' . $id;
    //     Base::dolog($logData);

    //     return Response::json(['status' => 'ok', 'msg' => 'suss']);
    // }
    
    // /**
    //  * 
    //  * 删除标签
    //  *
    //  * @param  int  $id
    //  * @return Response
    //  */
    // public function tagDestroy($id)
    // {
    //     //检测是否存在该数据
    //     $catModel = new Cats;
    //     $tag = $catModel->where('id', $id)->where('parent_id', '!=', 0)->first();
    //     if(!$tag){
    //         return Redirect::route('tag.index')->with('msg', 'error,tag #' . $id . ' is valid');  
    //     }
    //     $tag->delete();

    //     // 记录操作日志
    //     $logData['action_field'] = '系统管理-游戏标签管理';
    //     $logData['description'] = '删除了标签 标签ID为' . $id;
    //     Base::dolog($logData);

    //     return Redirect::route('tag.index')->with('msg', 'suss delete');
    // }
}