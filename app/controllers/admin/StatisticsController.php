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
        // 重新组装分类id对应分类名称的数据格式
        $all_cats = (new Cats)->allCats();
        foreach ($all_cats as $key => $value) {
            $cats[$value->id] = $value->title;
        }
        // 查询游戏的所有分类并组装成字符串显示
        foreach ($list['data'] as $key => $value) {
            $cat_info = (new Cats)->appCats($value['app_id']);
            $list['data'][$key]['cat'] = implode('/', array_column($cat_info, 'title'));
        }

        return View::make('admin.statistics.appdownloads')
                   ->with('cats', $cats)
                   ->with('list', $list);
    }
}