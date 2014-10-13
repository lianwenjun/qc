<?php

use Symfony\Component\Process\Process;
use Symfony\Component\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Apps extends \Eloquent {

    use SoftDeletingTrait;

    protected $table      = 'apps';
    protected $dates      = ['deleted_at'];
    protected $softDelete = true;
    protected $guarded    = ['id'];

    // 验证规则
    public $rules = [
        'draft'   => [],
        'pending' => [
            'cates'           => 'required',
            'os_version'      => 'required',
            'version_code'    => 'required',
            'sort'            => 'required',
            'download_manual' => 'required',
            'summary'         => 'required',
            'images'          => 'required',
            'changes'         => 'required|',
        ],
    ];

    // 可以搜索字段
    public $searchEnable = [
        'title',
        'cate_id',
        'pack',
        'version',
        'size_int',
        'created_at',
        'updated_at',
        'onshelfed_at',
        'offshelfed_at'
    ];

    // 可以排序的字段
    public $orderEnable = [
        'size_int',
        'download_counts',
        'onshelfed_at'
    ];

    /**
     * 游戏列表
     *
     * @param $status array 状态
     * @param $data   array 条件数据
     *
     * @return obj 游戏列表对象
     */
    public function lists($status, $data)
    {
        $query = Apps::whereIn('status', $status);

        return $this->queryParse($query, $data);
    }

    /**
     * 解析前处理
     *
     * 可选字段预处理，$data数据里面 type 索引必须放在 keyword 前面
     *
     * @param $data array 条件数据
     *
     * @return array
     */
    public function beforeQueryParse($data)
    {
        $field = '';
        foreach ($data as $key => $value) {
            if($key == 'type' && !empty($value)) {
                $data[$value] = '';
                $field = $value;
            }

            if($key == 'keyword' && !empty($value) && !empty($field)) {
                $data[$field] = $value;
            }
        }

        if(isset($data['type'])) unset($data['type']);
        if(isset($data['keyword'])) unset($data['keyword']);

        return $data;
    }

    /**
     * 解析条件
     *
     * @param $query obj   query
     * @param $data  array 条件数据
     *
     * @return obj query
     */
    public function queryParse($query, $data)
    {

        $data = $this->beforeQueryParse($data);

        foreach($data as $key => $value) {

            if(! in_array($key, $this->searchEnable)) break;

            if($key == 'title' && !empty($value)) {
                $query->where('title', 'like', '%' . $value . '%');
            } elseif($key == 'cate_id' && !empty($value)) {
                $query->whereRaw("`id` in (select `app_id` from `app_cates` where `cate_id` = '{$value}')");
            } elseif(is_array($value) && count($value) == 2) { // 查询范围

                // 处理空值
                $unique = array_unique($value);
                if(isset($unique[0]) && !empty($unique[0])) {

                    // 时间处理
                    if(substr($key, -3) == '_at') {
                        $value[1] = date('Y-m-d', strtotime($value[1]) + 24 * 3600);
                    }

                    // 占空间大小处理
                    if($key == 'size_int') {
                        foreach($value as $k => $v) {
                            if(substr($v, -1) == 'm' || substr($v, -1) == 'M') {
                                $value[$k] = intval($v) * 1024;
                            } elseif(substr($v, -1) == 'g' || substr($v, -1) == 'G') {
                                $value[$k] = intval($v) * 1024 * 1024;
                            } else {
                                $value[$k] = intval($v);
                            }
                        }
                    }

                    $query->whereBetween($key, $value);
                }

            } elseif (!empty($value)) {
                $query->where($key, $value);
            }
        }

        // 排序
        if(isset($data['orderby'])) {
            $orderby = explode('.', $data['orderby']);
            if(
                in_array($orderby[0], $this->orderEnable)
                && isset($orderby[1])
                && !empty($orderby[1])
              ) {
                $query->orderBy($orderby[0], $orderby[1]);
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        return $query;
    }

    /**
     * 修改入库
     *
     * @param $id     int    游戏ID
     * @param $status string 状态
     * @param $data   array  put 数据
     *
     * @return boolean
     */
    public function store($id, $status, $data)
    {

        // 处理关键字
        if(isset($data['keywords'])) {
            $keywordsModel = new Keywords;
            $keywordsModel->store($data['keywords'], $id);
        }

        // 处理分类/标签
        if(isset($data['cates'])) {
            $appCatesModel = new AppCates;
            $appCatesModel->store($id, $data['cates']);
        }

        // 处理图片
        if(isset($data['images'])) {
            $data['images'] = serialize($data['images']);
        }

        // 处理状态
        $data['status'] = $status;

        $data['has_ad']    = isset($data['has_ad']) ? 'yes' : 'no';
        $data['is_verify'] = isset($data['is_verify']) ? 'yes' : 'no';

        $fields = Schema::getColumnListing('apps');
        foreach($data as $field => $value) {
            if(! in_array($field, $fields) ) {
                unset($data[$field]);
            }
        }

        // 处理历史
        if($status == 'onshelf') {
            $this->history($id);
        }

        return Apps::find($id)->update($data);
    }

    /**
     * 保存到历史
     *
     * @param $id int 游戏ID
     *
     * @return void
     */
    public function history($id) {
        $app = Apps::find($id)->toArray();

        $app['app_id'] = $id;
        unset($app['id']);
        
        $catesModel = new Cates;
        $app['cates'] = serialize($catesModel->appCates($id));
        $app['tags'] = serialize($catesModel->appTags($id));

        // TODO 处理操作人

        Histories::create($app);
    }


    /**
     * 上传APK
     *
     * @param $dontSave string 是否要入库（空是入库）
     *
     * @return string 上传结果
     */
    public function appUpload($dontSave)
    {
        return Plupload::receive('file', function ($file) use ($dontSave)
        {
            list($dir, $filename) = uploadPath('apks', $file->getClientOriginalName());
            $file->move($dir, $filename);

            $savePath = $dir . '/' . $filename;
            $data = $this->apkParse($savePath);
            $icon = $this->apkIcon($savePath, $data['icon']);

            $data['size']          = friendlyFilesize(filesize($savePath));
            $data['size_int']      = round(filesize($savePath) / 1024, 0);
            $data['icon']          = $icon;
            $data['download_link'] = str_replace(public_path(), '', $savePath);

            if(empty($dontSave)) {
                $app = Apps::create($data);

                $rating = [
                        'app_id' => $app->id, 
                        'title'  => $data['title'], 
                        'pack'   => $data['pack']
                    ];
                Ratings::create($rating);
            }

            return $data;
        });
    }

    /**
     * 上传图片
     *
     * @return string 上传后路径
     */
    public function imageUpload()
    {
        return Plupload::receive('file', function ($file)
        {
            list($dir, $filename) = uploadPath('pictures', $file->getClientOriginalName());
            $file->move($dir, $filename);

            $savePath = $dir . '/' . $filename;

            return str_replace(public_path(), '', $savePath);
        });
    }

    /**
     * 获取单个游戏信息
     *
     * @param $id int 游戏ID
     *
     * @return mix
     */
    public function info($id)
    {

        $info = Apps::find($id)->toArray();

        if(empty($info)) return false;

        $catesModel = new Cates;
        $info['cates']  = $catesModel->appCates($id);
        $info['tags']   = $catesModel->appTags($id);
        $info['images'] = unserialize($info['images']);

        $keywordsModel = new Keywords;
        $info['keywords'] = $keywordsModel->appKeywords($id);

        return json_decode(json_encode($info), FALSE);
    }

    /**
     * 预览游戏 
     *
     * @param $id int 游戏ID
     *
     * @return mix
     */
    public function preview($id)
    {
        $info = $this->info($id);

        if(empty($info)) return false;

        // 同作者游戏
        $info->sameAuthor = $this->sameAuthor($id, $info->author);

        // 同类游戏
        $info->sameCate = $this->sameCate($id, $info->cates);

        return json_decode(json_encode($info), TRUE);;
    }

    /**
     * 作者游戏
     *
     * @param $id     int    游戏id
     * @param $author string 游戏作者
     * @param $limit  int    数量
     *
     * @return array
     */
    public function sameAuthor($id, $author, $limit = 3)
    {
        $apps = Apps::where('author', $author)
                    ->where('id', '!=', $id)
                    ->limit($limit)
                    ->select(['id', 'title', 'icon'])
                    ->get()
                    ->toArray();

        return $apps;
    }

    /**
     * 同分类游戏
     *
     * @param $id    int   游戏id
     * @param $cates array 分类信息
     * @param $limit int   数量
     *
     * @return array
     */
    public function sameCate($id, $cates, $limit = 3)
    {

        $appCatesModel = new AppCates;
        $ids = $appCatesModel->sameCateAppId($id, $cates, $limit);

        if(empty($ids)) return [];

        $apps = Apps::whereIn('id', $ids)
                    ->select(['id', 'title', 'icon'])
                    ->get()
                    ->toArray();

        return $apps;
    }

    /**
     * 解析 APK 包
     *
     * @param $apkPath string APK 路径
     *
     * @return array 抓取到的数据
     */
    public function apkParse($apkPath)
    {

        $process = new Process('aapt d badging ' . $apkPath);
        $process->setTimeout(30);
        $process->run();

        $data = [];
        if (! $process->isSuccessful()) {
            Log::error('使用 AAPT 解析 APK 包错误');
            // Log::error($process->getErrorOutput());
        } else {

            $output = explode("\n", $process->getOutput());
            $data = $this->_outputParse($output);
        }

        return $data;
    }

    /**
     * 获取图片
     *
     * @param $apkPath  string APK路径
     * @param $iconPath string Icon路径
     *
     * @return $string 图片相对/public路径
     */
    public function apkIcon($apkPath, $iconPath)
    {

        $targetPath = str_replace('.apk', '.zip', $apkPath);
        rename($apkPath, $targetPath);

        list($dir, $filename) = uploadPath('icons', $iconPath);
        $savePath = $dir . '/' . $filename;

        $filesystem = new Filesystem();
        $filesystem->mkdir($dir);
        
        // 解压图标 unzip -p myapk.zip path/to/zipped/icon.png >path/to/icon.png
        $command = sprintf("unzip -p %s %s>%s", $targetPath, $iconPath, $savePath);
        $process = new Process($command);
        $process->setTimeout(10);
        $process->run();
        if (! $process->isSuccessful()) {
            $savePath = '';
            Log::error('使用 UNZIP 解压 APK 包错误');
            // Log::error($process->getErrorOutput());
        }

        rename($targetPath, $apkPath);

        return str_replace(public_path(), '', $savePath);
    }

    /**
     * 解析 aapt 命令行输出
     *
     * @param $output string 输出文本
     *
     * @return array
     */
    private function _outputParse($output)
    {

        $data = [];
        foreach ($output as $line) {

            // package: name='com.fontlose.tcpudp' versionCode='6' versionName='1.50'
            $regex = '/^package: name=\'(.+)\' versionCode=\'(\d+)\' versionName=\'(.+)\'$/';
            preg_match($regex, $line, $matches);
            if(! empty($matches)) {
                $data['pack']         = $matches[1];
                $data['version_code'] = $matches[2];
                $data['version']      = $matches[3];
            }

            // application-label:'网络调试助手'
            preg_match('/^application-label:\'(.+)\'$/', $line, $matches);
            if(! empty($matches)) {
                $data['title'] = $matches[1];
            }

            // application-label-zh_CN:'网络调试助手'
            preg_match('/^application-label-zh_CN:\'(.+)\'$/', $line, $matches);
            if(! empty($matches)) {
                $data['title'] = $matches[1];
            }

            // application: label='心情调节器' icon='res/drawable-hdpi/logo.png'
            preg_match('/^application: label=\'.+\' icon=\'(.+)\'$/', $line, $matches);
            if(! empty($matches)) {
                $data['icon'] = $matches[1];
            }

        }

        return $data;
    }

}