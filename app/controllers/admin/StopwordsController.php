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
        //
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
        //
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
        $stopword = $keywordModel->find($id);
        if(!$stopword){
            return Redirect::action('Admin_KeywordsController@index')->with('msg', '#'. $id .'不存在');   
        }
        $stopword->operator = $this->user_id;
        $stopword->save();
        //两个动作放一起很怪异
        $stopword->delete();
        return Redirect::action('Admin_KeywordsController@index')->with('msg', '#'. $id .'删除成功');
    }

}