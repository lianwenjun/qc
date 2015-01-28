<?php

class Admin_System_GameCatTagsController extends \Admin_BaseController {
    
    /**
     * 游戏分类标签首页
     * GET /gamescattags
     *
     * @return Response
     */
    public function index()
    {
        // 分类下拉列表数据
        $allCats = Cats::allCats();
        $cats = ['' => '所属游戏分类'];

        foreach ($allCats as $cat) {
            $cats[$cat->id] = $cat->title;
        }

        // 标签列表数据
        $allTags = Tags::allTags();
        $tags = [];

        foreach ($allTags as $tag) {
            $tags[$tag->id] = $tag->title;
        }

        // 分类标签列表数据
        $catTags = GameCatTags::lists($this->pageSize);
        $view = view::make('evolve.cat.gamecattags');
        
        return $view->with('cats', $cats)
                    ->with('tags', $tags)
                    ->with('catTags', $catTags);
    }

    /**
     * 游戏分类标签添加
     * POST /gamescattags
     *
     * @return Response
     */
    public function store()
    {
        $data = Input::all();
        $validator = GameCatTags::isNewValid($data);

        if ($validator->fails()) {
            return Redirect::to('admin/gamecattags')->withErrors($validator);
        } else {
            $gamecattags = new GameCatTags();
            
            // 判断标签是否在标签库中存在，若不存在则在标签库中创建一条并返回tag_id;
            if (! Input::has('tagid')) {
                $tag = Tags::create($data);
                $gamecattags->tag_id = $tag->id;
            }

            $gamecattags->tag_id = Input::get('tagid');
            $gamecattags->cat_id = Input::get('catid');
            $gamecattags->save();

            return Redirect::to('admin/gamecattags')->withSuccess('添加成功!');
        }
    }

    /**
     * 游戏分类标签删除
     * DELETE /gamescattags/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $data = GameCatTags::find($id);
        if ($data) {
            $data->delete();
            return Redirect::to('admin/gamecattags')->withSuccess('# ' . $id . ' 删除成功!');
        } else {
            return Response::make('404 页面找不到', 404);
        }
    }

}