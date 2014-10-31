<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Api_Apps extends \Eloquent {
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    protected $table = 'apps';
    protected $fillable = [];
    //新增字段
    protected $appends = ['rating', 'comment', 'tagList', 'categoryId', 'gameCategory'];
    //按名称搜索游戏名字
    public function scopeOfTitle($query, $title) {
        $sql = '%' . $title . '%';
        $query = $query->where('title', 'like', $sql);
        return $query;
    }
    //获得新的
    public function scopeOfNew($query, $versionCode) {
        return $query->where('version_code', '>', $versionCode)
                    ->orderBy('version_code', 'desc');
    }
    //设置ID
    public function setIdAttribute() {
        return $this->attributes['id'] = $this->id; 
    }
    public function getIdAttribute() {
        return intval($this->attributes['id']);
    }
    //设置ICON
    public function setIconAttribute() {
        return $this->attributes['icon'] = $this->icon; 
    }
    public function getIconAttribute() {
        return CUtil::checkHost($this->attributes['icon']);
    }
    //设置SIZEINT为整数
    public function setSizeIntAttribute() {
        return $this->attributes['size_int'] = $this->size_int; 
    }
    public function getSizeIntAttribute() {
        return intval($this->attributes['size_int']) * 1024;
    }
    //下载路径补充
    public function setDownloadLinkAttribute() {
        return $this->attributes['download_link'] = $this->download_link;
    }
    public function getDownloadLinkAttribute() {
        return CUtil::checkHost($this->attributes['download_link'], 'apk');
    }
    //是否有广告
    public function setHasAdAttribute() {
        return $this->attributes['has_ad'] = $this->has_ad;
    }
    public function getHasAdAttribute() {
        return $this->attributes['has_ad'] == 'yes' ? true : false;
    }
    //是否安全验证
    public function setIsVerifyAttribute() {
        return $this->attributes['is_verify'] = $this->is_verify;
    }
    public function getIsVerifyAttribute() {
        return $this->attributes['is_verify'] == 'yes' ? true : false;
    }
    //更新时间
    public function setUpdatedAtAttribute() {
        return $this->attributes['updated_at'] = $this->updated_at;
    }
    public function getUpdatedAtAttribute() {
        return date('Y/m/d H:i:s', strtotime($this->attributes['updated_at']));
    }
    //图片列表
    public function setImagesAttribute() {
        return $this->attributes['images'] = $this->images; 
    }
    public function getImagesAttribute() {
        $images = $this->attributes['images'] ? unserialize($this->attributes['images']) : [];
        $tmp = [];
        foreach ($images as $index => $image) {
            $img['id'] = $index + 1;
            $img['url'] = CUtil::checkHost($image);
            $tmp[] = $img;
        }
        return $tmp;
    }
    
    //获得评论统计
    public function getCommentAttribute() {
        return Api_Comments::where('app_id', $this->id)->count();
    }
    //获得评分
    public function getRatingAttribute() {
        $rating = Api_Ratings::where('app_id', $this->id)->first();
        return $rating ? intval($rating->manual) : 0;
    }
    //获取标签列表[问题，单个和多个时候如何分]
    public function getTagListAttribute() {
        $data = [];
        $ids = Api_AppCats::select('cat_id')
                       ->where('app_id', $this->id)
                       ->get()->toArray();

        if($ids) {
            $data = Api_Cats::select(['id', 'title'])
                         ->where('parent_id', '!=', 0)
                         ->whereIn('id', $ids)
                         ->get()->toArray();
        }
        return $data;
    }
    //拉取游戏相关的分类[问题，单个和多个时候如何分]
    public function getCat() {
        $data = [];
        $ids = Api_AppCats::select('cat_id')
                       ->where('app_id', $this->id)
                       ->get()->toArray();

        if($ids) {
            $data = Api_Cats::where('parent_id', 0)
                         ->whereIn('id', $ids)
                         ->get();
        }
        return $data;
    }
    //获取分类列表[问题，单个和多个时候如何分]
    public function getCategoryIdAttribute() {
        $data = $this->getCat();
        $tmp = [];
        foreach ($data as $cat) {
            $tmp[] = $cat->id;
        }
        return join(',', $tmp);
    }
    //获取分类列表[问题，单个和多个时候如何分]
    public function getGameCategoryAttribute() {
        $data = $this->getCat();
        $tmp = [];
        foreach ($data as $cat) {
            $tmp[] = $cat->title;
        }
        return join(',', $tmp);
    }
}