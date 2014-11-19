<?php

class Admin_LogController extends \Admin_BaseController {

    /**
     * 日志查询页面
     * GET /admin/log
     *
     * @return Response
     */
    public function index()
    {
        $logs = new Logs();
        $lists = $logs->lists(Input::all())
                           ->orderBy('created_at', 'desc')
                           ->paginate($this->pagesize);

        return View::make('admin.log.index')->with('lists', $lists);
    }

}