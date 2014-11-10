<?php

class Histories extends \Eloquent {

    protected $table      = 'histories';
    protected $dates      = ['deleted_at'];
    protected $guarded    = ['id'];

    protected $searchEnable = [
        'pack'
    ];

    /**
     * 历史列表
     *
     * @param $appId  int   游戏ID
     * @param $data   array 条件数据
     *
     * @return obj 游戏列表对象
     */
    public function lists($appId, $data)
    {

        $query = Histories::where('app_id', $appId);

        return $this->queryParse($query, $data);
    }

    /**
     * 解析条件
     *
     * @param $query obj   query
     * @param $data  array 条件数据
     *
     * @return obj query
     */
    public function queryParse($query, $data)
    {

        foreach($data as $key => $value) {

            if(! in_array($key, $this->searchEnable)) break;

            if (!empty($value)) {
                $query->where($key, $value);
            }
        }

        // 排序
        $query->orderBy('id', 'desc');

        return $query;
    }

    /**
     * 获取单个游戏信息
     *
     * @param $id int 游戏ID
     *
     * @return mix
     */
    public function info($id)
    {

        $info = Histories::find($id)->toArray();

        if(empty($info)) return false;

        $info['cates']  = unserialize($info['cates']);
        $info['tags']   = unserialize($info['tags']);
        $info['images'] = unserialize($info['images']);

        return json_decode(json_encode($info), FALSE);
    }

    /**
     * 预览游戏 
     *
     * @param $id int 游戏ID
     *
     * @return mix
     */
    public function preview($id)
    {
        $info = $this->info($id);

        if(empty($info)) return false;

        return json_decode(json_encode($info), TRUE);;
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
            $cats = unserialize($app['cats']);

            $cateNames = [];
            foreach($cats as $cat) {
                $catNames[] = $cat['title'];
            }

            $apps['data'][$key] += [ 'cat_name' => implode(', ', $catNames)];
        }

        return $apps;
    }

}