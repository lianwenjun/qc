<?php

/**
 * UC平台游戏数据抓取类
 *
 * @author WeelionCai
 */
class CGame_Uc extends CGame_Base
{
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

    private $_config        = '';     // 独立配置文件

    private $_postData      = '';     // 请求参数
    private $_page          = 1;      // 默认开始页数
    private $_from          = '';     // 开始日期
    private $_to            = '';     // 结束日期

    /**
     *
     *
     */
    public function __construct()
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

        $this->_config = $config = app_path() . '/config/ucCGame.php';
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
            echo "九游初始化...\n";

            $this->_postData = $data;
            $info = json_decode($data, true);
            $pageSize = $info['data']['pageSize'];

            $starttime = microtime(true);
            $respone   = $this->request();
            $endtime   = microtime(true);

            if(!empty($respone)) {

                if($respone['state']['code'] != 200) {
                    echo $respone['state']['msg'] . "\n";
                    \Log::error('九游拉取 Respone error: ' . $respone['state']['msg']);
                    exit;
                } else {
                    $this->_isInited = true;

                    $this->_totalPage = ceil($respone['data']['total'] / $pageSize);

                    $min = ($endtime-$starttime) * $this->_totalPage / 60;
                    echo sprintf("需要拉取%d页，预计需要时间：%d分钟\n", $this->_totalPage, $min);
                }
            } else {
                echo "什么也没发生\n";
                exit;
            }
        }
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
            'pageNum'    => 1,   // 此处配置无效
        ];

        return $condition;
    }

    /**
     * 生成请求参数数据
     */
    protected function createPost()
    {
        $condition = $this->condition($this->_from, $this->_to);

        $condition['pageNum'] = $this->_page;

        $data = [
            'id'      => time(),
            'client'  => ['caller' => self::CALLER, 'ex' => null,],
            'encrypt' => 'base64',
        ];

        $data['data'] = $condition;
        $data['sign'] = $this->sign($condition);

        return json_encode($data);
    }

    /**
     * 执行请求
     */
    protected function request()
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
            echo '九游拉取 Curl error: ' . curl_error($ch) . "\n";
            \Log::error('九游拉取 Curl error: ' . curl_error($ch));
        }

        curl_close($ch);

        return $this->parse($json);
    }

    /**
     * 分页抓取
     *
     * @param $from string datetime
     * @param $to   string datetime
     *
     * @return voie;
     */
    protected function page()
    {
        for ($i = 1; $i <= $this->_totalPage; $i++) {

            $this->_error = false;
            echo sprintf("正在拉取第%d页\n", $i);

            $this->_page = $i;

            $this->_postData = $this->createPost();
            $info = $this->request();

            if(!$this->_error) {
                echo sprintf("第%d页拉取完成\n", $i);

                // 调整格式并入库
                $this->transform($info);
            } else {
                $this->_retry[] = $i;
                echo sprintf("第%d页拉取失败\n", $i);
            }

            if($this->_totalPage == $i && empty($this->_retry)) {
                echo "全部拉取已完成ヾ(⌒∇⌒*)See You♪\n";
            } else if($this->_totalPage == $i && !empty($this->_retry)) { // 重试
                echo "((●゜c_゜●))b 重新拉取失败的页码\n";
                $this->retry($this->_from, $this->_to);
            }

            // 设置增量抓取配置
            $delta_config = [
                'from' => date('Y-m-d H:i:s', time() - 60 * 10),
            ];

            // 写入配置文件
            $this->appendConfig($delta_config);
        }
    }

    /**
     * 设置增量配置
     *
     * @return void
     */
    protected function appendConfig($conf)
    {
        ob_start();
        echo "<?php \n// 此文件由命令生成, 九游增量配置\nreturn ";
        var_export($conf);
        echo ";\n";
        $content = ob_get_contents();

        file_put_contents($this->_config, $content);
        ob_end_clean();
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

            echo sprintf("正在拉取第%d页\n", $page);
            $postData = $this->createPost();
            $info = $this->request();

            if(!$this->_error) {
                echo sprintf("第%d页拉取完成\n", $page);
                
                // 调整格式并入库
                $this->transform($info);
            } else {
                $this->_retry[] = $page;
                echo sprintf("第%d页拉取失败\n", $page);
            }

            if($k == count($retry) - 1 && empty($this->_retry)) {
                echo "全部拉取已完成ヾ(⌒∇⌒*)See You♪\n";
            } else if($k == count($retry) - 1 && !empty($this->_retry)) { // 继续重试
                echo "(ಥ_ಥ) 重新拉取失败的页码\n";
                $this->retry($from, $to);
            }
        }
    }

    /**
     * 全量获取游戏数据
     *
     * @return void
     */
    public function all()
    {
        $this->_from = '2000-01-01 00:00:00';
        $this->_to   = date('Y-m-d H:i:s', time());

        $postData = $this->createPost();
        $this->init($postData);

        if(!$this->_isInited) $this->error('程序没有初始化!');

        $this->page();
    }

    /**
     * 增量获取游戏数据
     *
     * @return void
     */
    public function append()
    {
        if (file_exists($this->_config)) {
            $this->_from = Config::get('ucCGame.from');
        } else {
            $this->_from = '2000-01-01 00:00:00';
        }

        $this->_to = date('Y-m-d H:i:s');

        $postData = $this->createPost();
        $this->init($postData);

        if(!$this->_isInited) $this->error('程序没有初始化!');

        $this->page();
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
     * 转换游戏数据格式以适应数据库存储
     *
     * @param $info array 从平台获取的原始游戏数据
     *
     * @return $data array 调整格式后的游戏数据
     */
    protected function transform($info)
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
            if (empty($data['md5'])) {
                continue;
            }

            $data['entity_id'] = $item['id']; // TODO 第三方ID， 这个重构要换地方赋值

            // 获取对应过来的分类id 为0则忽略插入或更新的操作
            $cat_id = $this->cats($item['categoryId']);
            // 判断数据库中是否存在该apk对应的app记录 有就更新信息 无则创建一条记录
            $record = Apps::where('pack', $data['pack'])
                          ->where('source', 'uc')  // 只更新九游 新增的时候后面会判断是否本地（上架，添加编辑，待审）已有 待重构
                          ->orderByRaw("field(status,'stock') desc")
                          ->first();

            $format = [
                'id'        => isset($record->id) ? $record->id : 0,
                'info'      => $data,
                'cat_id'    => $cat_id,
                'avg_score' => $platform['score'],
            ];
            // 入库操作
            $this->store($format);
        }
    }

    /**
     * 数据入库
     *
     * @param $format array 调整格式后的游戏数据
     *
     * @return void
     */
    protected function store($format)
    {
        // 更新
        if (!empty($format['id'])) {
            // 去除状态信息
            unset($format['info']['status']);
            // 更新apk包信息
            Apps::where('id', $format['id'])
                ->update($format['info']);
            // 更新平均评分
            Ratings::where('app_id', $format['id'])
                   ->update(['manual' => $format['avg_score']]);
            // 分类id不为0则更新分类id
            if ($format['cat_id'] != 0) {
                AppCats::where('app_id', $format['id'])
                       ->update(['cat_id' => $format['cat_id'],]);
            }

        // 全新游戏
        } else {

            // 判断是否本地（上架，添加编辑，待审）已有, 不插入  待重构
            $record = Apps::where('pack', $format['info']['pack'])
                          ->where('source', 'lt')
                          ->whereIn('status', ['stock', 'publish', 'draft', 'pending'])
                          ->first();

            if(!empty($record->id)) {
                break;
            }

            // 随机给新添加的apk初始化下载量显示数
            $format['info']['download_manual'] = rand(70000, 100000);
            // 插入apk包信息 生成app_id
            $insert = Apps::create($format['info']);
            // 创建keywords表记录 获取关键字id
            $keyword = Keywords::create([
                'word' => $format['info']['title'],
            ]);
            // 创建app_keywords表记录 其中keyword_id是上一步操作所产生
            AppKeywords::create([
                'app_id'     => $insert->id,
                'keyword_id' => $keyword->id,
            ]);
            // 创建评分记录 插入平均评分
            Ratings::create([
                'app_id' => $insert->id,
                'title'  => $format['info']['title'],
                'pack'   => $format['info']['pack'],
                'total'  => 0,
                'counts' => 0,
                'avg'    => $format['avg_score'],
                'manual' => $format['avg_score'],
            ]);
            // 分类id不为0则创建游戏分类记录 插入分类id
            if ($format['cat_id'] != 0) {
                AppCats::create([
                    'app_id' => $insert->id,
                    'cat_id' => $format['cat_id'],
                ]);
            }
        }
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
}