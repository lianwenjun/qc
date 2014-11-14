<?php

class Feedbacks extends \Eloquent {

    /**
     * 应用反馈列表
     *
     * @param $data array 条件数据
     *
     * @return obj 反馈列表对象
     **/
    public function lists($data)
    {
        $selectLists = ['id', 'type', 'imei', 'version', 'email', 'content', 'created_at'];
        $query = Feedbacks::select($selectLists);
        $query = (new CFeedback)->queryParse($query, $data);

        return $query;
    }

}