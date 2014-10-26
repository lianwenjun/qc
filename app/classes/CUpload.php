<?php

/**
 * 上传策略类
 *
 */
class CUpload
{

    /**
     * 实例化
     * @param $type string  CUpload文件类名
     * @param $dir  string  文件生成目录
     *
     *
     * @return Object
     */
    public function instance($type, $dir)
    {
        $class = 'CUpload_' . ucfirst($type);

        return (new $class($dir));
    }

}