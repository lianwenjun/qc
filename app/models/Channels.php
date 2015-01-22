<?php

class Channels extends \Eloquent {

    protected $table = 'channels';

    protected $fillable = ['release', 'name', 'code'];


    /**
     * 获得渠道的SELECT列表
     * 
     * @return array
     */
    public function selects()
    {
        $channels = $this->all();

        $datas = [];
        foreach ($channels as $channel) {
            $datas[$channel->release] = $channel->name;
        };

        return $datas;
    }
}