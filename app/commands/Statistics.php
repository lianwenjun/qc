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
        'appdownloads' => '_appDownloads',
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
    private function _appDownloads()
    {
        $this->info("=====开始进行游戏下载统计数据汇总=====");

        $yesterday = date('Y-m-d H:i:s', strtotime('yesterday'));

        $db_logs = DB::connection('logs');
        $log_tables = $db_logs->table('logtables')
                              ->where('type', 'download')
                              ->where('updated_at', '>', $yesterday)
                              ->lists('name');

        foreach ($log_tables as $key => $name) {
            $this->info("正在处理{$name}表的数据...");

            $db_logs->table($name)
                    ->where('created_at', '>', $yesterday)
                    ->chunk(1000, function($data)
                    {
                        $appDownloads = new AppDownloads;
                        foreach ($data as $k => $v) {
                            // 更新app_downloads表
                            $appDownloads->dupInsert($v->app_id, $v->status);
                        }
                    });
        }
        // 计算下载占比
        (new AppDownloads)->countPercent(date('Y-m-d', strtotime($yesterday)));

        $this->info("=====游戏下载统计汇总完毕=====");
    }

}