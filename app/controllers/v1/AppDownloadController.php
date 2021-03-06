<?php

class V1_AppDownloadController extends \V1_BaseController {
    //字段处理
    private function fileds() {
        $fields = [
            'app_id' => 'appid',
            'ip' => 'ip',
            'channel' => 'channel',
        ];
        foreach ($fields as $key => $value) {
            $data[$key] = Input::get($value, '');
        }
        return $data;
    }
    /**
     * 请求
     * GET /v1/game/info/edit/download/request
     * @param int appid
     * @param string imei
     * @param string uuid
     * @param string type
     * @param string ip
     * @param int version
     * @return Json
     */
    public function request()
    {
        //统计加1
        $appId = Input::get('appid');
        if (is_null($appId) || is_null(Input::get('uuid')) || is_null(Input::get('imei'))) {
            return $this->result(['data'=>'[]', 'msg'=>0, 'msgbox'=>'输入参数不能为空']); 
        }
        $app = Api_Apps::whereStatus('stock')->find($appId);
        if (!$app) {
            return $this->result(['data'=>'[]', 'msg'=>0, 'msgbox'=>'游戏不存在']);
        }
        
        $data = $this->fileds();
        $data['status'] = 'request';
        $account = (new Api_Accounts)->ofCreate();
        
        $data['account_id'] = $account->id;

        // -----add by RavenLee-----
        $data['client_version'] = Input::get('client_version', '1.2-');
        // -----add end-----

        $model = new Api_AppDownloadLogs();
        foreach ($data as $key => $value) {
            $model->$key = $value;
        }
        $model->save();
        $model->addCount();
        return $this->result(['data'=>'[]', 'msg'=>1, 'msgbox'=>'数据获取成功']); 
    }

    /**
     * 下载
     * GET /v1/game/info/edit/downcount/{appid}/{imei}
     * @param int $appId
     * @param string imei
     * @return Json
     */
    public function download($appId, $imei)
    {
        //统计加1
        if (is_null($appId)) {
            return $this->result(['data'=>'[]', 'msg'=>0, 'msgbox'=>'游戏ID不能为空']); 
        }
        $app = Api_Apps::whereStatus('stock')->find($appId);
        if (!$app) {
            return $this->result(['data'=>'[]', 'msg'=>0, 'msgbox'=>'游戏不存在']);
        }
        
        $data = $this->fileds();
        $data['app_id'] = $appId;
        $data['status'] = 'download';
        $account = (new Api_Accounts)->ofCreate($imei);
        
        $data['account_id'] = $account->id;

        // -----add by RavenLee-----
        $data['client_version'] = Input::get('client_version', '1.2-');
        // -----add end-----

        $model = new Api_AppDownloadLogs();
        foreach ($data as $key => $value) {
            $model->$key = $value;
        }
        $model->save();
        $model->addCount();
        return $this->result(['data'=>'[]', 'msg'=>1, 'msgbox'=>'数据获取成功']);
    }

    /**
     * 安装
     * GET /v1/game/info/edit/download/installed
     * @param int appid
     * @param string imei
     * @param string uuid
     * @param string type
     * @param string ip
     * @param int version
     * @return Json
     */
    public function installed()
    {
        //统计加1
        $appId = Input::get('appid');
        if (is_null($appId)) {
            return $this->result(['data'=>'[]', 'msg'=>0, 'msgbox'=>'游戏ID不能为空']); 
        }
        $app = Api_Apps::whereStatus('stock')->find($appId);
        if (!$app) {
            return $this->result(['data'=>'[]', 'msg'=>0, 'msgbox'=>'游戏不存在']);
        }
        $data = $this->fileds();
        $data['status'] = 'install';
        
        $account = (new Api_Accounts)->ofCreate();
        $data['account_id'] = $account->id;

        // -----add by RavenLee-----
        $data['client_version'] = Input::get('client_version', '1.2-');
        // -----add end-----
        
        $table = Config::get('db_downloadlogs.table');
        $model = new Api_AppDownloadLogs($table);
        foreach ($data as $key => $value) {
            $model->$key = $value;
        }
        $model->save();
        $model->addCount();
        return $this->result(['data'=>'[]', 'msg'=>1, 'msgbox'=>'数据获取成功']);
    }
}