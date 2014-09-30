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
        'start-created_at',
        'end-created_at',
        'cate_id',
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
     * 解析条件
     *
     * @param $query obj   query
     * @param $data  array 条件数据
     *
     * @return obj query
     */
    public function queryParse($query, $data)
    {

        foreach($data as $key => $value) {

            if(! in_array($key, $this->searchEnable)) break;

            if($key == 'title' && !empty($value)) {
                $query->where('title', 'like', '%' . $value . '%');
            }

            if($key == 'cate_id' && !empty($value)) {
                $query->whereRaw("`id` in (select `app_id` from `app_cates` where `cate_id` = '{$value}')");
            }

            if(strpos($key, 'start') === 0 && !empty($value)) {
                $field = str_replace('start-', '', $key);
                $query->where($field, '>=', $value);
            }

            if(strpos($key, 'end') === 0 && !empty($value)) {
                $field = str_replace('end-', '', $key);
                $query->where($field, '<=', date('Y-m-d', strtotime($value) + 24 * 3600));
            }

        }

        $query->orderBy('sort', 'desc');

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

        return Apps::find($id)->update($data);
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

            if(empty($dontSave)) Apps::create($data);

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

        return json_decode(json_encode($info), FALSE);;
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