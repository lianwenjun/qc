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

    const SERVER = 'http://interface.9game.cn/datasync/getdata';   // 九游请求地址
    const CALLER = '9game_wap_xdagame';                            // 九游请求用户名
    const KEY    = 'e23b281ecd253384d41dfd29dce7351f';             // 九游请求密钥

    private $_gameField     = '';     // 九游game表的字段
    private $_platformField = '';     // 九游platform表的字段
    private $_packageField  = '';     // 九游platform表的字段

    private $_totalPage     = 0;      // 总页数
    private $_isInited      = false;  // 是否已经初始化
    private $_error         = false;  // 是否当前页远程请求错误
    private $_retry         = [];     // 请求失败的页码

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
        $this->_gameField     = 'game.name,game.deleted';

        $this->_platformField = 'platform.id,platform.platformId,'.
                                'platform.logoImageUrl,platform.active,'.
                                'platform.version,platform.score,'.
                                'platform.size,platform.screenshotImageUrls,'.
                                'platform.description,platform.deleted';

        $this->packageField  = 'package.platformId,package.downUrl,'.
                               'package.packageName,package.version,'.
                               'package.upgradeDescription,package.md5,'.
                               'package.ad,package.secureLevel,'.
                               'package.deleted,package.extendInfo,';

        $value = $this->argument('type');

        if(! in_array($value, ['all', 'delta']) ) {
            $this->error('参数错误! 你可以用  --help 命令查看帮助');
        }

        print_r($this->$value());
    }

    /**
     * 拉取初始化
     *
     * @param $data json 请求参数
     *
     * @return void
     */
    protected function init($data)
    {

        if(!$this->_isInited) {
            // 获取页数信息，以及检查配置
            $this->info("=================== 九游初始化  ====================");

            $info = json_decode($data, true);
            $pageSize = $info['data']['pageSize'];

            $starttime = microtime(true);
            $respone   = $this->remoteData($data);

            $endtime   = microtime(true);

            if(!empty($respone)) {

                if($respone['state']['code'] != 200) {
                    $this->error($respone['state']['msg']);
                    \Log::error('九游拉取 Respone error: ' . $respone['state']['msg']);
                    exit;
                } else {
                    $this->_isInited = true;

                    $this->_totalPage = ceil($respone['data']['total'] / $pageSize);
                    $this->_totalPage = 10;

                    $min = ($endtime-$starttime)*$this->_totalPage/60;
                    $this->info(sprintf('需要拉取%d页，预计需要时间：%d分钟', $this->_totalPage, $min));
                }
            } else {
                $this->error('什么也没发生');
                exit;
            }
        }
    }

    /**
     * 增量
     *
     * @return void
     */
    protected function delta()
    {
        $from = '2000-01-01 00:00:00';
        $to   = date('Y-m-d H:i:s', time());

        $postData = $this->postData($from, $to);

        $this->init($postData);

        if(!$this->_isInited) $this->error('程序没有初始化!');

        echo 'delta';
    }

    /**
     * 所有内容
     *
     * @return void
     */
    protected function all()
    {

        $from = '2000-01-01 00:00:00';
        $to   = date('Y-m-d H:i:s', time());

        $postData = $this->postData($from, $to);
        $this->init($postData);

        if(!$this->_isInited) $this->error('程序没有初始化!');

        for ($i = 1; $i <= $this->_totalPage; $i++) {

            $this->_error = false;
            $this->info(sprintf('正在拉取第%d页', $i));

            $postData = $this->postData($from, $to, $i);
            $this->remoteData($postData);

            if(!$this->_error) {
                $this->info(sprintf('第%d页拉取完成', $i));
            } else {
                $this->_retry[] = $i;
                $this->info(sprintf('第%d页拉取失败', $i));
            }

            if($this->_totalPage == $i && empty($this->_retry)) {
                $this->info('全部拉取已完成ヾ(⌒∇⌒*)See You♪');
            } else if($this->_totalPage == $i && !empty($this->_retry)) { // 重试
                $this->info('((●゜c_゜●))b 重新拉取失败的页码 ');
                $this->retry($from, $to);
            }
        }
    }

    /**
     * 重试
     *
     * @param $from string 开始时间 
     * @param $to   string 结束时间
     *
     * @return void
     */
    protected function retry($from, $to)
    {
        $retry = $this->_retry;
        $this->_retry = [];
        foreach($retry as $k => $page) {
            $this->_error = false;
            $this->info(sprintf('正在拉取第%d页', $page));
            $postData = $this->postData($from, $to, $page);
            $data = $this->remoteData($postData);

            if(!$this->_error) {
                $this->info(sprintf('第%d页拉取完成', $page));
            } else {
                $this->_retry[] = $page;
                $this->info(sprintf('第%d页拉取失败', $page));
            }

            if($k == count($retry) - 1 && empty($this->_retry)) {
                $this->info('全部拉取已完成ヾ(⌒∇⌒*)See You♪');
            } else if($k == count($retry) - 1 && !empty($this->_retry)) { // 继续重试
                $this->info('(ಥ_ಥ) 重新拉取失败的页码 ');
                $this->retry($from, $to);
            }
        }
    }

    /**
     * 入库
     *
     */
    protected function store()
    {

    }

    /**
     * 条件
     *
     * @param $from string 开始时间 Y-m-d H:i:s
     * @param $to   string 结束时间 Y-m-d H:i:s
     *
     * @return array
     */
    protected function condition($from, $to)
    {
        $starttime = date('YmdHis', strtotime($from));
        $endtime   = date('YmdHis', strtotime($to));

        $field = sprintf('%s,%s,%s', $this->_gameField, $this->_platformField, $this->_packageField);
        $condition = [
                'syncEntity' => 'game,package,platform',
                'syncField'  => $field,
                'syncType'   => 1,
                'dateFrom'   => $starttime,
                'dateTo'     => $endtime,
                'pageSize'   => 1,
                'pageNum'    => 10000
            ];

        return $condition;
    }

    /**
     * post数据
     * 
     * @param $from string 开始时间 Y-m-d H:i:s
     * @param $to   string 结束时间 Y-m-d H:i:s
     * @param $page int    页码
     *
     * @return json
     */
    protected function postData($form, $to, $page = 1)
    {

        $condition = $this->condition($form, $to);

        $condition['pageNum'] = $page;

        $data = [
            'id' => time(),
            'client' => ['caller' => self::CALLER, 'ex' => null],
            'encrypt' => 'base64',
        ];

        $data['data'] = $condition;
        $data['sign'] = $this->sign($condition);

        return json_encode($data);
    }

    /**
     * 获取签名
     *
     * @param $condition array
     *
     * @return string 
     */
    protected function sign($condition)
    {

        $data = [];

        ksort($condition);

        $signStr = '';
        foreach($condition as $k => $v) {
            $signStr .= sprintf("%s=%s", $k, $v);
        }

        return  md5(self::CALLER . $signStr . self::KEY);
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
            $data['data'] = json_decode(base64_decode($data['data']), true);
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
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 秒
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json)
            ]
        );
         
        $json = curl_exec($ch);

        if(curl_errno($ch)) {
            $this->_error = true;
            $this->error('九游拉取 Curl error: ' . curl_error($ch));
            \Log::error('九游拉取 Curl error: ' . curl_error($ch));
        }

        curl_close($ch);

        return $this->parse($json);
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
