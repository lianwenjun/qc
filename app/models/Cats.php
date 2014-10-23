<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Cats extends \Eloquent {

    //这部分假删除部分能做成个头部不呢
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    
    protected $table = 'cats';
    protected $fillable = [];
    //过滤分类
    public $CatsRules = [
                'word' => 'required|unique:cats,title,NULL,id,parent_id,0,deleted_at,NULL',
                ];
    //过滤标签
    public $TagsCreateRules = [
                'word' => 'required|unique:cats,title,0,parent_id',
                'parent_id' => 'required|integer',
                ];
    //过滤标签添加

    public function tagsUpdateRules($id) {
        return [
                'word' => 'required|unique:cats,title,'.$id .',id,deleted_at,NULL',
                'sort' => 'integer',
                ];
    }
    /**
     * 获取单个游戏的分类
     *
     * @param $id int 游戏 ID
     *
     * @return array [[id=>1, title=>xxx]]
     */
    public function appCats($id)
    {

        $data = [];
        $ids = AppCats::select('cat_id')
                       ->where('app_id', $id)
                       ->get()->toArray();

        if($ids) {
            $data = Cats::select(['id', 'title'])
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
        $ids = AppCats::select('cat_id')
                       ->where('app_id', $id)
                       ->get()->toArray();

        if($ids) {
            $data = Cats::select(['id', 'title'])
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
    public function allCats()
    {
        return Cats::select(['id', 'title', 'search_total', 'created_at'])
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
        return Cats::select(['id', 'parent_id', 'title'])
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
    public function addCatsInfo($apps)
    {
        foreach($apps['data'] as $key => $app) {
            $cats = $this->appCats($app['id']);

            $catNames = [];
            foreach($cats as $cat) {
                $catNames[] = $cat['title'];
            }

            $apps['data'][$key] += [ 'cat_name' => implode(', ', $catNames)];
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
        foreach($this->allCats() as $cat) {
            $data[$cat->id]['title'] = $cat->title;
            foreach($this->allTags() as $tag) {
                if($tag->parent_id == $cat->id) {
                    $tagData = ['id' => $tag->id, 'title' => $tag->title];
                    $data[$cat->id]['tags'][] = $tagData;
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
    public function catTags($id)
    {
        return Cats::select(['id', 'title'])
                    ->where('parent_id', $id)
                    ->orderBy('sort', 'desc')
                    ->get();
    }
}