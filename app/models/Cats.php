<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Cats extends \Eloquent {

    use SoftDeletingTrait;

    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    protected $table = 'cats';
    protected $fillable = ['title','sort','position'];

    /**
     * 验证
     *
     * @param $data array 验证规则, $id int 可忽略的id
     *
     * @return obj
     **/
    public function isNewValid($data, $id = null)
    {
        $title = isset($id) ? 'sometimes|required|unique:cats,title,'. $id
                            : 'sometimes|required|unique:cats,title';

        // 分类数据验证规则
        $rules = [
            'title' => $title,
            'position' => 'sometimes|required|in:hotcats,gamecats',
            'sort' => 'sometimes|numeric',
            'image' => 'sometimes|required|image'
        ];
        // 错误信息
        $messages = [
            'title.required' => '分类标题不能为空',
            'title.unique' => '分类已存在',
            'position.required' => '请选择分类位置',
            'position.in' => '请不要违法操作',
            'sort.numeric' => '排序必须为数字'
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * 分类列表数据lists
     *
     *@param $pageSize int 分页
     *
     * @return obj
     */
    public function lists($pagesize) 
    {
        $conditions = ['id', 'position', 'title', 'sort'];

        return Cats::select($conditions)->orderBy('id', 'desc')->paginate($pagesize);
    }

    /**
     * 获取所有分类allCats
     *
     * @return obj
     */
    public function allCats()
    {
        $conditions = ['id', 'title'];

        return Cats::select($conditions)->orderBy('id', 'desc')->get();
    }

    /**
     * 获取分类广告allCatAds
     *
     *@param $pageSize int 分页
     *
     * @return obj
     */
    public function allCatAds($pageSize)
    {
        $conditions = ['id', 'title', 'image', 'operator_id', 'operator'];

        return Cats::select($conditions)->orderBy('id', 'desc')->paginate($pageSize);
    }
    
    /**
     * 热门分类位置数据hotCats
     *
     *@param $size int default = 4 默认显示4个
     *
     * @return obj
     */
    public function hotCats($size = 4)
    {
        return Cats::where('position', 'hotcats')->orderBy('sort', 'asc')                               
                                                 ->take($size)
                                                 ->get();
    }

    /**
     * 游戏分类位置数据gameCats
     *
     * @return obj
     */
    public function gameCats()
    {
        return Cats::where('position', 'gamecats')->orderBy('sort', 'asc')
                                                  ->get();
    }

    /**
     * 获取单个游戏的分类
     *
     * @param $id int 游戏 ID
     *
     * @return array [[id=>1, title=>xxx]]
     */
    public function appCats($id)
    {

        $data = [];
        $ids = AppCats::select('cat_id')
                       ->where('app_id', $id)
                       ->get()->toArray();

        if($ids) {
            $data = Cats::select(['id', 'title'])
                         ->whereIn('id', $ids)
                         ->get()->toArray();
        }

        return $data;
    }

    /**
     * 获取单个游戏的标签
     *
     * @param $id int 游戏 ID
     *
     * @return array [[id=>1, title=>xxx]]
     */
    public function appTags($id)
    {

        $data = [];
        $ids = AppCats::select('cat_id')
                       ->where('app_id', $id)
                       ->get()->toArray();

        if($ids) {
            $data = Tags::select(['id', 'title'])
                         ->whereIn('id', $ids)
                         ->get()->toArray();
        }

        return $data;
    }

    /**
     * 获取带分类结构的标签
     *
     * @return array
     */
    public function allTagsWithCat() {
        $data=[];

        foreach($this->allCats() as $cat) {
            $data[$cat->id]['title'] = $cat->title;
            // 获取相应标签
            foreach(GameCatTags::rewordTagids($cat->id) as $tag) {
                $tagData = [
                    'id' => $tag->tag_id, 
                    'title' => Tags::oftags($tag->tag_id)->title
                ];
                $data[$cat->id]['tags'][] = $tagData;         
            }
            
        }

        return $data;
    }
    /**
     * 往APP数据里面添加分类数据
     *
     * @param $apps array APP查询到的数据
     *
     * @return array
     */
    public function addCatsInfo($apps)
    {
        foreach($apps['data'] as $key => $app) {
            $cats = $this->appCats($app['id']);

            $catNames = [];
            foreach($cats as $cat) {
                $catNames[] = $cat['title'];
            }

            $apps['data'][$key] += [ 'cat_name' => implode(', ', $catNames)];
        }

        return $apps;
    }


    /**
     * 输出查询选择FORM的分类
     * 
     * @param
     *
     * @return array
     */
    public function selectForm()
    {
        $cats = ['' => '所有分类'];
        foreach ($this->allCats() as $cat) {
            $cats[$cat->id] = $cat->title;
        }

        return $cats;
    }
    
    // //过滤分类
    // public $catsRules = [
    //             'word' => 'required|unique:cats,title,NULL,id,parent_id,0,deleted_at,NULL',
    //             ];
    // //过滤标签
    // public function tagsCreateRules($parent_id) {
    //     return [
    //             'word' => 'required|unique:cats,title,NULL,NULL,parent_id,'.$parent_id,
    //             'parent_id' => 'required|integer',
    //             ];
    // }
    // //过滤标签添加

    // public function tagsUpdateRules($id, $parent_id) {
    //     return [
    //             'word' => 'required|unique:cats,title,'.$id .',id,deleted_at,NULL,parent_id,'.$parent_id,
    //             'sort' => 'integer',
    //             ];
    // }

    
    // /**
    //  * 获取所有分类
    //  *
    //  * @return obj
    //  */
    // public function allCats()
    // {
    //     return Cats::select(['id', 'title', 'search_total', 'sort', 'created_at'])
    //                 ->where('parent_id', 0)
    //                 ->orderBy('sort', 'desc')
    //                 ->get();
    // }

    // /**
    //  * 获取所有标签
    //  *
    //  * @return obj
    //  */
    // public function allTags()
    // {
    //     return Cats::select(['id', 'parent_id', 'title'])
    //                 ->where('parent_id', '!=', 0)
    //                 ->orderBy('sort', 'desc')
    //                 ->get();
    // }

    

    // /**
    //  * 获取分类所有标签
    //  *
    //  * @param $id int 分类ID 
    //  *
    //  * @return obj
    //  */
    // public function catTags($id)
    // {
    //     return Cats::select(['id', 'title'])
    //                 ->where('parent_id', $id)
    //                 ->orderBy('sort', 'desc')
    //                 ->get();
    // }
}