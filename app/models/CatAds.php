<?php

use Symfony\Component\Process\Process;
use Symfony\Component\Filesystem\Filesystem;

class CatAds extends \Eloquent {

    protected $table = 'cat_ads';
    protected $fillable = [];

    public $updateRules = [
        'image' => 'required'
    ];
}