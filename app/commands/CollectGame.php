<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * 抓取各平台游戏数据的命令行工具类
 *
 * @author RavenLee
 */
class CollectGame extends Command
{
    /**
     * 命令名称
     *
     * @var string
     */
    protected $name = 'collect:game';

    /**
     * 命令注释
     *
     * @var string
     */
    protected $description = '拉取第三方平台游戏';

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
     * Execute the console command
     *
     * @return mixed
     */
    public function fire()
    {
        $platform = $this->argument('platform');
        $gettype  = $this->argument('gettype');

        $class   = 'CGame_'.ucfirst($platform);
        $collect = new $class;

        if (!is_a($collect, 'CGame_Base')) {
            $this->error("数据获取类设计错误，该类必须是CGame_Base的子类");
            die();
        }

        if (!method_exists($collect, $gettype)) {
            $this->error("{$platform}类中不存在{$gettype}获取方式");
            die();
        }

        $this->info("==========正在拉取{$platform}平台的游戏数据==========");

        $collect->$gettype();
    }

    /**
     * 获取执行命令的参数
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['platform', InputArgument::REQUIRED, '第三方游戏平台名称，如uc、360',],
            ['gettype', InputArgument::REQUIRED, '获取方式：全量all、增量append',],
        ];
    }
}