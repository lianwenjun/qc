<?php

class Admin_StopwordsController extends \BaseController {

    protected $user_id = 1;
    protected $layout = 'admin.layout';
    protected $pagesize = 5;
    /**
     * 屏蔽词列表
     * GET /admin/stopwords
     *
     * @return Response
     */
    public function index()
    {
        $stopwordModel = new Stopwords;
        $stopwords = $stopwordModel->orderBy('id', 'desc')->paginate($this->pagesize);
        $datas = ['stopwords' => $stopwords];
        $this->layout->content = View::make('admin.stopwords.index', $datas);
    }


    /**
     * Store a newly created resource in storage.
     * POST /admin/stopwords
     *
     * @return Response
     */
    public function store()
    {
        $stopwordModel = new Stopwords;
        $res = ['status'=>'ok', 'msg'=>'suss'];
        //检测输入
        $validator = Validator::make(Input::all(), $stopwordModel->createRules);
        if ($validator->fails()){
            $res['msg'] = '验证失败';
            $res['status'] = 'error';
            return Response::json($res);
        }
        //保存输入
        $stopwordModel->word = Input::get('word');
        $stopwordModel->creator = $this->user_id;
        $stopwordModel->operator = $this->user_id;
        //入库失败
        if (!$stopwordModel->save()) {
            $res['msg'] = '保存失败';
            $res['status'] = 'error';
            return Response::json($res);
        }
        return Response::json($res);
    }

    /**
     * Update the specified resource in storage.
     * PUT /admin/stopwords/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //检测是否存在该数据
        $stopwordModel = new Stopwords();
        $res = ['status'=>'ok', 'msg'=>'suss'];
        $stopword = $stopwordModel->find($id);
        if(!$stopword){
            $res['status'] = 'error';
            $res['msg'] = '#' . $id . '未找到';
            return Response::json($res);;   
        }
        //检测输入
        $validator = Validator::make(Input::all(), $stopwordModel->createRules);
        if ($validator->fails()){
            Log::error($validator->messages());
            $res['msg'] = '验证失败';
            $res['status'] = 'error';
            return Response::json($res);
        }
        //保存输入
        $stopword->word = Input::get('word', $stopword->word);
        $stopword->to_word = Input::get('to_word', '***');
        $stopword->operator = $this->user_id;
        //入库失败
        if (!$stopword->save()) {
            $res['msg'] = '修改失败';
            $res['status'] = 'error';
            return Response::json($res);
        }
        return Response::json($res);
    }

    /**
     * 屏蔽词的删除
     * DELETE /admin/stopwords/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //检测是否存在该数据
        $stopwordModel = new Stopwords();
        $stopword = $stopwordModel->find($id);
        if(!$stopword){
            return Redirect::route('stopword.index')->with('msg', '#'. $id .'不存在');   
        }
        $stopword->operator = $this->user_id;
        $stopword->save();
        //两个动作放一起很怪异
        $stopword->delete();
        return Redirect::route('stopword.index')->with('msg', '#'. $id .'删除成功');
    }

}