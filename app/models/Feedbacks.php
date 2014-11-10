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
        $listCol = ['id', 'type', 'imei', 'version', 'email', 'content', 'created_at'];
        $query = Feedbacks::select($listCol);
        $query = (new CFeedback)->queryParse($query, $data);

        return $query;
    }

}