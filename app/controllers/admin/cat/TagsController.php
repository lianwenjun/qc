<?php

class Admin_Cat_TagsController extends \Admin_BaseController {

	/**
     * 标签库首页
     * GET /tags
     *
     * @return Response
     */
    public function index()
    {
        $tags = Tags::lists($this->pageSize);

        return view::make('evolve.system.tags')->with('tags', $tags);
    }

    /**
     * 标签添加
     * POST /tags
     *
     * @return Response
     */
    public function store()
    {
        $data = Input::all();
        $validator = Tags::isNewValid($data);

        if ($validator->fails()) {
            return Redirect::to('admin/tag/index')->withErrors($validator);
        } else {
            Tags::create($data);

            return Redirect::to('admin/tag/index')->withSuccess('添加成功!');
        }
    }

    /**
     * 标签排名修改
     * PUT /tags/{id}
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function update($id)
    {   
        $data = Input::all();
        $validator = Tags::isNewValid($data, $id);

        if ($validator->fails()) {
            return Redirect::to('admin/tag/index')->withErrors($validator);
        } else {
            if (Tags::where('id', $id)->update($data)) {
                return Redirect::to('admin/tag/index')->withSuccess('# ' . $id .' 更新成功!');
            } else {
                return Response::make('404 页面找不到', 404);
            } 
        }
    }

    /**
     * 标签删除
     * DELETE /tags/{id}
     *
     * @param  int  $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if(Tags::where('id', $id)->delete()) {
            //标签删除后，分类标签也将删除相应的标签
            GameCatTags::where('tag_id', $id)->delete();

            return Redirect::to('admin/tag/index')->withSuccess('# ' . $id . ' 删除成功!');
        } else {
            return Response::make('404 页面找不到', 404);
        }
    }

}