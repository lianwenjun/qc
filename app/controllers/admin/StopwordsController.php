<?php

class Admin_StopwordsController extends \Admin_BaseController {

    /**
     * 屏蔽词列表
     * GET /admin/stopwords
     *
     * @return Response
     */
    public function index()
    {
        $stopwords = Stopwords::orderBy('id', 'desc')->paginate($this->pagesize);
        $userDatas = (new User)->getUserNameByList(['creator', 'operator'], $stopwords);
        $datas = ['stopwords' => $stopwords, 'userDatas' => $userDatas];
        $this->layout->content = View::make('admin.stopwords.index', $datas);
    }


    /**
     * 添加屏蔽词
     * POST /admin/stopwords
     * @param word
     * @return Response
     */
    public function store()
    {
        $stopwords = new Stopwords;
        $res = ['status'=>'ok', 'msg'=>'suss'];
        //检测输入
        $validator = Validator::make(Input::all(), $stopwords->rules, $stopwords->messages);
        if ($validator->fails()){
            $res['msg'] = $validator->messages()->first('word');
            $res['status'] = 'error';
            return Response::json($res);
        }
        //保存输入
        $stopwords->word = Input::get('word');
        $stopwords->creator = $this->userId;
        $stopwords->operator = $this->userId;
        //入库失败
        if (!$stopwords->save()) {
            $res['msg'] = '保存失败';
            $res['status'] = 'error';
            return Response::json($res);
        }

        // 记录操作日志
        $logData['action_field'] = '系统管理-屏蔽词管理';
        $logData['description'] = '新增了屏蔽词 屏蔽词ID为' . $stopwords->id;
        Base::dolog($logData);

        return Response::json($res);
    }

    /**
     * 更新屏蔽词
     * POST /admin/stopwords/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //检测是否存在该数据
        $stopwordModel = new Stopwords();
        $res = ['status'=>'ok', 'msg'=>'suss'];
        $stopword = Stopwords::find($id);
        if(!$stopword){
            $res['status'] = 'error';
            $res['msg'] = '#' . $id . '未找到';
            return Response::json($res);;   
        }
        //检测输入
        $validator = Validator::make(
                    Input::all(), 
                    $stopwordModel->updateRules($id), 
                    $stopwordModel->messages
                );
        if ($validator->fails()){
            $res['msg'] = $validator->messages()->first('word');
            $res['status'] = 'error';
            return Response::json($res);
        }
        //保存输入
        $stopword->word = Input::get('word', $stopword->word);
        $stopword->to_word = Input::get('to_word', '***');
        $stopword->operator = $this->userId;
        //入库失败
        if (!$stopword->save()) {
            $res['msg'] = '修改失败';
            $res['status'] = 'error';
            return Response::json($res);
        }

        // 记录操作日志
        $logData['action_field'] = '系统管理-屏蔽词管理';
        $logData['description'] = '编辑了屏蔽词 屏蔽词ID为' . $id;
        Base::dolog($logData);

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
        $stopword = Stopwords::find($id);
        if(!$stopword){
            return Redirect::route('stopword.index')->with('msg', '#'. $id .'不存在');   
        }
        $stopword->operator = $this->userId;
        $stopword->save();
        //两个动作放一起很怪异
        $stopword->delete();

        // 记录操作日志
        $logData['action_field'] = '系统管理-屏蔽词管理';
        $logData['description'] = '删除了屏蔽词 屏蔽词ID为' . $id;
        Base::dolog($logData);
        
        return Redirect::route('stopword.index')->with('msg', '#'. $id .'删除成功');
    }

}