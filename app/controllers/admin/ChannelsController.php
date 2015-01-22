<?php

class Admin_ChannelsController extends \Admin_BaseController {
    /**
     * 新增 渠道号
     * POST /admin/channels
     *
     * @return Response
     */
    public function store()
    {
        $data = [
            'name' => Input::get('name'),
            'code' => Input::get('code')
        ];
        $channel = Channels::create($data);
        $channel->release = $channel->id - 1; // 设置releas因为是从0开始的
        $channel->save();

        return ['status' => 'ok'];

    }

}