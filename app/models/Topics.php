<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Topics extends \Eloquent {
	use SoftDeletingTrait;

    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    protected $table = 'topics';
    protected $fillable = [
        'title', 
        'game_id', 
        'summary', 
        'image', 
        'location', 
        'status',
        'stocked_at', 
        'unstocked_at',
        'operator_id',
        'operator'
    ];

    /**
     * 验证
     *
     * @param $data array 验证规则, $id int 可忽略的id
     *
     * @return obj
     **/
    public function isNewValid($data)
    {
        // 分类数据验证规则
        $rules = [
            'title' => 'sometimes|required|',
            'game_id' => 'sometimes|required|',
            'summary' => 'sometimes|required|',
            'image' => 'sometimes|required',
            'location' => 'sometimes|required',
            'stocked_at' => 'sometimes|required',
        ];
        // 错误信息
        $messages = [
            'title.required' => '标题不能为空',
            'game_id.required' => '请添加游戏',
            'summary.required' => '点评不能为空',
            'image.required' => '图片不能为空',
            'location.required' => '请选择专题位置',
            'stocked_at.required' => '上架时间不能为空'
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * 排行广告列表
     *
     * @param $pagesize int 分页,$type string 类型，$status string 状态
     *
     * @return obj
     */
    public function lists($pagesize, $type ,$ofStatus = null, $title = null ) 
    {
        if ($type == 'dptopics') {
        	$inStatus = ['draft', 'pending'];
        }

        if ($type == 'sutopics') {
        	$inStatus = ['stock', 'unstock'];
        }

        return Topics::orderBy('id', 'desc')
        			 ->ofStatus($ofStatus)
        			 ->LikeTitle($title)
        			 ->inStatus($inStatus)
        			 ->paginate($pagesize); 
    }

    /**
     * 查询状态
     *
     * @param $query obj, $ofStatus string
     *
     * @return obj
     */
    public function scopeOfStatus($query, $ofStatus)
    {
    	if (! $ofStatus) return $query;

    	return $query->whereStatus($ofStatus);
    }

    /**
     * 查询标题
     *
     * @param $query obj, $title string
     *
     * @return obj
     */
    public function scopeLikeTitle($query, $title)
    {
    	if (! $title) return $query;
    	$sql = '%' .$title. '%';

    	return $query->where('title', 'like', $sql);
    }

    /**
     * 状态类型区分
     *
     * @param $query obj, $status string
     *
     * @return obj
     */
    public function scopeInStatus($query, $inStatus)
    {
    	if (! $inStatus) return $query;
    	if (! is_array($inStatus)) return $query;

    	return $query->whereIn('status', $inStatus);
    }


    
}