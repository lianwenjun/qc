<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Cates extends \Eloquent {

    //这部分假删除部分能做成个头部不呢
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    
    protected $table = 'cates';
    protected $fillable = [];
    //过滤分类
    public $CatesRules = [
                'word' => 'required',
                ];
    //过滤标签
    public $TagsCreateRules = [
                'word' => 'required',
                'parent_id' => 'required|integer',
                ];
    //过滤标签添加
    public $TagsUpdateRules = [
                'word' => 'required',
                'sort' => 'integer',
                ];

    /**
     * 获取单个游戏的分类
     *
     * @param $id int 游戏 ID
     *
     * @return array [[id=>1, title=>xxx]]
     */
    public function appCates($id)
    {

        $data = [];
        $ids = AppCates::select('cate_id')
                       ->where('app_id', $id)
                       ->get()->toArray();

        if($ids) {
            $data = Cates::select(['id', 'title'])
                         ->where('parent_id', 0)
                         ->whereIn('id', $ids)
                         ->get()->toArray();
        }

        return $data;
    }

    /**
     * 获取单个游戏的标签
     *
     * @param $id int 游戏 ID
     *
     * @return array [[id=>1, title=>xxx]]
     */
    public function appTags($id)
    {

        $data = [];
        $ids = AppCates::select('cate_id')
                       ->where('app_id', $id)
                       ->get()->toArray();

        if($ids) {
            $data = Cates::select(['id', 'title'])
                         ->where('parent_id', '!=', 0)
                         ->whereIn('id', $ids)
                         ->get()->toArray();
        }

        return $data;
    }

    /**
     * 获取所有分类
     *
     * @return obj
     */
    public function allCates()
    {
        return Cates::select(['id', 'title', 'search_total', 'created_at'])
                    ->where('parent_id', 0)
                    ->orderBy('sort', 'desc')
                    ->get();
    }

    /**
     * 获取所有标签
     *
     * @return obj
     */
    public function allTags()
    {
        return Cates::select(['id', 'parent_id', 'title'])
                    ->where('parent_id', '!=', 0)
                    ->orderBy('sort', 'desc')
                    ->get();
    }

    /**
     * 往APP数据里面添加分类数据
     *
     * @param $apps array APP查询到的数据
     *
     * @return array
     */
    public function addCatesInfo($apps)
    {
        foreach($apps['data'] as $key => $app) {
            $cates = $this->appCates($app['id']);

            $cateNames = [];
            foreach($cates as $cate) {
                $cateNames[] = $cate['title'];
            }

            $apps['data'][$key] += [ 'cate_name' => implode(', ', $cateNames)];
        }

        return $apps;
    }

    /**
     * 获取带分类结构的标签
     *
     * @return array
     */
    public function allTagsWithCate() {

        $data=[];
        foreach($this->allCates() as $cate) {
            $data[$cate->id]['title'] = $cate->title;
            foreach($this->allTags() as $tag) {
                if($tag->parent_id == $cate->id) {
                    $tagData = ['id' => $tag->id, 'title' => $tag->title];
                    $data[$cate->id]['tags'][] = $tagData;
                }
            }
        }

        return $data;
    }

    /**
     * 获取分类所有标签
     *
     * @param $id int 分类ID 
     *
     * @return obj
     */
    public function cateTags($id)
    {
        return Cates::select(['id', 'title'])
                    ->where('parent_id', $id)
                    ->orderBy('sort', 'desc')
                    ->get();
    }
}