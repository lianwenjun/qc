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
    private $_argumentsMap = [
        'appdownloads' => '_appDownloads',
    ];

    /**
     * 目标日期的0点
     *
     * @var string
     */
    private $_dayBegin = '';

    /**
     * 目标日期的24点
     *
     * @var string
     */
    private $_dayEnd = '';

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
            ['date', InputArgument::OPTIONAL, '统计目标日期：如2011-11-11(可选参数)',],
        ];
    }

    /**
     * Execute the console command
     *
     * @return mixed
     */
    public function fire()
    {
        // 统计类型
        $type = $this->argument('type');
        // 目标日期
        $date = $this->argument('date');

        if (!array_key_exists($type, $this->_argumentsMap)) {
            $this->error("不存在参数{$type}对应的汇总方法");
            die();
        }

        // 初始化抓取数据创建的时间范围 有传入日期参数则按参数 无则默认昨天0点-24点
        if (!empty($date)) {
            $this->_dayBegin = date('Y-m-d H:i:s', strtotime($date));
            $this->_dayEnd = date('Y-m-d H:i:s', strtotime($date)+86400);
        } else {
            $this->_dayBegin = date('Y-m-d H:i:s', strtotime('yesterday'));
            $this->_dayEnd = date('Y-m-d H:i:s', strtotime('today'));
        }

        $this->{$this->_argumentsMap[$type]}();
    }

    /**
     * 游戏下载统计
     *
     * @return void
     */
    private function _appDownloads()
    {
        $this->info("=====开始进行游戏下载统计数据汇总=====");

        $db_logs = DB::connection('logs');
        $log_tables = $this->_findTables('download');

        foreach ($log_tables as $key => $name) {
            $this->info("正在处理{$name}表的数据...");

            $db_logs->table($name)
                    ->whereBetween('created_at', [$this->_dayBegin, $this->_dayEnd])
                    ->chunk(1000, function($data)
                    {
                        $appDownloads = new AppDownloads;
                        foreach ($data as $k => $v) {
                            // 更新app_downloads表
                            $appDownloads->dupInsert($v->app_id, $v->status, $this->_dayBegin);
                        }
                    });
        }
        // 计算下载占比
        (new AppDownloads)->countPercent(date('Y-m-d', strtotime($this->_dayBegin)));

        $this->info("=====游戏下载统计汇总完毕=====");
    }

    /**
     * 找出存在目标日期数据的表
     *
     * @param $type string 统计类型
     *
     * @return array 表名数组
     */
    private function _findTables($type)
    {
        $uncross = $this->_uncrossTables($type);
        $cross = $this->_crossTables($type);

        $tables = array_merge($uncross, $cross);

        return array_unique($tables);
    }

    /**
     * 找出没有跨天的表
     *
     * @param $type string 统计类型
     *
     * @return array 表名数组
     */
    private function _uncrossTables($type)
    {
        $db_logs = DB::connection('logs');
        $uncross = $db_logs->table('logtables')
                           ->where('type', $type)
                           ->where('used_at', '<', $this->_dayBegin)
                           ->where('updated_at', '>=', $this->_dayEnd)
                           ->lists('name');

        return $uncross;
    }

    /**
     * 找出跨天的表
     *
     * @param $type string 统计类型
     *
     * @return array 表名数组
     */
    private function _crossTables($type)
    {
        $db_logs = DB::connection('logs');

        $cross = $db_logs->table('logtables')
                         ->where('type', $type)
                         ->where(function($query)
                         {
                            $time_area = [
                                $this->_dayBegin,
                                $this->_dayEnd,
                            ];
                            $query->whereBetween('used_at', $time_area)
                                  ->orWhereBetween('updated_at', $time_area);
                         })
                         ->lists('name');

        return $cross;
    }

}