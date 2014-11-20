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
        $cate = Input::get('cate');
        switch ($cate) {
            case 'title':
                $query = Ratings::ofTitle(Input::get('word'));
                break;
            case 'pack':
                $query = Ratings::ofPack(Input::get('word'));
                break;
            default:
                $query = new Ratings;
                break;
        }
        //查询，默认分页
        $ratings = $query->orderBy('id', 'desc')->paginate($this->pagesize);
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
        $rating = Ratings::find($id);
        $res = ['status'=>'ok', 'msg'=>'suss'];
        if(!$rating){
            $res['msg'] = '#' . $id . ' is valid';
            $res['status'] = 'error';
            return Response::json($res);   
        }
        $valid = (new Ratings)->isValid(Input::all());
        if (!$valid) {
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

        // 记录操作日志
        $logData['action_field'] = '评论管理-游戏评分列表';
        $logData['description'] = '编辑了评分 评分ID为' . $id;
        Base::dolog($logData);

        return Response::json($res);
    }
}