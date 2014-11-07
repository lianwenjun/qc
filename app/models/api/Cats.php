<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Api_Cats extends \Eloquent {
    use SoftDeletingTrait;
    protected $fillable = [];
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    protected $table = 'cats';

    public function getCatsByAppId($appId) {
        $data = [];
        $ids = Api_AppCats::select('cat_id')
                       ->where('app_id', $appId)
                       ->get()->toArray();

        if($ids) {
            $data = Api_Cats::where('parent_id', 0)
                         ->whereIn('id', $ids)
                         ->get();
        }
        return $data;
    }
    public function getTagsByAppId($appId) {
        $data = [];
        $ids = Api_AppCats::select('cat_id')
                       ->where('app_id', $appId)
                       ->get()->toArray();

        if($ids) {
            $data = Api_Cats::select(['id', 'title'])
                         ->where('parent_id', '!=', 0)
                         ->whereIn('id', $ids)
                         ->get()->toArray();
        }
        return $data;
    }
}