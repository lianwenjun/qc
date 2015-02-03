<?php

class Darwin_BaseController extends \Controller {

    /**
     * 基础配置数据获取
     * GET /api/base 
     *
     * @return json
     */
    public function base()
    {
        // 解析params参数
        $salt = str_random(10); // 随机10个
        $launch_image = [];
        $server_host = '';
        $ucenter_host = '';
        $forum_host = '';
        $images_host = '';
        $apks_host = '';
        $update = [];
        $pages_analysis_limit = 10;
        $buttons_analysis_limit = 10;
    }

    /**
     * 返回结果
     *
     * @return json
     */
    public function result($content = [])
    {
        $res = [];
        $res['data'] = isset($content['data']) ? $content['data']: '';
        $res['status'] = isset($content['status']) ? $content['status'] : 1;
        $res['message'] = isset($content['message']) ? $content['message'] : '';
        //return $res;
        return json_encode($res, JSON_UNESCAPED_UNICODE);
    }
}