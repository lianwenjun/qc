<?php

class Admin_KeywordsController extends \Admin_BaseController {
    /**
     * 
     * 获得关键字的列表
     * @method GET
     * @param string word
     * @param int page
     * @return Response
     */
    public function index()
    {  
        if (Input::get('word')) {
            $query = ['%', Input::get('word'), '%'];
            $where = Keywords::where('word', 'like', join($query));
        }else {
            $where = new Keywords;
        }
        //查询，默认分页
        $keywords = $where->orderBy('id', 'desc')->paginate($this->pagesize);
        $userDatas = (new User)->getUserNameByList(['creator', 'operator'], $keywords);
        $datas = ['keywords' => $keywords, 'userDatas' => $userDatas];
        $this->layout->content = View::make('admin.keywords.index', $datas);
    }

    /**
     * 添加新的关键词
     * @method POST 
     * @param string word
     * @return Response
     */
    public function store()
    {
        //检测输入
        $keyword = new Keywords;
        if ($keyword->validateCreate()->fails()){
            Log::error($keyword->validateCreate()->messages());
            return Response::json(['status'=>'error', 'msg'=>'word is must need']);
        }
        //保存数据
        $keyword->operator = $this->userId;
        $keyword->creator = $this->userId;
        $keyword->word = Input::get('word');
        $keyword->save();
        return Response::json(['status'=>'ok', 'msg'=>'suss']);
    }
    
    /**
     * 更新关键词
     * 
     * @method POST
     * @param  int  $id
     * @param  string word 
     * @param  string is_slide
     * @return Response
     */
    public function update($id)
    {
        //检测该数据是否存在
        $kw = new Keywords;
        $keyword = Keywords::find($id);
        if(!$keyword){
            return Response::json(['status'=>'error', 'msg'=>'id is valid']);   
        }
        //检测输入
        if ($kw->validateUpate($id)->fails()){
            return Response::json(['status'=>'error', 'msg'=>'关键字重复了']);
        }
        //保存数据
        $keyword->operator = $this->userId;
        $keyword->word = Input::get('word', $keyword->word);
        $keyword->is_slide = Input::get('is_slide', $keyword->is_slide);
        $keyword->save();
        $data['operator'] = User::find($this->userId)->username;
        $data['updated_at'] = date($keyword->updated_at);
        return Response::json(['status'=>'ok', 'msg'=>'suss', 'data'=>$data]);
    }

    /**
     * 删除关键词（假删除）
     * @method GET
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //检测是否存在该数据
        $keyword = Keywords::find($id);
        if(!$keyword){
            return Redirect::route('keyword.index')->with('msg', '#'. $id .'不存在');   
        }
        $keyword->operator = $this->userId;
        $keyword->save();
        //两个动作放一起很怪异
        $keyword->delete();
        return Redirect::action('keyword.index')->with('msg', '#'. $id .'删除成功');
    }
}