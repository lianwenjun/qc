<?php
//文件上传区
class Admin_Cupload {
    //广告图片上传     
    public function adsImageUpload() {
        return Plupload::receive('file', function ($file)
        {
            list($dir, $filename) = uploadPath('ads', $file->getClientOriginalName());
            $file->move($dir, $filename);

            $savePath = $dir . '/' . $filename;

            return str_replace(public_path(), '', $savePath);
        });
    }
    //分类图片上传
    public function cateImageUpload() {
        return Plupload::receive('file', function ($file)
        {
            list($dir, $filename) = uploadPath('cateads', $file->getClientOriginalName());
            $file->move($dir, $filename);

            $savePath = $dir . '/' . $filename;

            return str_replace(public_path(), '', $savePath);
        });
    }
}
