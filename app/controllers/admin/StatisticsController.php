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

    /**
     * 游戏下载页面选择日期导出csv文件
     *
     * @return Response
     */
    public function exportDownloads()
    {
        $dateArr   = Input::get('export_at');
        $startDate = $dateArr[0];
        $endDate   = date('Y-m-d', strtotime($dateArr[1])+86400);

        $tableName = 'download_tmp';

        DB::statement("drop table if exists `{$tableName}`");
        DB::statement("CREATE TABLE `{$tableName}` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `app_id` int(11) DEFAULT NULL,
            `title` varchar(200) DEFAULT NULL,
            `cats` varchar(200) DEFAULT NULL,
            `imei` varchar(200) DEFAULT NULL,
            `device` varchar(200) DEFAULT NULL,
            `status` varchar(20) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8");

        DB::connection('logs')->statement("insert into qc.{$tableName}
            select null, app_id, a.title, (select GROUP_CONCAT(title) from qc.cats
            where id in (select cat_id from qc.app_cats where app_id = log.app_id and parent_id = 0))
            as cats, ac.imei, ac.type, log.status, log.created_at from gZF7H as log
            left join qc.apps a on (a.id = `app_id`)
            left join qc.accounts ac on (ac.id = account_id)
            where log.created_at between '{$startDate}' and '{$endDate}'");

        $tmpData = DB::table($tableName)->get();
        $tmpData = CUtil::object2Array($tmpData);

        foreach ($tmpData as $key => $value) {
            str_replace('\\,', '|', $value['cats']);
        }

        Excel::create('下载统计', function($excel) use($tmpData)
        {
            $excel->sheet('sheet1', function($sheet) use($tmpData)
            {
                $sheet->fromArray($tmpData, null, 'A1', false, false);
            });
        })->export('csv');
    }
}