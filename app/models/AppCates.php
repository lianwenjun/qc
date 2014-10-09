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

    /**
     * 获取同分类游戏ID
     *
     * @param $id    int   游戏ID
     * @param $cates array 分类数据 [['id' => 1, 'title' => 'xxx']]
     * @param $limit int   数量
     *
     * @return array [1,2,3]
     */
    public function sameCateAppId($id, $cates, $limit)
    {
        $cateIds = [0]; // 初始值防止空值报错
        foreach($cates as $cate) {
            $cateIds[] = $cate->id;
        }

        $appCates = AppCates::whereIn('cate_id', $cateIds)
                            ->where('app_id', '!=', $id)
                            ->limit($limit)
                            ->select('app_id')
                            ->get()
                            ->toArray();
        $ids = [];
        foreach($appCates as $appCate) {
            $ids[] = $appCate['app_id'];
        }

        return $ids;
    }

}