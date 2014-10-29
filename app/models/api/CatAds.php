<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Api_CatAds extends \Eloquent {
    use SoftDeletingTrait;
    protected $fillable = [];
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    protected $table = 'cat_ads';
}