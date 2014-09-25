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

    /**
     * 游戏列表
     *
     * @param $status array 状态
     *
     * @return obj 游戏列表对象
     */
    public function lists($status)
    {
        $query = Apps::whereIn('status', $status);

        return $query->get();
        // $this->queryParse($query);
    }

    /**
     * 解析条件
     *
     */
    public function queryParse($query)
    {

        $title = Input::get('title');
        if(! empty($title) ) {
            $query->where('title', 'like', '%' . $title . '%');;
        }

        $startime = Input::get('start');

        // TODO:


    }

    /**
     * 新上传 APK 入库
     *
     * @param $data array 解析到的数组
     *
     * @return void
     */
    public function store($data)
    {
        Apps::create($data);
    }


    /**
     * 上传APK
     *
     * @return string 上传结果
     */
    public function appUpload() 
    {
        return Plupload::receive('file', function ($file)
        {
            list($dir, $filename) = uploadPath('apks', $file->getClientOriginalName());
            $file->move($dir, $filename);

            $savePath = $dir . '/' . $filename;
            $data = $this->apkParse($savePath);
            $icon = $this->apkIcon($savePath, $data['icon']);

            $data['size']          = round(filesize($savePath) / 1024);
            $data['icon']          = $icon;
            $data['download_link'] = str_replace(public_path(), '', $savePath);

            $this->store($data);

            return 'ready';
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

        $info = Apps::find($id);
        if(empty($info)) return false;

        
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
                $data['pack']    = $matches[1];
                // $data['code']    = $matches[2];
                $data['version'] = $matches[3];
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