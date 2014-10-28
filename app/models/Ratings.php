<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Ratings extends \Eloquent {

    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    protected $table = 'ratings';
    protected $guarded    = ['id'];
 
    //校验数据
    public function isValid($input, $type = 'update') {
        $rules = ['manual' => 'required|numeric|min:1|max:5'];
        //返回消息没了
        return Validator::make(
            $input,
            $rules
        )->passes();
    }
    //游戏名称查询
    public function scopeofLike($query, $key, $word) {
        $sql = '%' . $word . '%';
        return $query->where($key, 'like', $sql);
    }
    //名称查询
    public function scopeOfTitle($query, $word) {
        if ($word) {
            $query = $query->ofLike('title', $word);
        }
        return $query;
    }
    //包名查询
    public function scopeOfPack($query, $word) {
        if ($word) {
            $query = $query->ofLike('pack', $word);
        }
        return $query;
    }

}