<?php

class Tp_BaseController extends Controller
{
    /**
     * 返回JSON数据
     */
    public function retJson($info = [])
    {
        $ret['success'] = isset($info['success']) ? $info['success'] : false;
        $ret['msg']     = isset($info['msg']) ? $info['msg'] : '';
        $ret['data']    = isset($info['data']) ? $info['data'] : [];

        die(json_encode($ret, JSON_UNESCAPED_UNICODE));
    }
}