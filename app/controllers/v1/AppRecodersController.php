<?php

class V1_AppRecodersController extends \V1_BaseController {
    //字段处理
    private function fileds() {
        $fields = [
            'app_id' => 'appid',
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
    /**
     * 请求
     * GET /v1/game/info/edit/downcount/request
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
        $data = $this->fileds();
        //检测输入
        $data['status'] = 'request';
        Api_RecordLog::create($data);
        $record = Api_AppRecords::firstOrCreate(['app_id' => $appId]);
        $record->increment('request');
        return $this->result(['data'=>'[]', 'msg'=>1, 'msgbox'=>'数据获取成功']); 
    }

    /**
     * 下载
     * GET /v1/game/info/edit/downcount/installed
     * @param int $appId
     * @param string imei
     * @return Json
     */
    public function download($appId, $imei)
    {
        //统计加1
        $appId = $appId;
        $data = $this->fileds();
        $data['app_id'] = $appId;
        $data['status'] = 'download';
        $data['imei'] = $imei;
        Api_RecordLog::create($data);
        $record = Api_AppRecords::firstOrCreate(['app_id' => $appId]);
        $record->increment('download');
        return $this->result(['data'=>'[]', 'msg'=>1, 'msgbox'=>'数据获取成功']);
    }

    /**
     * 安装
     * GET /v1/game/info/edit/downcount/installed
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
        $data = $this->fileds();
        $data['status'] = 'install';
        Api_RecordLog::create($data);
        $record = Api_AppRecords::firstOrCreate(['app_id' => $appId]);
        $record->increment('install');
        return $this->result(['data'=>'[]', 'msg'=>1, 'msgbox'=>'数据获取成功']);
    }
}