<?php
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class NewAds extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'newads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '将ads_bak表的数据重新导入到新的ads表中';

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
     * 基础对应字段
     * 
     * @var array
     */ 
    protected $data = [
        'id' => 'id',
        'game_id' => 'app_id',
        'title' => 'title',
        'image' => 'image',
        'location' => 'location',
        'sort' => 'sort',
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
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->info("=================== 开始清空数据、导入数据、字段新增！ ====================");
        echo $this->truncateTable('ads');
        $this->createNewAds();
        $this->info("=================== 新的ads表数据导入成功啦！  ====================");
    }

    /**
     * 清空数据表
     *
     * @param $table array or string 表名 可以为数组或字符串
     *
     * @return $result 返回被清空的表名
     */
    protected function truncateTable($table)
    {
        $result = '';
        if (is_array($table)) {
            foreach ($table as $value) {
                DB::statement('truncate table '.$value);
                $result .= '清空'.$value."表成功!\n";
            }
        } else {
            DB::statement('truncate table '.$table);
            $result = '清空'.$table."表成功!\n";
        }

        return $result;
    }

    /**
     * 数据入库 字段对比
     * 
     * @return obj 
     */
    protected function createNewAds()
    {
        
        $default = [ 
            'package' => '', // 这个东西还要吗...
            'operator_id' => '0',
            'operator' => ''
        ];
        
        $oldAds = DB::table('ads_bak')->get();
        $newAds = new Ads;
        foreach ($oldAds as $oldAd) {
            foreach ($this->data as $key => $value) {
                // 状态分析
                if ($oldAd->is_stock == 'yes')
                    $newAds->status = 'stock';
                else
                    $newAds->status = 'unstock';

                $newAds->$key = $oldAd->$value;   
            }
        
            foreach ($this->dates as $key => $value) {
                if ($oldAd->$value != Null)
                    $newAds->$key = strtotime($oldAd->$value);
                else
                    $newAds->$key = $oldAd->$value;
            }

            foreach ($default as $key => $value) {
                $newAds->$key = $value;
            }

            return $newAds->save();
        }
        
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

}