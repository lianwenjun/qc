<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Database\Schema\Blueprint;

class MoveAppTableToGameTable extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'table:apptogame';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '拆分APP表，从中拆分出上架表，过程处理表，适用V2.0版本开发,迁移之后废除
    apps表 histories表, 保留game_stocks表，game_processes表，game_histories表';

    /**
     * 基础对应字段
     * 
     * @var array
     */
    protected $data = [
        'id' => 'id',
        'entity_id' => 'entity_id',
        'icon' => 'icon',
        'title' => 'title',
        'package' => 'pack',
        'size' => 'size_int',
        'md5' => 'md5',
        'version' => 'version',
        'version_code' => 'version_code',
        'author' => 'author',
        'summary' => 'summary',
        'screenshots' => 'images',
        'download_total' => 'download_counts',
        'download_display' => 'download_manual',
        'download_link' => 'download_link',
        'creator_id' => 'operator',
        'os' => 'os',
        'os_version' => 'os_version',
        'sort' => 'sort',
        'status' => 'status',
        'vendor' => 'source',
        'features' => 'changes',
        'reason' => 'reason',
        'status' => 'status'
    ];

    /**
     * 时间字段特殊处理
     * 
     * @var array
     */
    protected $dates = [
        'stocked_at' => 'stocked_at',
        'unstocked_at' => 'unstocked_at',
        'deleted_at' => 'deleted_at',
        'created_at' => 'created_at',
        'updated_at' => 'updated_at'
    ];

    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->info("===============开始迁移上架数据==================");
        $this->getAllStocks();
        $this->info("===============迁移上架数据结束==================");

        $this->info("===============开始迁移流程数据==================");
        $this->getAllProcesses();
        $this->info("===============迁移上架流程结束==================");

        $this->info("===============开始迁移历史数据==================");
        $this->getAllHistory();
        $this->info("===============历史数据迁移完成==================");

        $this->info("===============版本记录迁移开始==================");
        
        $this->info("===============版本记录迁移完成==================");
        
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

    /**
     * 获得所有的上线的游戏数据
     *
     * @return void
     */
    public function getAllStocks()
    {
        $end = 0;
        $limit = 1000;
        //$count = Apps::where('status', 'stock')->count();
        $count = DB::table('apps')->where('status', 'stock')->count();
  
        while ($count) {
            //$apps = Apps::where('status', 'stock')->skip($end)->take($limit)->get();
            $apps = DB::table('apps')->where('status', 'stock')->skip($end)->take($limit)->get();
            if (count($apps) === 0)
                break;
            $end += $limit;
            foreach ($apps as $app) {
                $game = $this->createGame('GameStocks', $app);
                if ($game)
                    $game->save();
            }
        }
    }

    /**
     * 获得所有的流程的游戏数据
     *
     * @return void
     */
    public function getAllProcesses()
    {
        $end = 0;
        $limit = 1000;
        $count = DB::table('apps')->where('status', '!=', 'stock')->count();
        while ($count) {
            $apps = DB::table('apps')->where('status', '!=', 'stock')->skip($end)->take($limit)->get();
            if (count($apps) === 0)
                break;
            $end += $limit;
            foreach ($apps as $app) {
                $game = $this->createGame('GameProcesses', $app);
                if ($game)
                    $game->save();
            }
            //break;
        }
    }

    /**
     * 获得所有的流程的游戏数据
     *
     * @return void
     */
    public function getAllHistory()
    {
        $end = 0;
        $limit = 1000;
        $count = DB::table('histories')->count();
        while ($count) {
            $apps = DB::table('histories')->skip($end)->take($limit)->get();
            if (count($apps) === 0)
                break;
            $end += $limit;
            foreach ($apps as $app) {
                $game = $this->createGame('GameHistories', $app);
                if (! $game)
                    continue;
                $game->status = 'history';
                $game->cats = $app->cats;
                $game->tags = $app->tags;
                $game->save();
            }
            //break;
        }
    }

    /**
     * 数据入库 字段对比
     * 
     * @param $app obj 游戏数据
     *
     * @return obj game
     */
    public function createGame($model, $app)
    {
        
        $default = [ // 默认的
            'game_id' => '0', // 默认传值
            'operator' => '',
            'creator_id' => '0',
            'creator' => '',
            'cats' => '',
            'comments' => '0',
            'rate' => '0',
            'review' => '',
        ];
        
        $game = new $model;
        
        if ($game->find($app->id)) {
            return;
        }
        foreach ($this->data as $key => $value) {
            $game->$key = $app->$value;
        }
        
        foreach ($this->dates as $key => $value) {
            if ($app->$value != Null)
                $game->$key = strtotime($app->$value);
            else
                $game->$key = $app->$value;
        }
        foreach ($default as $key => $value) {
            $game->$key = $value;
        }
        
        return $game;
    }
    
}