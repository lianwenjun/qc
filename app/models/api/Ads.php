<?php

class Api_Ads extends \Eloquent {
    protected $fillable = [];
    protected $table = 'ads';

    //是否置顶
    /*
    * @param query sql
    * @param type  是否置顶，默认为yes
    */
    public function scopeIsTop($query, $type='yes') {
        return $query->where('is_top', $type); 
    }
    //是否上架
    /*
    * @param query sql
    * @param type  是否上架类型，默认为yes
    */
    public function scopeIsStock($query, $type='yes') {
        return $query->where('is_stock', $type); 
    }
    
    //设置ICON
    public function setImageAttribute() {
        return $this->attributes['image'] = $this->icon; 
    }
    public function getImageAttribute() {
        return CUtil::checkHost($this->attributes['image']);
    }
}