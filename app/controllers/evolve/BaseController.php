<?php

class Evolve_BaseController extends Controller
{
    /**
     * layout设置.
     *
     * @var layout
     */
    protected $layout   = 'evolve.layout';

    /**
     * 翻页条数.
     *
     * @var pageSize
     */
    protected $pageSize = '20';
    
    /**
     * 设置laytou在controller里.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if ( ! is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

    /**
     * 初始化
     * 设置用户Id,用户Name
     *
     * @return void
     */
    public function __construct()
    {
        if (Sentry::check()) {
            $this->userId = Sentry::getUser()->id;
            $this->username = Sentry::getUser()->username;
        } else {
            $this->userId = 0;
            $this->username = '系统';
        }
    }

    /**
     * 后台数据接口格式
     *
     * @param $content array
     *
     * @return json 
     */
    protected function result($content = [])
    {
        $res = [];
        $res['success'] = isset($content['success']) ? $content['success']: 'true';
        $res['msg'] = isset($content['msg']) ? $content['msg'] : '';
        $res['data'] = isset($content['data']) ? $content['data'] : '';
        return json_encode($res);
    }
}