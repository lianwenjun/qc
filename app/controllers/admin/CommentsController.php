<?php

class Admin_CommentsController extends \Admin_BaseController {

    /**
     * 游戏评论列表
     * GET /admin/comments
     *
     * @return Response
     */
    public function index()
    {
        $query = [];
        $comments = new Comments();
        $where = $comments;
        if (Input::get('cate') == 'title') {
            $query = ['%', Input::get('word'), '%'];
            $where = $comments->where('title', 'like', join($query));
        }
        if (Input::get('cate') == 'pack') {
            $query = ['%', Input::get('word'), '%'];
            $where = $comments->where('pack', 'like', join($query));
        }
        //查询，默认分页
        $datas = $where->orderBy('id', 'desc')->paginate($this->pagesize);
        $datas = ['comments' => $datas];
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
        $comments = new Comments();
        $comment = $comments->find($id);
        $res = ['status'=>'ok', 'msg'=>'suss'];
        if(!$comment){
            $res['msg'] = '#' . $id . ' is valid';
            $res['status'] = 'error';
            return Response::json($res);   
        }
        $validator = Validator::make(Input::all(), $comments->rules);
        if ($validator->fails()) {
            $res['msg'] = '验证失败';
            $res['status'] = 'error';
            return Response::json($res);
        }
        $comment->content = Input::get('content');
        if (!$comment->save()) {
            $res['msg'] = '保存失败';
            $res['status'] = 'error';
            return Response::json($res);
        }
        return Response::json($res);
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
        $comment = Comments::find($id);
        if(!$comment){
            return Redirect::route('comment.index')->with('msg', '#'. $id .'不存在');  
        }
        $comment->delete();
        return Redirect::route('comment.index')->with('msg', '#'. $id .'删除成功');
    }

}