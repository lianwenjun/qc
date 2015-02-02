<?php

class Evolve_Game_ProcessController extends \Evolve_BaseController {

    /**
     * 待编辑列表
     * GET /evolve/game/process
     *
     * @return Response
     */
    public function drafts()
    {
        $GameProcess = new GameProcesses();
        $games = $GameProcess->whereIn('status', ['publish', 'draft'])->paginate($this->pageSize);

        // $cats    = new Cats;
        //$apps    = new ;
        $allCats = [];//$cats->allCats();
        // TODO 空提示

        return View::make('evolve.games.draft')
                   ->with('games', $games)
                   ->with('cats', $allCats);
    }

    /**
     * 待审核列表
     * GET /evolve/game/process
     *
     * @return Response
     */
    public function pendings()
    {
        $GameProcess = new GameProcesses();
        $games = $GameProcess->whereStatus('pending')->paginate($this->pageSize);

        // $cats    = new Cats;
        //$apps    = new ;
        $allCats = [];//$cats->allCats();
        // TODO 空提示

        return View::make('evolve.games.pending')
                   ->with('games', $games)
                   ->with('cats', $allCats);
    }

    /**
     * 审核不通过列表
     * GET /evolve/game/process
     *
     * @return Response
     */
    public function notpasses()
    {
        $GameProcess = new GameProcesses();
        $games = $GameProcess->whereStatus('notpass')->paginate($this->pageSize);

        // $cats    = new Cats;
        //$apps    = new ;
        $allCats = [];//$cats->allCats();
        // TODO 空提示

        return View::make('evolve.games.notpass')
                   ->with('games', $games)
                   ->with('cats', $allCats);
    }

    /**
     * 下架列表
     * GET /evolve/game/process
     *
     * @return Response
     */
    public function unstocks()
    {
        $GameProcess = new GameProcesses();
        $games = $GameProcess->whereStatus('unstock')->paginate($this->pageSize);

        // $cats    = new Cats;
        //$apps    = new ;
        $allCats = [];//$cats->allCats();
        // TODO 空提示

        return View::make('evolve.games.unstock')
                   ->with('games', $games)
                   ->with('cats', $allCats);
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
     * Show the form for editing the specified resource.
     * GET /evolve/game/process/{id}/edit
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
     * Remove the specified resource from storage.
     * DELETE /evolve/game/process/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}