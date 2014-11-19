<?php

class Logs extends \Eloquent {

    protected $table = 'action_logs';

    /**
     * 日志查询列表
     *
     * @param $data array 条件数据
     *
     * @return obj 反馈列表对象
     **/
    public function lists($data)
    {
        $columns = ['id', 'username', 'realname', 'ip_address', 'action_field', 'description', 'created_at'];
        $query = Logs::select($columns);
        $query = (new CLog)->queryParse($query, $data);
        
        return $query;
    }

}