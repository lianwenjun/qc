<?php

class Api_AppRecords extends \Eloquent {
    protected $fillable = ['app_id'];
    protected $table = 'app_records';
    //自增
    /*public function scopeOfIncrement($query, $key) {
        return $query->increment($key);
    }*/
}