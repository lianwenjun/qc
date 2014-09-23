<?php

class Admin_KeywordsController extends \BaseController {

    protected $user_id = 1;
    protected $layout = 'admin.layout';
    protected $pagesize = 5;
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
        $ky = new Keywords;
        $where = $ky;
        if (Input::get('word')) {
            $query = ['%', Input::get('word'), '%'];
            $where = $ky->where('word', 'like', join($query));
        }
        //查询，默认分页
        $keywords = $where->orderBy('id', 'desc')->paginate($this->pagesize);
        $datas = ['keywords' => $keywords];
        $this->layout->content = View::make('admin.keywords.index', $datas);
    }

    /**
     * 新建一个新的关键词
     * @method POST 
     * @param string word
     * @return Response
     */
    public function store()
    {
        //检测输入
        Log::error(Input::all());
        $keyword = new Keywords;
        if ($keyword->validateCreate()->fails()){
            Log::error($keyword->validateCreate()->messages());
            return Response::json(['status'=>'error', 'msg'=>'word is must need']);
        }
        //保存数据
        $keyword->operator = $this->user_id;
        $keyword->creator = $this->user_id;
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
        $ky = new Keywords;
        $keyword = $ky->where('id', $id)->first();
        if(!$keyword){
            return Response::json(['status'=>'error', 'msg'=>'id is valid']);   
        }
        //检测输入
        if ($ky->validateUpate()->fails()){
            return Response::json(['status'=>'error', 'msg'=>'word is must need']);
        }
        //保存数据
        $keyword->operator = $this->user_id;
        $keyword->word = Input::get('word');
        $keyword->is_slide = Input::get('is_slide');
        $keyword->save();
        return Response::json(['status'=>'ok', 'msg'=>'suss']);
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
        $keyword = Keywords::where('id', $id)->first();
        if(!$keyword){
            return Redirect::action('Admin_KeywordsController@index')->with('msg', '#'. $id .'不存在');   
        }
        $keyword->operator = $this->user_id;
        $keyword->save();
        //两个动作放一起很怪异
        $keyword->delete();
        return Redirect::action('Admin_KeywordsController@index')->with('msg', '#'. $id .'删除成功');
    }
}