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

        $list = $app_downloads->lists(Input::all())
                              ->paginate($this->pagesize)
                              ->toArray();

        $all_cats = (new Cats)->allCats();
        foreach ($all_cats as $key => $value) {
            $cats[$value->id] = $value->title;
        }

        return View::make('admin.statistics.appdownloads')
                   ->with('cats', $cats)
                   ->with('list', $list);
    }
}