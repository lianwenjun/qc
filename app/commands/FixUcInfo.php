<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class FixUcInfo extends Command
{
    /**
     * 命令名称
     *
     * @var string
     */
    protected $name = 'fixucinfo';

    /**
     * 命令注释
     *
     * @var string
     */
    protected $description = '修复UC平台游戏的MD5不匹配问题';

    const SERVER = 'http://interface.9game.cn/datasync/getdata';   // 九游请求地址
    const CALLER = '9game_wap_xdagame';                            // 九游请求用户名
    const KEY    = 'e23b281ecd253384d41dfd29dce7351f';             // 九游请求密钥

    private $_gameField     = '';     // 九游game表的字段
    private $_platformField = '';     // 九游platform表的字段
    private $_packageField  = '';     // 九游platform表的字段
    private $_postData      = '';     // 执行请求的数据
    private $_error         = false;
    private $_responseError = false;

    private $_entityId      = ''; // 游戏在uc平台的id
    private $_eid2GameInfo  = []; // uc平台id对应游戏数据
    private $_retry         = [];
    private $_result        = '';

    /**
     * Create a new command instance
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

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

        $this->_config = $config = app_path() . '/config/ucCGame.php';
    }

    /**
     * 获取执行命令的参数
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            // ['game_id', InputArgument::REQUIRED, '在我方游戏中心中的游戏id'],
        ];
    }

    protected function getOptions()
    {
        return [];
    }

    /**
     * 执行命令
     *
     * @return void
     */
    public function fire()
    {
        // 每100个游戏请求一次uc接口抓取数据
        Apps::chunk(40, function($games)
        {
            $this->_eid2GameInfo = [];
            foreach ($games as $key => $value) {
                $this->_eid2GameInfo[$value['entity_id']] = $value;
            }

            $this->_entityId = implode(',', array_keys($this->_eid2GameInfo));

            $this->_createPost();
            $this->_request();
            
            if ($this->_error ||
                !is_array($this->_result) ||
                !isset($this->_result['data']['list'])) {
                $this->_retry();
            }

            $this->_dealResult();
        });
    }

    private function _retry()
    {
        $this->info("Request retrying at entityIds:{$this->_entityId}");
        $this->_request();

        if ($this->_error ||
            !is_array($this->_result) ||
            !isset($this->_result['data']['list'])) {
            $this->_retry();
        }

        return true;
    }

    /**
     * 处理请求结果
     *
     * @return void
     */
    private function _dealResult()
    {
        foreach ($this->_result['data']['list'] as $key => $value) {
            if (!isset($value['deleted']) || $value['deleted'] != 0) {
                $this->error('this game is already deleted in UC');
                continue;
            }

            $package  = $this->_package($value);
            $platform = $this->_platform($value);

            if (empty($package) || empty($platform)) {
                continue;
            }

            $data = $this->_parse($value['name'], $package, $platform);
            if (empty($data['md5'])) {
                continue;
            }

            $gameId = $this->_eid2GameInfo[$value['id']]['id'];
            $old_md5 = $this->_eid2GameInfo[$value['id']]['md5'];
            $update = [
                'md5' => $data['md5'],
            ];

            $this->info("----------Updating Game-{$gameId}----------");
            $this->info("old md5 is:{$old_md5}");
            $this->info("new md5 is:{$data['md5']}");

            Apps::where('id', $gameId)->update($update);
            $this->info("----------Update finished----------");
        }
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
     * 创建请求参数
     *
     * @return bool
     */
    private function _createPost()
    {
        $field = sprintf('%s,%s,%s', $this->_gameField, $this->_platformField, $this->_packageField);
        $condition = [
            'syncEntity' => 'game,package,platform',
            'syncField'  => $field,
            'syncType'   => 2,
            'gameIdList' => $this->_entityId,
        ];

        $data = [
            'id'      => time(),
            'client'  => ['caller' => self::CALLER, 'ex' => null,],
            'encrypt' => 'base64',
        ];

        $data['data'] = $condition;
        $data['sign'] = $this->sign($condition);

        $this->_postData = json_encode($data);

        return true;
    }

    /**
     * 解析平台返回的加密数据
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
     * 执行请求
     */
    private function _request()
    {
        $ch = curl_init(self::SERVER);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60); // 秒
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($this->_postData)
        ]);
         
        $json = curl_exec($ch);

        if(curl_errno($ch)) {
            $this->_error = true;
            $this->error('九游拉取 Curl error: ' . curl_error($ch) . "\n");
            \Log::error('九游拉取 Curl error: ' . curl_error($ch));
        }

        curl_close($ch);

        $this->_result = $this->parse($json);
        // return $this->parse($json);
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
     * 调整数据格式
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
            'icon'              => $platform['logoImageUrl'],
            'title'             => $name,
            'pack'              => $package['extendInfo']['packageName'],
            'size'              => CUtil::friendlyFilesize($platform['size']),
            'size_int'          => intval($platform['size']/1024),
            'version'           => $package['extendInfo']['versionName'],
            'version_code'      => $package['extendInfo']['versionCode'],
            'author'            => '九游安卓',
            'summary'           => str_replace("\n", '<br>', $platform['description']),
            'images'            => serialize($images),
            'changes'           => str_replace("\n", '<br>', $package['upgradeDescription']),
            'download_link'     => $package['downUrl'],
            'os'                => 'Android',
            'os_version'        => $this->sdkAlias($package['extendInfo']['minSdkVersion']),
            'is_verify'         => $package['secureLevel'] == 0 ? 'yes' : 'no',
            'has_ad'            => $package['ad'] == 0 ? 'no' : 'yes',
            'md5'               => $package['md5'],
            'status'            => 'publish',
            'source'            => 'uc',
        ];

        return $data;
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
}