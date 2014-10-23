<?php

use Symfony\Component\Process\Process;
use Symfony\Component\Filesystem\Filesystem;

class CatAds extends \Eloquent {

    protected $table = 'cat_ads';
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