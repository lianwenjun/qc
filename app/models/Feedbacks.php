<?php

class Feedbacks extends \Eloquent {
    protected $fillable = [];
    protected $table = 'feedbacks';
    protected $softDelete = true;
    public $pageSize = 16;

    /**
     * 应用反馈列表
     *
     * @param $data array 条件数据
     *
     * @return obj 反馈列表对象
     **/
    public function lists($data)
    {
        $query = Feedbacks::select('id', 'type', 'imei', 'version', 'email', 'content', 'created_at');
        $query = (new CFeedback)->queryParse($query, $data);
        $list = $query->orderBy('created_at')->paginate($this->pageSize);

        return $list;
    }

}