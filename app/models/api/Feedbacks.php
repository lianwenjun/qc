<?php

class Api_Feedbacks extends \Eloquent {
    protected $fillable = [];
    protected $table = 'feedbacks';

    public function isValid($input) {
        $rules = [
            'version' => 'required',
            'content' => 'required',
            'type' => 'required',
            'imei' => 'required',
            'os_version' => 'required',
            'os' => 'required',
            'email' => 'required'
        ];
        //返回消息没了
        return Validator::make($input, $rules)->passes();
    }
}