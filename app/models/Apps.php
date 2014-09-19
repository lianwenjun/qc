<?php

class Apps extends \Eloquent {

    protected $table = 'apps';

    protected $fillable = [];


    // 
    function lists($data) {

        return Apps::whereIn('status', $data['status'])->get();
    }
}