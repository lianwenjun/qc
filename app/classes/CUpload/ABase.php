<?php

/**
 * 上传基础类
 */
abstract class CUpload_ABase implements CUpload_Interface
{
    public $saveDir     = '';
    public $saveName    = '';
    public $savePath    = '';
    public $data        = [];
    private $_uploadDir = '';

    public function __construct($uploadDir)
    {
        $this->_uploadDir = $uploadDir;
    }

    /**
     * 上传
     *
     * @return object
     */
    public function upload()
    {
        $data = [];
        $uploader = Plupload::receive('file', function($file) {

            $this->handle($file);

            return [
                'path'     => $this->savePath,
                'fullPath' => $this->rootPath(),
                'data'     => $this->data()
                ];
        });

        return $uploader;
    }

    /**
     * 上传处理
     *
     * @param $file object 上传完成的文件对象
     *
     * @return void
     */
    abstract public function handle($file);

    /**
     * 获得上传 hash 目录
     * 
     * @param $type     string 上传目录配置
     * @param $filename string 文件名
     *
     * @return array 上传目录 ['dir', 'filename']
     */
    abstract public function uploadPath($type, $filename);

    /**
     * 定义存放目录以及文件名
     *
     * @param $originName string 原文件名
     *
     * @return void
     */
    public function saveInfo($originaName)
    {
        list($saveDir, $saveName) = $this->uploadPath($this->_uploadDir, $originaName);

        $this->saveDir  = $saveDir;
        $this->saveName = $saveName;
    }

    /**
     * 获取存放路径
     *
     * @return string 相对public路径
     */
    public function path()
    {
        return $this->savePath;
    }

    /**
     * 根目录路径
     *
     * @return string 服务器文件系统路径
     */
    public function rootPath()
    {
        return $this->saveDir . '/' . $this->saveName;;
    }

    /**
     * 构造返回信息
     *
     * @return json
     */
    public function data()
    {
        return $this->data;
    }

}