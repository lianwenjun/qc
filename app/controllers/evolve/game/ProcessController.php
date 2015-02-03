<?php

class Evolve_Game_ProcessController extends \Evolve_BaseController {

    /**
     * 待编辑列表
     * GET /evolve/game/drafts
     *
     * @return Response
     */
    public function drafts()
    {
        $GameProcess = new GameProcesses();
        $games = $GameProcess->whereIn('status', ['publish', 'draft'])->paginate($this->pageSize);

        // $cats    = new Cats;
        //$apps    = new ;
        $cats = (new Cats)->selectForm();
        // TODO 空提示

        return View::make('evolve.games.draft')
                   ->with('games', $games)
                   ->with('cats', $cats);
    }

    /**
     * 待审核列表
     * GET /evolve/game/pendings
     *
     * @return Response
     */
    public function pendings()
    {
        $GameProcess = new GameProcesses();
        $games = $GameProcess->whereStatus('pending')->paginate($this->pageSize);

        // $cats    = new Cats;
        //$apps    = new ;
        $cats = (new Cats)->selectForm();
        // TODO 空提示

        return View::make('evolve.games.pending')
                   ->with('games', $games)
                   ->with('cats', $cats);
    }

    /**
     * 审核不通过列表
     * GET /evolve/game/notpasses
     *
     * @return Response
     */
    public function notpasses()
    {
        $GameProcess = new GameProcesses();
        $games = $GameProcess->whereStatus('notpass')->paginate($this->pageSize);

        // $cats    = new Cats;
        //$apps    = new ;
        $cats = (new Cats)->selectForm();
        // TODO 空提示

        return View::make('evolve.games.notpass')
                   ->with('games', $games)
                   ->with('cats', $cats);
    }

    /**
     * 下架列表
     * GET /evolve/game/unstocks
     *
     * @return Response
     */
    public function unstocks()
    {
        $GameProcess = new GameProcesses();
        $games = $GameProcess->whereStatus('unstock')->paginate($this->pageSize);

        // $cats    = new Cats;
        //$apps    = new ;
        $cats = (new Cats)->selectForm();
        
        return View::make('evolve.games.unstock')
                   ->with('games', $games)
                   ->with('cats', $cats);
    }

    /**
     * 
     * GET /evolve/game/process/create
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * 
     * POST /evolve/game/process
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     * GET /evolve/game/process/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 打开编辑页
     * GET /evolve/game/process/{id}/edit
     *
     * @param $type string 过程类型
     * @param $id int 游戏ID
     *
     * @return Response
     */
    public function edit($type, $id)
    {
        $game = GameProcesses::whereStatus($type)->find($id);
        if (! $game) {
            return App::abort(404);
        }
        $cats = (new Cats)->selectForm();
        $vendors = [];

        return View::make('evolve.games.edit')
            ->with('game', $game)
            ->with('cats', $cats)
            ->with('vendors', $vendors);
    }

    /**
     * Update the specified resource in storage.
     * PUT /evolve/game/process/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * 删除游戏处理过程的数据
     * DELETE /evolve/game/process/{id}
     *
     * @param  $type string 游戏类型[仅限于draft,notpasses]
     * @param  $id int 游戏ID
     *
     * @return Response
     */
    public function destroy($type, $id)
    {         
        GameProcesses::whereStatus($type)->whereId($id)->delete();
        
        return Redirect::back()->withSuccess('删除#' . $id . '成功');
    }

    /**
     * 游戏预览
     * GET /evolve/game/stock/{id}/preview
     *
     * @return Response
     */
    public function preview($id)
    {
        
        $game = GameProcesses::find($id);
        if (! $game) {
            return ['success' => false, 'msg' => '未找到游戏'];
        }
        
        $data = ['title', 'icon', 'version', 'review'];
        $info = [];
        foreach ($data as $key) {
            $info[$key] = $game->$key;
        }
        $info['updated_at'] = $game->updated_at->format('Y/m/d');
        $info['screenshots'] = unserialize($game->screenshots);
        $info['size'] = Helper::friendlySize($game->size);
        $info['cat'] = '';
        
        $sameAuthor = (new GameProcesses)->sameAuthor($game->author);
        $sameCat = [];
        
        return [
                'success' => true,
                'data' => [
                    'info' => $info,
                    'same_author_games' => $sameAuthor,
                    'same_cat_games' => $sameCat
                ],
                'msg' => '返回成功'
        ];
    }

    /**
     * 审核通过
     * PUT /game/pendings/{id}/pass
     *
     * @param $id int 游戏ID
     * 
     * @return Response
     */
    public function pass($id)
    {
        $game = GameProcesses::whereStatus('pending')->find($id);
        if (! $game) {
            return App::abort(404);
        }
        
        // 审核通过的数据直接放置到上架列表中，然后把本地的数据删除掉，同时放置到历史表和版本表中
        (new GameStocks)->add($game, $this->userId, $this->username);
        //(new GameHistories)->add($game, $this->userId, $this->username);
        //(new GameVersions)->add($game, $this->userId, $this->username);
        $game->delete();
        
        return Redirect::back()->withSuccess('#' . $id . '审核通过');
    }

    /**
     * 审核不通过
     * PUT /game/pendings/{id}/notpass
     *
     * @param $id int 游戏ID
     * 
     * @return Response
     */
    public function notpass($id)
    {
        $game = GameProcesses::whereStatus('pending')->find($id);
        if (! $game) {
            return App::abort(404);
        }
        // 更新原因和操作人
        $game->reason = Input::get('reason');
        $game->status = 'notpass';
        $game->operator = $this->username;
        $game->operator_id = $this->userId;
        $game->save();
        
        return Redirect::back()->withSuccess('#' . $id . '审核不通过');
    }


    /**
     * 上传游戏APK
     * POST /admin/game/appupload
     *
     * @param $id int 游戏ID
     *
     * @return Response
     */
    public function apk()
    {
        $uploader = (new CUpload)->instance('app', 'apks')->upload();

        if(!$uploader['result']) return $uploader;

        

        return $app->uploader($id);
    }
    
    /**
     * 上传游戏图片
     * POST /admin/game/screenshot
     *
     * @return Response
     */
    public function screenshot()
    {
        return (new CUpload)->instance('image', 'pictures')->upload();
    }

    /**
     * 上传游戏icon图片
     * POST /admin/game/icon
     *
     * @return Response
     */
    public function icon()
    {
        return (new CUpload)->instance('image', 'icons')->upload();
    }
}