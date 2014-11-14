<?php

class Api_LogTables extends \Eloquent {
    protected $fillable = [];
    protected $connection = 'logs';
    protected $table = 'logtables';
    
    public function scopeOfCount($query, $count) {
        return $query->where('count', '<', $count);
    }

    public function scopeAddCount($query) {
        return $query->increment('count');
    }
}