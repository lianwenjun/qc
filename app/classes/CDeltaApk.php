<?php

use Symfony\Component\Process\Process;
use Symfony\Component\Filesystem\Filesystem;

/**
 * 给版本打增量包
 *
 */
class CDeltaApk
{
    /**
     * 生成增量包
     * @param $older string 旧的APK路径
     * @param $newer string 新的APK路径
     * @param $deltaPath string 增量包的路径
     *
     * @return string 增量包路径
     */
    public function delta($oldPath, $newPath, $deltaPath)
    {
        $command = sprintf('bsdiff %s %s %s', $oldPath, $newPath, $deltaPath);
        
        // 运行命令
        $this->_execute($command);
        // 检测文件是否存在
        if (! file_exists($deltaPath))
            return fasle;

        return $deltaPath;
    }

    /**
     * 设置增量包的保存路径
     * @param $fromVersionCode string 开始版本代号
     * @param $toVersionCode string 目标版本代号
     * @param $path string 增量包保存路径
     *
     * @return string 
     */
    public function setDeltaPath($fromVersionCode, $toVersionCode, $path)
    {
        $info = pathinfo($path);
        $filename = $info['filename'];
        
        $daltaPath = Config::get('upload.delta');
        $deltaPath .= sprintf('/%s/%s/', $filename[0], $filename[1]);
        $deltaPath .= sprintf('%s_%s_to_%s.patch', $filename, $fromVersionCode, $toVersionCode);
        
        return $deltaPath;
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
}