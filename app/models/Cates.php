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
                'sort' => '',
                ];
}