<?php

class Admin_RatingsController extends \BaseController {
    protected $user_id = 1;
    protected $layout = 'admin.layout';
    protected $pagesize = 5;
    /**
     * 游戏评分列表
     * GET /admin/ratings
     *
     * @return Response
     */
    public function index()
    {
        $query = [];
        $ratingModel = new Ratings();
        $where = $ratingModel;
        if (Input::get('title')) {
            $query = ['%', Input::get('title'), '%'];
            $where = $ky->where('title', 'like', join($query));
        }
        if (Input::get('pack')) {
            $query = ['%', Input::get('pack'), '%'];
            $where = $ky->where('pack', 'like', join($query));
        }
        //查询，默认分页
        $ratings = $where->orderBy('id', 'desc')->paginate($this->pagesize);
        $datas = ['ratings' => $ratings];
        $this->layout->content = View::make('admin.ratings.index', $datas);
    }

    /**
     * 更新游戏评分列表
     * PUT /admin/ratings/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //检测是否存在该数据
        $ratingModel = new Ratings();
        $rating = $ratingModel->find($id);
        if(!$rating){
            return Redirect::back()->with('msg', '#'. $id .'不存在');   
        }
        $validator = '';
        if ($validator->fails()) {
            //
            return Redirect::back()->with('数据格式不对');
        }
        $rating->manual = Input::get('manual');
        if ($rating->save()) {
            //返回当前页面
            return Redirect::back()->with('修改成功');
        }
        return ['修改失败'];
    }
}