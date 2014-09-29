<?php

class AppCates extends \Eloquent {

    protected $table      = 'app_cates';
    protected $dates      = ['deleted_at'];
    protected $guarded    = ['id'];


    /**
     * 分类/标签关系保存
     *
     * @param $id       int 游戏ID
     * @param $cateIds array 分类/标签ID数组
     *
     * @return void
     **/
    public function store($id, $cateIds)
    {

        AppCates::where('app_id', $id)->delete();
        foreach ($cateIds as $cateId) {

            $data = ['app_id' => $id, 'cate_id' => $cateId];
            AppCates::create($data);
        }
    }

}