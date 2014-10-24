<?php

/**
 * 上传统一接口类
 *
 */
interface CUpload_Interface
{
    public function upload();
    public function handle($file);
    public function uploadPath($type, $filename);
    public function path();
    public function data();
}