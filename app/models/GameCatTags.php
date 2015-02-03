<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class GameCatTags extends \Eloquent {

    use SoftDeletingTrait;

    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    protected $table = 'game_cat_tags';
    protected $fillable = [];

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
        $rules = [
            'title' => 'sometimes|required',
            'catid' => 'required|exists:cats,id'
        ];
        // 错误信息
        $messages = [
            'title.required' => '标题不能为空',
            'catid.required' => '请选择分类，谢谢!',
            'catid.exists' => '您选择的分类不存在!'
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * 分类标签列表数据
     *
     *@param $pageSize int 分页偏移量
     *
     * @return obj 
     */
    public function lists($pageSize) 
    {
        $conditions = ['id', 'cat_id', 'tag_id', 'operator_id', 'operator'];

        return GameCatTags::select($conditions)->orderBy('id', 'desc')
                                               ->where('game_id', '0')
                                               ->paginate($pageSize);
    }

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