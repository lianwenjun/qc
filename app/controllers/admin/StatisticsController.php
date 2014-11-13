<?php

/**
 * 数据统计模块控制器
 *
 */
class Admin_StatisticsController extends Admin_BaseController
{
    /**
     * 游戏下载统计页面
     *
     * @return Response
     */
    public function appDownloads()
    {
        $app_downloads = new AppDownloads();

        $list = $app_downloads->lists(Input::all(), $this->pagesize);

        return View::make('admin.statistics.appdownloads')
                   ->with('cats', (new Cats)->allCats())
                   ->with('list', $list);
    }
}