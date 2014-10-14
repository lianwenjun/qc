<?php

class Admin_RatingsController extends \Admin_BaseController {
    
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
        if (Input::get('cate') == 'title') {
            $query = ['%', Input::get('word'), '%'];
            $where = $ratingModel->where('title', 'like', join($query));
        }
        if (Input::get('cate' == 'pack')) {
            $query = ['%', Input::get('word'), '%'];
            $where = $ratingModel->where('pack', 'like', join($query));
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
        $res = ['status'=>'ok', 'msg'=>'suss'];
        if(!$rating){
            $res['msg'] = '#' . $id . ' is valid';
            $res['status'] = 'error';
            return Response::json($res);   
        }
        $validator = Validator::make(Input::all(), $ratingModel->rules);
        if ($validator->fails()) {
            $res['msg'] = '#' . $id . ' data is wrong';
            $res['status'] = 'error';
            return Response::json($res); 
        }
        $rating->manual = Input::get('manual');
        if (!$rating->save()) {
            $res['msg'] = '保存失败';
            $res['status'] = 'error';
            return Response::json($res);
        }
        return Response::json($res);
    }
}