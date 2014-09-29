<?php

use Symfony\Component\Process\Process;
use Symfony\Component\Filesystem\Filesystem;

class CateAds extends \Eloquent {

    protected $table = 'cate_ads';
    protected $fillable = [];

    public $updateRules = [
        'image' => 'required'
    ];

    public function imageUpload() {
        return Plupload::receive('file', function ($file)
        {
            list($dir, $filename) = uploadPath('cateads', $file->getClientOriginalName());
            $file->move($dir, $filename);

            $savePath = $dir . '/' . $filename;

            return str_replace(public_path(), '', $savePath);
        });
    }
}