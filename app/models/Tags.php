<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Tags extends \Eloquent {

    use SoftDeletingTrait;

    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    protected $table = 'tags';
    protected $fillable = [];


    /**
    * 标签ids查询
    *
    * @param $ids array
    *
    * @return obj
    */
    public function scopeIsTags($query, $ids)
    {
    	if(! $ids) return $query;
    	if(! is_array($ids)) return $query;

    	return $query->whereIn('id', $ids);
    }

    /**
    * 获取相应标签
    *
    * @param $ids array
    *
    * @return obj
    */
    public function relevantTags($ids)
    {
    	return Tags::select('id', 'title')->isTags($ids)->get();
    }
 }