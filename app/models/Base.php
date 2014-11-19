<?php

class Base extends \Eloquent {

    /**
     * 操作日志记录
     * 
     * @param $logData array 记录的数据
     *
     * @return $id 新增日志ID 
     **/
    public static function dolog($logData)
    {
        // 获取用户信息
        $username = Sentry::getUser()->username;
        $realname = Sentry::getUser()->realname;
        $ip_address = Request::server('REMOTE_ADDR');

        // 存入日志数据
        $id = DB::table('action_logs')->insertGetId([
            'username'     => $username,
            'realname'     => $realname,
            'ip_address'   => $ip_address,
            'action_field' => isset($logData['action_field']) ? $logData['action_field'] : '',
            'description'  => isset($logData['description']) ? $logData['description'] : '',
            'created_at'   => date('Y-m-d H:i:s', time()),
        ]);

        return $id;
    }
}