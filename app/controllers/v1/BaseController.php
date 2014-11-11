<?php

class V1_BaseController extends \Controller {
    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
        }
    }
    public function result($content = [])
    {
        $res = [];
        $res['dataJson'] = isset($content['data']) ? $content['data']: '';
        $res['msg'] = isset($content['msg']) ? $content['msg'] : 1;
        $res['msgbox'] = isset($content['msgbox']) ? $content['msgbox'] : '';
        return json_encode($res, JSON_UNESCAPED_UNICODE);
    }

}
