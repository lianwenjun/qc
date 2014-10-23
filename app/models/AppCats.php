<?php

class AppCats extends \Eloquent {

    protected $table      = 'app_cats';
    protected $dates      = ['deleted_at'];
    protected $guarded    = ['id'];


    /**
     * 分类/标签关系保存
     *
     * @param $id       int 游戏ID
     * @param $catIds array 分类/标签ID数组
     *
     * @return void
     **/
    public function store($id, $catIds)
    {

        AppCats::where('app_id', $id)->delete();
        foreach ($catIds as $catId) {

            $data = ['app_id' => $id, 'cat_id' => $catId];
            AppCats::create($data);
        }
    }

    /**
     * 获取同分类游戏ID
     *
     * @param $id    int   游戏ID
     * @param $cats array 分类数据 [['id' => 1, 'title' => 'xxx']]
     * @param $limit int   数量
     *
     * @return array [1,2,3]
     */
    public function sameCatAppId($id, $cats, $limit)
    {
        $catIds = [0]; // 初始值防止空值报错
        foreach($cats as $cat) {
            $catIds[] = $cat->id;
        }

        $appCats = AppCats::whereIn('cat_id', $catIds)
                            ->where('app_id', '!=', $id)
                            ->limit($limit)
                            ->select('app_id')
                            ->get()
                            ->toArray();
        $ids = [];
        foreach($appCats as $appCat) {
            $ids[] = $appCat['app_id'];
        }

        return $ids;
    }

}