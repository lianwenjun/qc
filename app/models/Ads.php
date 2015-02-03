<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Ads extends \Eloquent {
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    protected $table = 'ads';
    
    protected $fillable = [
        'game_id', 
        'title',
        'package', 
        'image', 
        'location', 
        'status',
        'sort', 
        'operator_id', 
        'operator', 
        'stocked_at',
        'unstocked_at'
    ];
    
    /**
     * 验证
     *
     * @param $data array 验证规则,$locations array 验证的广告位置类型,$id int 可忽略的id
     *
     * @return obj
     **/
    public function isNewValid($data, $locations, $id = null)
    {
        $location = implode(',', $locations);
        // 分类数据验证规则
        $rules = [
            'title' => 'required',
            'game_id' => 'required|integer',
            'package' => 'required',
            'image' => 'sometimes|required|image',
            'location' => 'required|in:' . $location,
            'sort' => 'numeric',
            'stocked_at' => 'required',
            'unstocked_at' => 'required'
        ];

        // 错误信息
        $messages = [
            'title.required' => '标题不能为空',
            'game_id.required' => '游戏id不存在',
            'package.required' => '包名不能为空',
            'image.required' => '请你上传一张图片',
            'image.image' => '请上传jqpeg,png,gif,jpg格式的图片',
            'sort.numeric' => '排序只能为数字',
            'location.required' => '请选择广告位置',
            'location.in' => '选择的广告位置不合法',
            'stocked_at.required' => '请选择上线时间',
            'unstocked_at.required' => '请选择下架时间'
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * 广告列表数据
     *
     * @param $pageSize int 分页,$locations array 广告类型,
     *        $oflocation string 广告位置,$ofStatus string 广告状态,
     *        $title string 广告名称
     *
     * @return obj
     **/
    public function lists(
        $pagesize, 
        $locations = null, 
        $oflocation = null, 
        $ofStatus = null, 
        $title = null
    )
    {
        $query = Ads::isLocation($locations);
        return $query->ofStatus($ofStatus)
                     ->titleLike($title)
                     ->ofLocation($oflocation)
                     ->orderBy('id', 'desc')
                     ->paginate($pagesize);
    }

    /**
    *广告位置类型查询
    *
    * @param $query obj,$locations array 广告类型
    *
    * @return obj
    */
    public function scopeIsLocation($query, $locations)
    {
        if (! $locations) return $query;
        if (! is_array($locations)) return $query;

        return $query->whereIn('location', $locations);
    }

    /**
    *广告位置按单个位置查询
    *
    * @param $query obj,$oflocation string 广告类型
    *
    * @return obj
    */
    public function scopeOfLocation($query, $oflocation) 
    {
        if (! $oflocation) return $query;

        return $query->whereLocation($oflocation);
    }

    /**
    *广告游戏名称查询
    *
    * @param $query obj,$title string 广告名称
    *
    * @return obj
    */
    public function scopeTitleLike($query, $title) {
        if (! $title) return $query;
        $sql = '%' . $title . '%';

        return $query->where('title', 'like', $sql);
    }

    /**
    * 广告位是否上下架展示查询
    *
    * @param $query obj,$ofStatus string 广告状态
    *
    * @return obj
    */
    public function scopeOfStatus($query, $ofStatus) 
    {
        if (! $ofStatus) return $query;

        return $query->where('status', $ofStatus); 
    }

    /**
    * 游戏广告位编辑信息
    *
    * @param $id int 广告id, $locations array广告位置可以为空
    *        $status int 广告状态
    *
    * @return obj
    */
    public function gameAdsInfo($id, $locations, $status) 
    {
        $query = Ads::isLocation($locations);
     
        return $query->ofStatus($status)->find($id);
    }

    //校验数据
    // public function isValid($input, $type = 'create') {
    //     $rules = [
    //         'create' => [
    //             'app_id' => 'required|integer',
    //             'title' => 'required',
    //             'is_top' => 'in:yes,no',
    //             'sort' => 'integer',
    //             'stocked_at' => 'required',
    //             'unstocked_at' => 'required'
    //         ],
    //         'update' => [
    //             'is_top' => 'in:yes,no',
    //             'sort' => 'integer',
    //         ],
    //     ];
    //     //返回消息没了
    //     return Validator::make(
    //         $input,
    //         $rules[$type]
    //     )->passes();
    // }
    
    // /*
    // * 添加广告
    // * @param type
    // * @param Input::all()
    // * @respone data
    // */
    // public function ofCreate($type, $location = '') {
    //     $fields = [
    //         'app_id' => Input::get('app_id'),
    //         'title' => Input::get('title'),
    //         'location' => $location ? $location : Input::get('location'),
    //         'image' => Input::get('image', ''),
    //         'is_top' => Input::get('is_top', 'no'),
    //         'stocked_at' => Input::get('stocked_at'),
    //         'unstocked_at' => Input::get('unstocked_at'),
    //         'type' => $type,
    //         'is_stock' => 'yes', 
    //         'sort' => Input::get('sort', 0), 
    //         'word' => Input::get('word', ''),
    //         ];
    //     $ads = new Ads;
    //     foreach ($fields as $key => $value) {
    //         $ads->$key = $value;
    //     }
    //     return $ads;
    // }
    // /*
    // * 更新广告
    // * @param ad
    // * @param Input::all()
    // * @respone data
    // */
    // public function ofUpdate($ad) {
    //     $ad->location = Input::get('location', $ad->location);
    //     $ad->is_top = Input::get('is_top', 'no');
    //     $ad->sort = Input::get('sort', $ad->sort);
    //     $ad->image = Input::get('image', $ad->image);
    //     $ad->stocked_at = Input::get('stocked_at', $ad->stocked_at);
    //     $ad->unstocked_at = Input::get('unstocked_at', $ad->unstocked_at);
    //     $ad->word = Input::get('word', $ad->word);
    //     $ad->is_stock = 'yes';
    //     return $ad;
    // }

    // //是否上架查询
    
    // * @param query sql
    // * @param type  是否上架类型，默认为yes
    
    // public function scopeIsStock($query, $type='yes') {
    //     return $query->where('is_stock', $type); 
    // }
    // //是否置顶
    // public function scopeIsTop($query, $type) {
    //     if (!$type) {
    //         return $query;
    //     }
    //     return $query->where('is_top', $type); 
    // }
    // public function scopeIsLocation($query, $location) {
    //     if (!$location) return $query;
    //     if (!is_array($location)) return $query;
    //     return $query->whereIn('location', $location);
    // }

    // //游戏名称查询
    // public function scopeTitleLike($query, $word) {
    //     $sql = '%' . $word . '%';
    //     return $query->where('title', 'like', $sql);
    // }

    // //时间小于查询
    // public function scopeLessNow($query, $key) {
    //     $time = date('Y-m-d h:m:s', time());
    //     return $query->where($key, '<=', $time);
    // }

    // //时间大于查询
    // public function scopeGreateNow($query, $key) {
    //     $time = date('Y-m-d h:m:s', time());
    //     return $query->where($key, '>', $time);
    // }

    // //名称查询
    // public function scopeOfTitle($query, $word) {
    //     if ($word) {
    //         $query = $query->titleLike($word);
    //     }
    //     return $query;
    // }

    // //按位置查询
    // public function scopeOfLocation($query, $location) {
    //     if ($location) {
    //         $query = $query->whereLocation($location);;
    //     }
    //     return $query;
    // }
    
    // //时间过滤
    // public function scopeOfStatus($query, $status) {
    //     switch($status){
    //         case 'stock':// 上架，未到展示时间
    //             $query = $query->isStock()->greateNow('stocked_at');
    //             break;
    //         case 'unstock'://下架不管时间
    //             $query = $query->isStock('no');
    //             break;
    //         case 'online'://上架，在展示时间
    //             $query = $query->lessNow('stocked_at')->GreateNow('unstocked_at')->isStock();
    //             break;
    //         case 'expired'://上架，时间过期
    //             $query = $query->lessNow('unstocked_at')->isStock();
    //             break;
    //         default://其他
    //             $query = $query;  
    //     }
    //     return $query;
    // }   
}