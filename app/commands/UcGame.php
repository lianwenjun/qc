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

    const SERVER = 'http://interface.9game.cn/datasync/getdata';
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

        print_r($this->all());

    }

    /**
     * 请求
     *
     *
     */
    public function all()
    {

        $gameField = 'game.name,game.deleted';
        $platformField = 'platform.id,platform.platformId,platform.logoImageUrl,platform.active,platform.version,platform.score,platform.size,platform.screenshotImageUrls,platform.description,platform.deleted';
        $packageField = 'package.platformId,package.downUrl,package.packageName,package.version,package.upgradeDescription,package.md5,package.ad,package.secureLevel,package.deleted,package.extendInfo,';

        $sort = [
                'syncEntity' => 'game,package,platform',
                'syncField'  => sprintf('%s,%s,%s', $gameField, $platformField, $packageField),
                'syncType'   => 1,
                'dateFrom'   => '20000101000000',
                'dateTo'     => '20140101000000',
                'pageSize'   => 10,
                'pageNum'    => 10000
            ];

        $data = [
            'id' => time(),
            'client' => ['caller' => self::CALLER, 'ex' => null],
            'encrypt' => 'base64',
        ];

        ksort($sort);
        $data['data'] = $sort;

        $signStr = '';
        foreach($sort as $k => $v) {
            $signStr .= sprintf("%s=%s", $k, $v);
        }

        $data['sign'] = md5(self::CALLER . $signStr . self::KEY);
        $removeRespone = $this->remoteData(json_encode($data));

        return $this->parse($removeRespone);
    }

    /**
     * 解析数据
     *
     * @param $data string json 格式数据
     *
     * @return array
     */
    protected function parse($data)
    {
        $data = json_decode($data, true);

        if(isset($data['data'])) {
            $data['data'] = base64_decode($data['data']);
        }

        return $data;
    }

    /**
     * 远程数据
     *
     * @param $json string 请求条件
     *
     * @return string json
     */
    protected function remoteData($json)
    {
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
