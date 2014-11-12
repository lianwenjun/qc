<?php

class Api_Accounts extends \Eloquent {
    protected $guarded    = ['id'];
    protected $table = 'accounts';
    
    //字段处理
    public function fileds() {
        $fields = [
            'imei' => 'imei', 
            'uuid' => 'uuid',
            'type' => 'type',
            'ip' => 'ip',
            'os_version' => 'version',
        ];
        foreach ($fields as $key => $value) {
            $data[$key] = Input::get($value, '');
        }
        return $data;
    }
    public function ofCreate($imei = '') {
        
        if (empty($imei)){
            $data = $this->fileds();
        } else {
            $data['imei'] = $imei;
        }
        //先检测UUID
        if (!empty($data['uuid'])) {
            $account = Api_Accounts::whereUuid($data['uuid'])->first();
            if ($account){
                return $account;
            }
        } 
        if (!empty($data['imei'])) {
            //然后检测IMEI
            $account = Api_Accounts::whereImei($data['imei'])->first();
            if ($account){
                return $account;
            }
        }
        $account = Api_Accounts::create($data);
        return $account;
    }
}