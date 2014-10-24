<?php

/**
 * 上传类
 *
 */
class CUpload
{

    /**
     * 实例化
     *
     */
    public function instance($type)
    {
        $class = 'CUpload_' . ucfirst($type);

        return (new $class);
    }

}