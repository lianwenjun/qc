<?php

class Api_FeedbacksController extends \Api_BaseController {
    /**
     * 添加反馈
     * POST /api/v1/game/feedback/add
     * @param AppVersion int //版本代号
     * @param Content string
     * @param Device string 设备型号
     * @param IMEI string 
     * @param SystemVersion string
     * @param UserEmail string
     * @return Response string
     */
    public function store()
    {
        $fields = [
            'version' => 'AppVersion',
            'content' => 'Content',
            'type' => 'Device',
            'imei' => 'IMEI',
            'os_version' => 'SystemVersion',
            'os' => ':Android',
            'email' => 'UserEmail',
        ];
        foreach ($fields as $key => $value) {
            if (isset($value[0]) && ($value[0] == ':') ) {
                $data[$key] => $value;
            } else {
                $data[$key] => Input::get($value, '');
            }
        }
        $valid = (new Api_Feedbacks)->isValid($data);
        if (!$valid) {
            return $this->result(['data'=>'[]', 'msg'=>0, 'msgbox'=>'添加失败']);
        }
        $feedback = Api_Feedbacks::create($data);
        if ($feedback) {
            return $this->result(['data'=>'[]', 'msg'=>1, 'msgbox'=>'添加成功']);
        }
        return $this->result(['data'=>'[]', 'msg'=>0, 'msgbox'=>'添加失败']);
    }
}