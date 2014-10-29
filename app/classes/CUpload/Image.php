<?php

/**
 * 上传Image功能实现类
 *
 */
class CUpload_Image extends CUpload_ABase implements CUpload_Interface
{
    public function __construct($dir)
    {
        parent::__construct($dir);
    }

    /**
     * 上传处理
     *
     * @param $file object 上传完成的文件对象
     *
     * @return void
     */
    public function handle($file)
    {
        $this->saveInfo($file->getClientOriginalName());
        $file->move($this->saveDir, $this->saveName);
        $rootPath = $this->rootPath();

        $this->savePath = str_replace(public_path(), '', $rootPath);
    }

    /**
     * 获得上传 hash 目录
     * 
     * @param $type     string 上传目录配置
     * @param $filename string 文件名
     *
     * @return array 上传目录 ['dir', 'filename']
     */
    public function uploadPath($type, $filename)
    {

        $config = Config::get('upload');
        if(! in_array($type, array_keys($config))) {
            $dir = public_path() . '/uploads';
            return [$dir, $filename];
        }

        $hash  = md5(microtime(true));
        $hashs = str_split($hash);
        $dir   = public_path() . Config::get('upload.'.$type);

        $dir    .=  sprintf('/%s/%s', $hashs[0], $hashs[1]);
        $info    = pathinfo($filename);
        $newName = sprintf('%s.%s', $hash, $info['extension']);

        return [$dir, $newName];
    }

}