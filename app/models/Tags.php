<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Tags extends \Eloquent {

    use SoftDeletingTrait;

    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    protected $table = 'tags';
    protected $fillable = ['title', 'sort', 'operator_id', 'operator'];

    /**
     * 验证
     *
     * @param $data array 验证规则, $id int 可忽略的id
     *
     * @return obj
     **/
    public function isNewValid($data, $id = null)
    {
        // 分类数据验证规则
        $title = isset($id) ? 'required|unique:tags,title,' . $id 
                            : 'required|unique:tags,title';
                            
        $rules = ['title'  => $title, 'sort' => 'numeric'];
        // 错误信息
        $messages = [
            'title.required'  => '标题不能为空',
            'title.unique'  => '标签已经存在',
            'sort.numeric' => '排序必须为数字'
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * 标签列表数据
     *
     *@param $pageSize int 分页偏移量
     *
     * @return obj
     */
    public function lists($pageSize) 
    {
        $conditions = [
            'id', 
            'search_count', 
            'title', 'sort', 
            'updated_at', 
            'operator_id', 
            'operator'
        ];

        return Tags::select($conditions)
                   ->orderBy('id', 'desc')
                   ->paginate($pageSize);
    }

    /**
     * 获取所有标签信息allTags
     *
     * @return obj
     */
    public function allTags()
    {
        $conditions = ['id', 'title'];

        return Tags::select($conditions)
                   ->orderBy('id', 'desc')
                   ->get();
    }
    
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
    	return Tags::select('id', 'title')
                   ->isTags($ids)
                   ->get();
    }

    
 }