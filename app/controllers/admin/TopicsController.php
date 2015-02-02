<?php

class Admin_TopicsController extends \Admin_BaseController {
    
    /**
     * 专题待发布编辑管理列表
     * GET /admin/topics/{type}
     *
     * @param type string
     *
     * @return Response
     */
    public function index($type)
    {
        $ofStatus = Input::get('status');
        $title = Input::get('title');
        $datas = Topics::lists($this->pagesize, $type, $ofStatus, $title);
        $statusLang = Config::get('status.ads.topicsStatus');

        if ($type == 'dptopics')
            return view::make('evolve.topics.dptopics')
               ->withDatas($datas)
               ->with('statusLang', $statusLang);
               
        if ($type == 'sutopics')
            return view::make('evolve.topics.sutopics')
               ->withDatas($datas)
               ->with('statusLang', $statusLang);
    }

    /**
     * 专题新增页
     * GET /admin/topics/dptopics/create
     *
     * @return Response
     */
    public function create()
    {
        return view::make('evolve.topics.create');
    }

    /**
     * 专题新增入库.
     * POST /admin/topics
     *
     * @return Response
     */
    public function store()
    {
        $data = Input::only(
            'title', 
            'game_id',
            'summary', 
            'image', 
            'location',
            'stocked_at',
            'unstocked_at',
            'status'
        );

        // 判断是否不存在status提交
        if (! Input::has('status')) {
            $validator = Topics::isNewValid($data);

            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            }
            
            // 当前时间戳
            $time = time();
            $stockTime = strtotime(Input::get('stocked_at'));
            $unstockTime = strtotime(Input::get('unstocked_at'));

            if ($stockTime < $time && $time < $unstockTime) {
                $data['status'] = 'stock';
            } else if ($stockTime > $time) {
                $data['status'] = 'pending';
            } else if ($unstockTime < $time) {
                $data['status'] = 'unstock';
            }

            if (Topics::create($data)) {
                switch ($data['status']) {
                    case 'pending':
                        return Redirect::to(URL::route('topics.index', 'dptopics'))
                            ->withSuccess('添加成功！');
                        break;
                
                    default:
                        return Redirect::to(URL::route('topics.index', 'sutopics'))
                            ->withSuccess('添加成功！');
                        break;
                }
            }

            return Response::make('404 页面找不到', 404);
        } 
        // 存为草稿
        if (Topics::create($data)) {
            return Redirect::to(URL::route('topics.index', 'dptopics'))
               ->withSuccess('存为草稿成功！');
        }
        
        return Response::make('404 页面找不到', 404);
    }

    /**
     * 专题编辑
     * GET /admin/topics/{type}/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $inStatus = ['draft', 'pending', 'stock'];
        $topic = Topics::InStatus($inStatus)->find($id);

        if ($topic) {
            // 获取游戏信息
            $ids[] = explode(',', $topic->game_id);
            $apps = [];

            foreach ($ids as $id) {
                $apps = Apps::find($id);
            }

            return view::make('evolve.topics.edit')->withTopic($topic)
                                                   ->withApps($apps);
        }

        return Response::make('404 页面找不到', 404);
    }

    /**
     * 专题更新
     * PUT /admin/topics/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        $data = Input::only(
            'title', 
            'game_id',
            'summary', 
            'image', 
            'location',
            'stocked_at',
            'unstocked_at',
            'status'
        );

        if (! Input::has('status')) {
            $validator = Topics::isNewValid($data);

            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            }
            
            // 当前时间戳
            $time = time();
            $stockTime = strtotime(Input::get('stocked_at'));
            $unstockTime = strtotime(Input::get('unstocked_at'));

            if ($stockTime < $time && $time < $unstockTime) {
                $data['status'] = 'stock';
            } else if ($stockTime > $time) {
                $data['status'] = 'pending';
            } else if ($unstockTime < $time) {
                $data['status'] = 'unstock';
            }

            if (Topics::where('id', $id)->update($data)) {
                switch ($data['status']) {
                    case 'pending':
                        return Redirect::to(URL::route('topics.index', 'dptopics'))
                            ->withSuccess('添加成功！');
                        break;
                
                    default:
                        return Redirect::to(URL::route('topics.index', 'sutopics'))
                            ->withSuccess('添加成功！');
                        break;
                }
            }

            return Response::make('404 页面找不到', 404);
        } 

        // 存为草稿
        if (Topics::where('id', $id)->update($data)) {
            return Redirect::to(URL::route('topics.index', 'dptopics'))
               ->withSuccess('#'.$id.' 存为草稿！');
        }

        return Response::make('404 页面找不到', 404);
    }

    /**
     * 撤销待发布状态
     * PUT /admin/topics/revocate
     *
     * @param $id int
     *
     * @return Response
     */
    public function revocate($id)
    {
        $inStatus = ['draft', 'pending'];

        $topic = Topics::where('id', $id)->InStatus($inStatus)
                                         ->update('status', 'draft');

        if ($topic) {
            return Redirect::to(URL::route('topics.index', 'dptopics'))
               ->withSuccess('#'. $id .' 撤销为编辑状态！');
        }

        return Response::make('404 页面找不到', 404);
    }

    /**
     * 专题删除
     * DELETE /admin/topics/{type}/{id}
     *
     * @param $type string 状态类型 ,$id int 分类id
     *
     * @return Response
     */
    public function destroy($type, $id) 
    {
        $inStatus = ['draft', 'pending', 'unstock'];
        $topic = Topics::where('id', $id)->InStatus($inStatus)
                                         ->delete();

        if ($topic) {
            return Redirect::to('admin/topics/'. $type)
                ->withSuccess('# '. $id .' 删除成功!'); 
        }

        return Response::make('404 页面找不到', 404);
    }

    /**
     * 查看单个待发布&编辑中专题详情信息
     * GET /admin/topics/dptopics/{id}
     *
     * @param $type string 状态类型 ,$id int 分类id
     *
     * @return Response
     */
    public function show($id) 
    {
        $inStatus = ['draft', 'pending'];
        $topic = Topics::InStatus($inStatus)->find($id);

        if ($topic) {
            // 获取游戏信息
            $ids[] = explode(',', $topic->game_id);
            $apps = [];

            foreach ($ids as $id) {
                $apps = Apps::find($id);
            }

            return view::make('evolve.topics.topicinfo')->withTopic($topic)
                                                        ->withApps($apps);

        }

        return Response::make('404 页面找不到', 404);
    }

    /**
     * 下架
     * PUT /admin/topics/{id}/unstock
     *
     * @param $id int 分类id
     *
     * @return Response
     */
    public function unstock($id) 
    {
        $inStatus = ['stock'];
        $topic = Topics::InStatus($inStatus)->find($id);

        if ($topic) {
            return Redirect::to(URL::route('topics.index', 'sutopics'))
                ->withSuccess('# '. $id .' 下架成功!'); 
        }

        return Response::make('404 页面找不到', 404);
    }

}