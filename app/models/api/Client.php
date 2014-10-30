<?php

class Api_Client extends \Eloquent {
    protected $fillable = [];
    protected $table = 'client';
    protected $appends = ['addTime', 'downUrl'];
    //获得新的
    public function scopeOfNew($query, $versionCode) {
        return $query->where('version_code', '>', $versionCode)
                    ->orderBy('version_code', 'desc');
    }
    //检测是否存在
    public function scopeOfHas($query, $versionCode) {
        return $query->where('version_code', $versionCode);
    }
    //添加时间格式化
    public function getAddTimeAttribute() {
        return date('Y/m/d H:i:s', strtotime($this->created_at));
    }
    //下载地址检测
    public function getDownUrlAttribute() {
        return CUtil::checkHost($this->download_link);
    }
}