<?php

class V1_ClientController extends \V1_BaseController {

    /**
     * APP客户端版本匹配
     * GET /v1/appclient/ver/info/{versionCode}
     * @param int $versionCode
     * @return Json
     */
    public function checkVersion($versionCode)
    {
        $fields = [
            'addTime' => 'AddTime', //
            'downUrl' => 'DownUrl', //
            'id' => 'Id',
            'md5' => 'MD5',
            'size' => 'Size', //
            'changes' => 'UpdateContent',
            'version' => 'Version',
            'version_code' => 'VersionCode',
        ];
        $release = Input::get('release', '');
        
        $new = Api_Client::ofNew($versionCode)->whereRelease($release)->first();
        if (!$new) {
            return $this->result(['data' => null, 'msg' => 0, 'msgbox' => '已是最新版本']);
        }
        // 到处都有这结构，如何破
        $data = [];
        $new = $new->toArray();
        foreach ($fields as $key => $value) {
            $data[$value] = '';
        }
        foreach ($new as $key => $value) {
            if (isset($fields[$key])) $data[$fields[$key]] = $value;
        }
        
        return $this->result(['data' => $data, 'msg' => 1, 'msgbox' => '有新的版本可用']);
    }
}