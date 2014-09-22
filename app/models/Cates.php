<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Cates extends \Eloquent {
    //这部分假删除部分能做成个头部不呢
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    
    protected $table = 'cates';
    protected $fillable = [];
    //过滤分类更新
    public function validateCatesUpate(){
        $validator = Validator::make(
            [
                'word' => Input::get('word'),
            ],
            [
                'word' => 'required|min:1',
            ]
        );
        return $validator;
    }
    //过滤分类添加
    public function validateCatesCreate(){
        $validator = Validator::make(
            [
                'word' => Input::get('word'),
                'parent_id' => Input::get('parent_id'),
            ],
            [
                'word' => 'required|min:1',
                'parent_id' => 'int',
            ]
        );
        return $validator;
    }
    //过滤标签更新
    public function validateTagsUpate(){
        $validator = Validator::make(
            [
                'word' => Input::get('word'),
            ],
            [
                'word' => 'required|min:1',
            ]
        );
        return $validator;
    }
}