<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Comments extends \Eloquent {
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    protected $table = 'comments';
    protected $fillable = [];

    public $rules = ['content' => 'required'];
    //名称搜索
    public function scopeOfTitle($query, $title) {
        $sql =  ['%', $title , '%'];
        return $query->where('title', 'like', join($sql));
    }
    //包名搜索
    public function scopeOfPack($query, $pack) {
        $sql =  ['%', $pack , '%'];
        return $query->where('pack', 'like', join($sql));
    }
}