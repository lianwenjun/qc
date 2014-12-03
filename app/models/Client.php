<?php

class Client extends \Eloquent {
    protected $fillable = ['download_link',
            'title',
            'md5',
            'size_int',
            'changes',
            'version',
            'version_code',
            'release',
            ];
    protected $table = 'client';
}