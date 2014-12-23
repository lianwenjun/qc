<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Client extends \Eloquent {
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
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