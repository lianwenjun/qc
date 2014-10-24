<?php

/**
 * 上传Image功能实现类
 *
 */
class CUpload_Image extends CUpload_Base implements CUpload_Interface
{

    // 上传目录
    const DIR = 'pictures';

    public function __construct()
    {
        parent::__construct(self::DIR);
    }

}