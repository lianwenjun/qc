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
        $db_mysql = DB::connection('mysql');
        $db_logs = DB::connection('logs');

        $log_tables = $db_logs->table('logtables')
                              ->where('type', 'download')
                              ->get();

        foreach ($log_tables as $key => $value) {
            $tb = $value->name;
            $this->info("正在处理{$tb}表...");

            $result = null;
            $offset = 0;
            $limit = 1000;

            do {
                $result = $db_logs->table($tb)
                                  ->skip($offset)
                                  ->take($limit)
                                  ->get();
                // app统计记录，app_downloads表存在则更新，不存在则插入
                foreach ($result as $key => $value) {
                    $app_id = $value->app_id;
                    $status = $value->status;
                    $title = $db_mysql->table('apps')
                                      ->where('id', $app_id)
                                      ->pluck('title');
                    $count_date = date('Y-m-d', strtotime('yesterday'));

                    $sql = "insert into `app_downloads` (app_id, title, {$status}, count_date)
                            values ({$app_id}, {$title}, 1, {$count_date})
                            on duplicate key update {$status} = {$status}+1";

                    $db_mysql->table('app_downloads')
                             ->statement($sql);
                }
            } while (!empty($result));

            $this->info("{$tb}表处理完毕");
        }

        $today_data = $db_mysql->table('app_downloads')
                               ->where('count_date', date('Y-m-d H:i:s', strtotime('today')))
                               ->get();

        $this->info("游戏下载统计汇总完毕");
    }

}