<?php

/**
 * 上传Image功能实现类
 *
 */
class CUpload_Image extends CUpload_Base implements CUpload_Interface
{
    public function __construct($dir)
    {
        parent::__construct($dir);
    }

}