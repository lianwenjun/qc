<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UcGame extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'uc:game';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '拉取九游游戏.';

    const SERVER = 'http://interface.test7.9game.cn:8039/datasync/getdata';
    const CALLER = '9game_wap_xdagame';
    const KEY    = 'e23b281ecd253384d41dfd29dce7351f';

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

        $value = $this->argument('type');

        if(! in_array($value, ['all', 'delta']) ) {
            $this->error('参数错误! 你可以用  --help 命令查看帮助');
        }


        print_r($this->request());

    }

    /**
     * 请求就有
     *
     *
     */
    public function request()
    {
        $sort = [
                'syncEntity' => 'game,platform,package',
                'syncField' => 'game.id',
                'syncType' => 1,
                'dateFrom' => '20000101000000',
                'dateTo' => '20140101000000',
                'pageSize' => 100,
                'pageNum' => 1
            ];

        $data = [
            'id' => time(),
            'client' => ['caller' => self::CALLER, 'ex' => null],
            'data' => [
                'syncEntity' => 'game,platform,package',
                'syncField' => 'game.id',
                'syncType' => 1,
                'dateFrom' => '20000101000000',
                'dateTo' => '20140101000000',
                'pageSize' => 100,
                'pageNum' => 1
            ],
            'encrypt' => 'base64',
        ];
        $json = json_encode($data);


        $d = ksort($sort);

        return $sort;

        $ch = curl_init(self::SERVER);                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($json))                                                                       
        );                                                                                                                   
         
        return curl_exec($ch);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['type', InputArgument::REQUIRED, '只有两种情况 all: 全量获取，delta: 增量拉取'],
        ];
    }

}
