<?php

/**
 * 上传App功能实现类
 *
 */

use Symfony\Component\Process\Process;
use Symfony\Component\Filesystem\Filesystem;
use JildertMiedema\LaravelPlupload\PluploadException;

class CUpload_App extends CUpload_Base implements CUpload_Interface
{
    public function __construct($dir)
    {
        parent::__construct($dir);
    }
    /**
     * 上传处理(override)
     *
     * @param $file object 上传完成的文件对象
     *
     * @return void
     */
    public function handle($file)
    {

        parent::handle($file);

        $savePath = $this->saveDir . '/' . $this->saveName;
        $data = $this->_apkParse($savePath);

        $icon = $this->_apkIcon($savePath, $data['icon']);

        $size = filesize($savePath);
        $data['size']          = (new CUtils)->friendlyFilesize($size);
        $data['size_int']      = round($size / 1024, 0);
        $data['icon']          = $icon;
        $data['download_link'] = $this->savePath;
        $data['source']        = 'lt';

        $this->data = $data;
    }

    /**
     * 执行命令行
     *
     * @param $command string 命令
     *
     * @return array 命令行返回
     */
    private function _execute($command) {

        $process = new Process($command);
        $process->setTimeout(30);
        $process->run();

        $data = [];
        if (! $process->isSuccessful()) {
            Log::error(sprintf('执行命令行: “%s” 失败', $command));
            // Log::error($process->getErrorOutput());
        } else {
            $data =  explode("\n", $process->getOutput());
        }

        return $data;
    }

    /**
     * 解析 APK 包
     *
     * @param $apkPath string APK 路径
     *
     * @return array 抓取到的数据
     */
    private function _apkParse($apkPath)
    {

        $command = 'aapt d badging ' . $apkPath;
        $data    = $this->_execute($command);

        return $this->_outputParse($data);
    }

    /**
     * 获取图片
     *
     * @param $apkPath  string APK路径
     * @param $iconPath string Icon路径
     *
     * @return $string 图片相对/public路径
     */
    private function _apkIcon($apkPath, $iconPath)
    {

        $targetPath = str_replace('.apk', '.zip', $apkPath);
        rename($apkPath, $targetPath);

        list($dir, $filename) = $this->uploadPath('icons', $iconPath);
        $savePath = $dir . '/' . $filename;

        $filesystem = new Filesystem();
        $filesystem->mkdir($dir);
        
        // 解压图标 unzip -p myapk.zip path/to/zipped/icon.png >path/to/icon.png
        $command = sprintf("unzip -p %s %s>%s", $targetPath, $iconPath, $savePath);
        $this->_execute($command);

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