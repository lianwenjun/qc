<?php
/**
 * APP 队列处理
 */

class AppQueue {

    /**
     * default
     *
     */
    public function fire($job, $data)
    {
        //
    }

    /**
     * 获取APP MD5值
     *
     * @param $job  obj   queue 对象
     * @param $data array 队列传入参数
     *
     * @return void
     */
    public function md5($job, $data)
    {
        $filename = $data['filename'];
        $md5 = md5_file(public_path() . $filename);

        $app = Apps::find($data['id']);
        $app->md5 = $md5;
        $app->save();
    }
}