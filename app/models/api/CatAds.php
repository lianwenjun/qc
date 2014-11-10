<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Api_CatAds extends \Eloquent {
    use SoftDeletingTrait;
    protected $fillable = [];
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    protected $table = 'cat_ads';
    //设置ICON
    public function setImageAttribute() {
        return $this->attributes['image'] = $this->icon; 
    }
    public function getImageAttribute() {
        return CUtil::checkHost($this->attributes['image']);
    }
}