<?php

class Api_Feedbacks extends \Eloquent {
    protected $fillable = ['version', 'content', 'type', 'imei', 'os_version', 'os', 'email'];
    protected $table = 'feedbacks';

    public function isValid($input) {
        $rules = [
            'version' => 'required',
            'content' => 'required',
            'type' => 'required',
            'imei' => 'required',
            'os_version' => 'required',
            'os' => 'required',
        ];
        //返回消息没了
        return Validator::make($input, $rules)->passes();
    }
}