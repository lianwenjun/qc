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
        $comments = new Comments();
        switch (Input::get('cate')) {
            case 'title':
                $query = Comments::OfTitle(Input::get('word'));
                break;
            case 'pack':
                $query = Comments::OfPack(Input::get('word'));
                break;
            default:
                $query = new Comments;
                break;
        }
        //查询，默认分页
        $datas = $query->orderBy('id', 'desc')->paginate($this->pagesize);
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
        if(!$comment) {
            return Response::json(['status'=>'error', 'msg'=>'#' . $id . ' is valid']);   
        }
        $validator = Validator::make(Input::all(), $comments->rules);
        if ($validator->fails()) {
            return Response::json(['status'=>'error', 'msg'=>'验证失败']);
        }
        $comment->content = Input::get('content');
        if (!$comment->save()) {
            return Response::json(['status'=>'error', 'msg'=>'保存失败']);
        }
        return Response::json(['status'=>'ok', 'msg'=>'suss']);
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