<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Api_Apps extends \Eloquent {
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    protected $table = 'apps';
    protected $fillable = [];
    //新增字段
    protected $appends = ['rating', 'comment', 'link'];
    //图片操作
    public function icon() {
        return $this->icon.'1233456';
    }
    //按名称搜索游戏名字
    public function scopeOfTitle($query, $title) {
        $sql = '%' . $title . '%';
        $query = $query->where('title', 'like', $sql);
        return $query;
    }
    //获得评分
    public function getRatingAttribute() {
        return Api_Ratings::where('app_id', $this->id)->first()->manual;
    }
    //获得评论统计
    public function getCommentAttribute() {
        return $this->id;
    }
    //下载路径补充
    public function getLinkAttribute() {
        //图片
        $host = 'http://127.0.0.1';
        return $host . $this->download_link;
    }
}