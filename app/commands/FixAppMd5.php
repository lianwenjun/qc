<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class FixAppMd5 extends Command
{
    /**
     * 命令名称
     *
     * @var string
     */
    protected $name = 'fixappmd5';

    /**
     * 命令注释
     *
     * @var string
     */
    protected $description = '修复本地上传MD5数据';

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
        return [];
    }

    protected function getOptions()
    {
        return [];
    }

    /**
     * Execute the console command
     *
     * @return void
     */
    public function fire()
    {
        $this->info("==========start fix all app tags==========");

        $apps = Apps::where('source', 'lt')
                    ->select('download_link', 'id')
                    ->get();

        foreach($apps as $app) {
            $path = public_path() . $app->download_link;

            if(file_exists($path)) {
                $md5      = md5_file($path);
                $bsize    = filesize($path);
                $size     = CUtil::friendlyFilesize($bsize);
                $size_int = round($bsize / 1024, 0);
                $app->update(['md5' => $md5, 'size' => $size, 'size_int' => $size_int]);
                echo $this->info("fixes: {$app->id}");
            }
        }

        $this->info("==========fix done==========");
    }
}