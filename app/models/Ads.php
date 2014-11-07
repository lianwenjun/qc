<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Ads extends \Eloquent {
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    protected $table = 'ads';
    
    protected $fillable = ['app_id', 'title', 'location', 'image', 'stocked_at', 
                'unstocked_at', 'type', 'is_stock', 'is_top', 'sort', 'word'];
    
    //校验数据
    public function isValid($input, $type = 'create') {
        $rules = [
            'create' => [
                'app_id' => 'required|integer',
                'title' => 'required',
                'is_top' => 'in:yes,no',
                'sort' => 'integer',
                'stocked_at' => 'required',
                'unstocked_at' => 'required'
            ],
            'update' => [
                'is_top' => 'in:yes,no',
                'sort' => 'integer',
            ],
        ];
        //返回消息没了
        return Validator::make(
            $input,
            $rules[$type]
        )->passes();
    }
    
    /*
    * 添加广告
    * @param type
    * @param Input::all()
    * @respone data
    */
    public function ofCreate($type, $location = '') {
        $fields = [
            'app_id' => Input::get('app_id'),
            'title' => Input::get('title'),
            'location' => $location ? $location : Input::get('location'),
            'image' => Input::get('image', ''),
            'is_top' => Input::get('is_top', 'no'),
            'stocked_at' => Input::get('stocked_at'),
            'unstocked_at' => Input::get('unstocked_at'),
            'type' => $type,
            'is_stock' => 'yes', 
            'sort' => Input::get('sort', 0), 
            'word' => Input::get('word', ''),
            ];
        $ads = new Ads;
        foreach ($fields as $key => $value) {
            $ads->$key = $value;
        }
        return $ads;
    }
    /*
    * 更新广告
    * @param ad
    * @param Input::all()
    * @respone data
    */
    public function ofUpdate($ad) {
        $ad->location = Input::get('location', $ad->location);
        $ad->is_top = Input::get('is_top', 'no');
        $ad->sort = Input::get('sort', $ad->sort);
        $ad->stocked_at = Input::get('stocked_at', $ad->stocked_at);
        $ad->unstocked_at = Input::get('unstocked_at', $ad->unstocked_at);
        $ad->is_stock = 'yes';
        return $ad;
    }

    //是否上架查询
    /*
    * @param query sql
    * @param type  是否上架类型，默认为yes
    */
    public function scopeIsStock($query, $type='yes') {
        return $query->where('is_stock', $type); 
    }
    //是否置顶
    public function scopeIsTop($query, $type) {
        if (!$type) {
            return $query;
        }
        return $query->where('is_top', $type); 
    }
    public function scopeIsLocation($query, $location) {
        if (!$location) return $query;
        if (!is_array($location)) return $query;
        return $query->whereIn('location', $location);
    }

    //游戏名称查询
    public function scopeTitleLike($query, $word) {
        $sql = '%' . $word . '%';
        return $query->where('title', 'like', $sql);
    }

    //时间小于查询
    public function scopeLessNow($query, $key) {
        $time = date('Y-m-d h:m:s', time());
        return $query->where($key, '<=', $time);
    }

    //时间大于查询
    public function scopeGreateNow($query, $key) {
        $time = date('Y-m-d h:m:s', time());
        return $query->where($key, '>', $time);
    }

    //名称查询
    public function scopeOfTitle($query, $word) {
        if ($word) {
            $query = $query->titleLike($word);
        }
        return $query;
    }

    //按位置查询
    public function scopeOfLocation($query, $location) {
        if ($location) {
            $query = $query->whereLocation($location);;
        }
        return $query;
    }
    
    //时间过滤
    public function scopeOfStatus($query, $status) {
        switch($status){
            case 'stock':// 上架，未到展示时间
                $query = $query->isStock()->greateNow('stocked_at');
                break;
            case 'unstock'://下架不管时间
                $query = $query->isStock('no');
                break;
            case 'online'://上架，在展示时间
                $query = $query->lessNow('stocked_at')->GreateNow('unstocked_at')->isStock();
                break;
            case 'expired'://上架，时间过期
                $query = $query->lessNow('unstocked_at')->isStock();
                break;
            default://其他
                $query = $query;  
        }
        return $query;
    }   
}