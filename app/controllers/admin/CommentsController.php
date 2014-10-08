<?php

class Admin_CommentsController extends \BaseController {
    protected $user_id = 1;
    protected $layout = 'admin.layout';
    protected $pagesize = 5;
    /**
     * 游戏评论列表
     * GET /admin/comments
     *
     * @return Response
     */
    public function index()
    {
        $query = [];
        $commentModel = new Comments();
        $where = $commentModel;
        if (Input::get('title')) {
            $query = ['%', Input::get('title'), '%'];
            $where = $ky->where('title', 'like', join($query));
        }
        if (Input::get('pack')) {
            $query = ['%', Input::get('pack'), '%'];
            $where = $ky->where('pack', 'like', join($query));
        }
        //查询，默认分页
        $comments = $where->orderBy('id', 'desc')->paginate($this->pagesize);
        $datas = ['comments' => $comments];
        $this->layout->content = View::make('admin.comments.index', $datas);
    }

    /**
     * 修改评论内容
     * PUT /admin/comments/{id}
     *
     * @param  int  $id
     * @param  string content
     * @return Response
     */
    public function update($id)
    {
        //检测是否存在该数据
        $commentModel = new Comments();
        $comment = $commentModel->find($id);
        if(!$comment){
            return Redirect::back()->with('msg', '#'. $id .'不存在');   
        }
        $validator = '';
        if ($validator->fails()) {
            //
            return Redirect::back()->with('数据格式不对');
        }
        $comment->content = Input::get('content');
        if ($comment->save()) {
            //返回当前页面
            return Redirect::back()->with('数据格式不对');
        }
        return [];
    }

    /**
     * 删除评论
     * DELETE /admin/comments/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //检测是否存在该数据
        $commentModel = new Comments();
        $comment = $commentModel->find($id);
        if(!$comment){
            return Redirect::back()->with('msg', '#'. $id .'不存在');   
        }
        $comment->delete();
        return Redirect::back()->with('msg', '#'. $id .'删除成功');
    }

}