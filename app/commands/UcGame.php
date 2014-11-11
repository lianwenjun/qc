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
    private $_config        = '';

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
        $this->_gameField     = 'game.name,game.deleted,game.createTime,game.categoryId';

        $this->_platformField = 'platform.id,platform.platformId,'.
                                'platform.logoImageUrl,platform.active,'.
                                'platform.version,platform.score,'.
                                'platform.size,platform.screenshotImageUrls,'.
                                'platform.description,platform.deleted';

        $this->_packageField  = 'package.platformId,package.downUrl,'.
                                'package.packageName,package.version,'.
                                'package.upgradeDescription,package.md5,'.
                                'package.ad,package.secureLevel,'.
                                'package.deleted,package.extendInfo,';

        $this->_config = $config = app_path() . '/config/ucDelta.php';

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
                    // $this->_totalPage = 10;

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
        
        if(file_exists($this->_config)) {
            $from = Config::get('ucDelta.from');
        } else {
            $from = '2000-01-01 00:00:00';
        }

        $to = date('Y-m-d H:i:s', time());

        $postData = $this->postData($from, $to);
        $this->init($postData);

        if(!$this->_isInited) $this->error('程序没有初始化!');

        $this->page($from, $to);
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

        $this->page($from, $to);
    }

    /**
     * 分页抓取
     *
     * @param $from string datetime
     * @param $to   string datetime
     *
     * @return voie;
     */
    protected function page($from, $to)
    {
        for ($i = 1; $i <= $this->_totalPage; $i++) {

            $this->_error = false;
            $this->info(sprintf('正在拉取第%d页', $i));

            $postData = $this->postData($from, $to, $i);
            $info = $this->remoteData($postData);

            if(!$this->_error) {
                $this->info(sprintf('第%d页拉取完成', $i));

                // 入库
                //$this->store($info);

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

        // 设置增量抓取配置
        $delta_config = [
            'from' => date('Y-m-d H:i:s', time() - 60 * 30),
        ];

        // 写入配置文件
        $this->deltaConfig($delta_config);
    }

    /**
     * 设置增量配置
     *
     * @return void
     */
    protected function deltaConfig($conf)
    {
        $delta = [];
        foreach ($conf as $key => $value) {
            if (empty($value)) {
                continue;
            }

            $delta[$key] = $value;
        }

        if (empty($delta)) {
            return false;
        }

        ob_start();
        echo "<?php \n// 此文件由命令生成, 九游增量配置\nreturn ";
        var_export($delta);
        echo ";\n";
        $content = ob_get_contents();

        file_put_contents($this->_config, $content);
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

            $info = $this->remoteData($postData);

            if(!$this->_error) {
                $this->info(sprintf('第%d页拉取完成', $page));
                $this->store($info);
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
     * 获取package信息
     *
     * @param $item array
     *
     * @return array
     */
    private function _package($item)
    {
        $packages = [];
        if(isset($item['packages']) && is_array($item['packages'])) {
            $packages = $item['packages'];
        }

        $data = [];
        foreach($packages as $package) {
            if($package['deleted'] == 0 && $package['platformId'] == 2) {
                $data = $package;
            }
        }

        if(!isset($package['extendInfo']['packageName'])) {
            $data = [];
        }

        return $data;
    }

    /**
     * 获取平台信息
     *
     * @param $item array
     *
     * @return array
     */
    private function _platform($item)
    {
        $platforms = [];
        if(isset($item['platforms']) && is_array($item['platforms'])) {
            $platforms = $item['platforms'];
        }

        $data = [];
        foreach($platforms as $platform) {
            if($platform['deleted'] == 0 && $platform['platformId'] == 2) {
                $data = $platform;
            }
        }

        if(!isset($platform['logoImageUrl'])) {
            $data = [];
        }

        return $data;
    }

    /**
     * 解析数据
     *
     * @param $name string APP名称
     * @param $package  array 包数据
     * @param $platform array 平台数据
     *
     * @return array
     */
    private function _parse($name, $package, $platform)
    {

        $images = array_slice($platform['screenshotImageUrls'], 0, 6);

        $data = [
            'icon'          => $platform['logoImageUrl'],
            'title'         => $name,
            'pack'          => $package['extendInfo']['packageName'],
            'size'          => CUtil::friendlyFilesize($platform['size']),
            'size_int'      => intval($platform['size']/1024),
            'version'       => $package['extendInfo']['versionName'],
            'version_code'  => $package['extendInfo']['versionCode'],
            'author'        => '九游安卓',
            'summary'       => $platform['description'],
            'images'        => serialize($images),
            'changes'       => $package['upgradeDescription'],
            'download_link' => $package['downUrl'],
            'os'            => 'Android',
            'os_version'    => $this->sdkAlias($package['extendInfo']['minSdkVersion']),
            'is_verify'     => $package['secureLevel'] == 0 ? 'yes' : 'no',
            'has_ad'        => $package['ad'] == 0 ? 'no' : 'yes',
            'md5'           => $package['extendInfo']['signMd5'],
            'status'        => 'publish',
            'source'        => 'uc',
        ];

        return $data;
    }

    /**
     * 入库
     *
     * @param $info array 采集到的信息
     *
     * @return void
     */
    protected function store($info)
    {
        if (!isset($info['data']['list'])) {
            return;
        }

        foreach($info['data']['list'] as $item) {

            if (!isset($item['deleted']) || $item['deleted'] != 0) {
                continue;
            }
            
            $package  = $this->_package($item);
            $platform = $this->_platform($item);

            if (empty($package) || empty($platform)) {
                continue;
            }

            $data = $this->_parse($item['name'], $package, $platform);

            // 获取对应过来的分类id 为0则忽略插入或更新的操作
            $cat_id = $this->cats($item['categoryId']);

            // 判断数据库中是否存在该apk对应的app记录 有就更新信息 无则创建一条记录
            $record = Apps::where('pack', $data['pack'])
                          ->first();

            if (isset($record->id)) {
                $this->_updateApkInfo($record->id, $data, $cat_id, $platform['score']);
            } else {
                $this->_createApkInfo($data, $cat_id, $platform['score']);
            }
        }
    }

    /**
     * 更新apk对应的app记录
     *
     * @param $app_id int 游戏id
     * @param $app_info array 游戏信息
     * @param $cat_id int 游戏分类id
     * @param $avg_score double 游戏平均评分
     *
     * @return void
     */
    private function _updateApkInfo($app_id, $app_info, $cat_id, $avg_score) {
        // 更新apk包信息
        Apps::where('id', $app_id)
            ->update($app_info);

        // 更新平均评分
        Ratings::where('app_id', $app_id)
               ->update(['avg' => $avg_score,]);

        // 分类id不为0则更新分类id
        if ($cat_id != 0) {
            AppCats::where('app_id', $app_id)
               ->update(['cat_id' => $cat_id,]);
        }
    }

    /**
     * 创建apk对应的app记录
     *
     * @param $apk_info array 游戏信息
     * @param $cat_id int 游戏分类id
     * @param $avg_score double 游戏平均评分
     *
     * @return void
     */
    private function _createApkInfo($apk_info, $cat_id, $avg_score) {
        // 插入apk包信息 生成app_id
        $insert = Apps::create($apk_info);

        // 创建评分记录 插入平均评分
        Ratings::create([
                            'app_id' => $insert->id,
                            'title'  => $apk_info['title'],
                            'pack'   => $apk_info['pack'],
                            'total'  => 0,
                            'counts' => 0,
                            'avg'    => $avg_score,
                            'manual' => 0,
                        ]);

        // 分类id不为0则创建游戏分类记录 插入分类id
        if ($cat_id != 0) {
            AppCats::create([
                                'app_id' => $insert->id,
                                'cat_id' => $cat_id,
                            ]);
        }
    }

    /**
     * 获取对应SDK版本号
     *
     * @param $sdkVersion int SDK版本
     *
     * @return string
     */
    protected function sdkAlias($sdkVersion)
    {
        $data = [
            1 => '1.0',
            2 => '1.1',
            3 => '1.5',
            4 => '1.6',
            5 => '2.0',
            6 => '2.0.1',
            7 => '2.1.x',
            8 => '2.2.x',
            9 => '2.3',
            10 => '2.3.3',
            11 => '3.0.x',
            12 => '3.1.x',
            13 => '3.2',
            14 => '4.0',
            15 => '4.0.3',
            16 => '4.1',
            17 => '4.2',
            18 => '4.3',
            19 => '4.4',
        ];

        return in_array($sdkVersion, array_keys($data)) ? $data[$sdkVersion] : '';
    }

    /**
     * 获取对应分类
     *
     * @param int $cat 分类ID
     *
     * @return int
     */
    protected function cats($cat)
    {
        $data = [
            1 => 1,   // 休闲
            2 => 4,   // 竞速
            3 => 5,   // 角色
            4 => 6,   // 策略
            5 => 7,   // 冒险
            6 => 8,   // 动作
            7 => 9,   // 模拟
            8 => 10,   // 体育
            9 => 8,   // 射击
            10 => 2,  // 棋牌
            11 => 0,  // 格斗
            12 => 0,  // 益智
            13 => 0,  // 回合
            14 => 0,  // 即时
            18 => 4,  // 赛车
            19 => 0,  // 其他
            25 => 0,  // 养成
            35 => 0,  // 页面
            36 => 6,  // 策略·页面
            37 => 5,  // 角色·页面
            38 => 1,  // 休闲·页面
            39 => 6,  // 策略·页面·端游
            40 => 9,  // 模拟·页面
            41 => 0,  // 社交
            48 => 5,  // 角色·页面·端游
            49 => 1,  // 休闲·页面·端游
            50 => 9,  // 模拟·页面·端游
            51 => 0,  // 其他·页面·端游
            53 => 3,  // 塔防
            54 => 0,  // 创意奇趣
            55 => 0,  // XBOX LIVE
            56 => 0,  // 软件
            57 => 12,  // 音乐
        ];

        return in_array($cat, array_keys($data)) ? $data[$cat] : 0;
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
                'pageSize'   => 100,
                'pageNum'    => 10000   // 此处配置无效
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
        curl_setopt($ch, CURLOPT_TIMEOUT, 60); // 秒
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
