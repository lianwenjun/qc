<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * 数据汇总计划任务
 *
 */
class Statistics extends Command
{
    /**
     * 命令名称
     *
     * @var string
     */
    protected $name = 'statistics:data';

    /**
     * 命令注释
     *
     * @var string
     */
    protected $description = '数据汇总';

    /**
     * 参数对应的统计方式
     *
     * @var array
     */
    private $_arguments_map = [
        'appdownload' => '_appDownload',
    ];

    /**
     * Create a new command instance
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取执行命令的参数
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['type', InputArgument::REQUIRED, '统计类型：游戏下载、页面访问等',],
        ];
    }

    /**
     * Execute the console command
     *
     * @return mixed
     */
    public function fire()
    {
        $type = $this->argument('type');

        if (!array_key_exists($type, $this->_arguments_map)) {
            $this->error("不存在参数{$type}对应的汇总方法");
            die();
        }

        $this->{$this->_arguments_map[$type]}();
    }

    /**
     * 游戏下载统计
     *
     * @return void
     */
    private function _appDownload()
    {
        $this->info("=====开始进行游戏下载统计数据汇总=====");

        $db_logs = DB::connection('logs');
        $log_tables = $db_logs->table('logtables')
                              ->where('type', 'download')
                              ->get();

        foreach ($log_tables as $key => $value) {
            $this->info("正在处理{$value->name}表...");

            $result = null;
            $offset = 0;
            $limit = 1000;
            // 分段获取数据
            do {
                $result = $db_logs->table($value->name)
                                  ->select('id', 'status')
                                  ->skip($offset)->take($limit)
                                  ->get();
                // app统计记录，app_downloads表存在则更新，不存在则插入
                foreach ($result as $k => $v) {
                    // 查询游戏名称
                    $title = $db_mysql->table('apps')->where('id', $v->app_id)->pluck('title');
                    $this->_appDownloadDupInsert($v->app_id, $title, $v->status);
                }

                $offset += $limit;
            } while (!empty($result));
        }
        // 计算下载占比
        $this->_appDownloadCountPercent();

        $this->info("=====游戏下载统计汇总完毕=====");
    }

    /**
     * 创建app_downloads表数据记录，有则更新，无则插入
     *
     * @return void
     */
    private function _appDownloadDupInsert($app_id, $title, $status)
    {
        $count_date = date('Y-m-d', strtotime('yesterday'));

        $sql = "insert into `app_downloads` (app_id, title, {$status}, count_date)
                values ({$app_id}, {$title}, 1, {$count_date})
                on duplicate key update {$status} = {$status}+1";

        DB::connection('mysql')->table('app_downloads')->statement($sql);
    }

    /**
     * 计算下载占比(安装量/下载量)
     *
     * @return void
     */
    private function _appDownloadCountPercent()
    {
        $count_date = date('Y-m-d', strtotime('yesterday'));

        $sql = "update `app_downloads`
                set `download_percent` = `install`/`download`*100
                where `count_date` = '{$count_date}'";

        DB::connection('mysql')->statement($sql);
    }

}