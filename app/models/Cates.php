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
     * @return array [[id=>1, titile=>xxx]]
     */
    public function xcates($id)
    {

        $ids = AppCates::select('cate_id')
                       ->where('app_id', $id)
                       ->get();

        print_r($ids);


    }

    /**
     * 获取所有分类
     *
     * @return obj
     */
    public function allCates()
    {
        return Cates::select(['id', 'title'])
                    ->where('parent_id', 0)
                    ->orderBy('sort', 'desc')
                    ->get();
    }
}