<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class GameCatTags extends \Eloquent {

    use SoftDeletingTrait;

    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    protected $table = 'game_cat_tags';
    protected $fillable = [];

    /**
    * 查询相应分类的标签ids
    *
    * @param $id int 分类id
    *
    * @return obj
    */
    public function rewordTagids($id)
    {
    	return GameCatTags::select('tag_id')->where('cat_id', $id)->get();
    }
 }