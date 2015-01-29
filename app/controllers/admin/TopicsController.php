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
			return view::make('evolve.ads.dptopics')
					   ->withDatas($datas)
					   ->with('statusLang', $statusLang);

		if ($type == 'sutopics')
			return view::make('evolve.ads.sutopics')
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
		return view::make('evolve.ads.create');
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
			return Register::to('admin/topics/dptopics')
						   ->withSuccess('#'. $id .' 以撤销为编辑状态！');
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

        if($topic) {

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

		if($topic) {
			// 获取游戏信息
			$ids[] = explode(',', $topic->game_id);
			$apps = [];

			foreach ($ids as $id) {
				$apps = Apps::find($id);
			}

			return view::make('evolve.ads.topicinfo')->withTopic($topic)
													 ->withApps($apps);

        }

        return Response::make('404 页面找不到', 404);
    }

	

	/**
	 * Store a newly created resource in storage.
	 * POST /admin/topics
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /admin/topics/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /admin/topics/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


}