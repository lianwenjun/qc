<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Database\Schema\Blueprint;

class DownloadLogsTable extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'log:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '增加下载日志表';
    //=============================================================
    private $num = 10; //一次新建表数，默认
    private $length = 5; //随机长度
    private $db = 'logs'; //数据库库名，必须配置里有
    private $limit = 5000000;//每张表的限制总数
    private $logTable = 'logs.logtables';//记录日志表的总表
    private $type = 'download'; //分类为下载日志
    //=============================================================
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 运行
     *
     * @return mixed
     */
    public function fire()
    {
        //获得需要生成的表的数
        $this->num = $this->num - $this->getNeedNum();
        if ($this->num < 1) {
            $this->info(date('Y-m-d H:i:s') . ' : 不需要建立新表啦');
            return;
        }
        //获得现有的表名
        $names = $this->getNames();
        //生成需要的表名
        $newNames = $this->setNewNames($names);
        
        foreach ($newNames as $name) {
            $data = [
                'name' => $name,
                'count' => '0',
                'type' => $this->type,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ];
            //插入到数据表
            $this->createName($data);
            //新建表
            $this->newTable($name);
            $this->info(date('Y-m-d H:i:s') . ' : 新建立' . $this->db . '.' . $name . '表');
        }
        $this->info('总共建立了' . $this->num . '张下载日志表');
    }

    protected function getArguments() {
        return [];
    }

    protected function getOptions() {
        return [];
    }
    /*
    * 生成新的下载日志表
    * @prama $tableName string 表名
    * @respone $data
    */
    private function newTable($tableName) {
        if (Schema::connection($this->db)->hasTable($tableName)) {
            return;
        }
        Schema::connection($this->db)->create($tableName, function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('app_id')->comment('游戏ID');
            $table->integer('account_id')->unsigned()->comment('手机用户ID');
            $table->string('ip', 64)->comment('移动端IP');
            $table->enum('status', ['request', 'download', 'install', 'active'])->default('request')->comment('日志类型');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    //获得随机值
    private function getRandom() {
        return str_random($this->length);
    }
    //检查是否总数合格
    private function isNum($random) {
        return count($random) < $this->num;
    }
    //检查表可用的表剩余
    private function getNeedNum() {
        return DB::table($this->logTable)->where('count', '<', $this->limit)->count();
    }
    //获得现有的表名
    private function getNames() {
        $names = DB::table($this->logTable)->select('name')->get();
        $data = array_map(function($x){
            return $x->name;
        }, $names);
        return $data;
    }
    //添加新表的记录
    private function createName($data) {
        DB::table($this->logTable)->insert($data);
    }
    //生成N张表名
    private function setNewNames($names) {
        $newNames = [];
        while ($this->isNum($newNames)) {
            $str = $this->getRandom();
            if (!in_array($str, $names)) {
                $newNames[] = $str;
            }
        }
        return $newNames;
    }
}
?>