<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Apps extends \Base {

    use SoftDeletingTrait;

    protected $table      = 'apps';
    protected $dates      = ['deleted_at'];
    protected $softDelete = true;
    protected $guarded    = ['id'];

    // 验证规则
    public $rules = [
        'draft'   => [],
        'pending' => [
            'cats'           => 'required',
            'os_version'      => 'required',
            'version_code'    => 'required',
            'sort'            => 'required',
            'download_manual' => 'required',
            'summary'         => 'required',
            'images'          => 'required',
            'changes'         => '',
        ],
    ];

    // 可以搜索字段
    public $searchEnable = [
        'title',
        'cat_id',
        'pack',
        'version',
        'size_int',
        'created_at',
        'updated_at',
        'stocked_at',
        'unstocked_at'
    ];

    // 可以排序的字段
    public $orderEnable = [
        'size_int',
        'download_counts',
        'stocked_at'
    ];

    /**
     * 游戏列表
     *
     * @param $status array 状态
     * @param $data   array 条件数据
     *
     * @return obj 游戏列表对象
     */
    public function lists($status, $data)
    {
        $query = Apps::whereIn('status', $status);

        return $this->queryParse($query, $data);
    }

    /**
     * 解析前处理
     *
     * 可选字段预处理，$data数据里面 type 索引必须放在 keyword 前面
     *
     * @param $data array 条件数据
     *
     * @return array
     */
    public function beforeQueryParse($data)
    {
        $field = '';
        foreach ($data as $key => $value) {
            if($key == 'type' && !empty($value)) {
                $data[$value] = '';
                $field = $value;
            }

            if($key == 'keyword' && !empty($value) && !empty($field)) {
                $data[$field] = $value;
            }
        }

        if(isset($data['type'])) unset($data['type']);
        if(isset($data['keyword'])) unset($data['keyword']);

        return $data;
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

        $data = $this->beforeQueryParse($data);

        foreach($data as $key => $value) {
            if(! in_array($key, $this->searchEnable)) continue;
            $query = $this->conditionParse($key, $value, $query);
        }

        // 排序
        if(isset($data['orderby'])) {
            $orderby = explode('.', $data['orderby']);
            if(
                in_array($orderby[0], $this->orderEnable)
                && isset($orderby[1])
                && !empty($orderby[1])
              ) {
                $query->orderBy($orderby[0], $orderby[1]);
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        return $query;
    }

    /**
     * 条件解析
     *
     * @param $field string 字段
     * @param $value mix    查询值
     * @param $query obj    query对象
     *
     * @return query obj
     */
    public function conditionParse($field, $value, $query) {

        if( ($field == 'title' || $field == 'pack' || $field == 'version') && !empty($value)) {
            $query->where($field, 'like', '%' . $value . '%');
        } elseif($field == 'cat_id' && !empty($value)) {
            $query->whereRaw("`id` in (select `app_id` from `app_cats` where `cat_id` = '{$value}')");
        } elseif(is_array($value) && count($value) == 2) { // 查询范围

            // 处理空值
            $unique = array_unique($value);
            if(isset($unique[0]) && !empty($unique[0])) {

                // 时间处理
                if(substr($field, -3) == '_at') {
                    $value[1] = date('Y-m-d', strtotime($value[1] ? $value[1] : date('Ymd')) + 24 * 3600);
                }

                // 占空间大小处理
                if($field == 'size_int') {
                    foreach($value as $k => $v) {
                        if(substr($v, -1) == 'm' || substr($v, -1) == 'M') {
                            $value[$k] = intval($v) * 1024;
                        } elseif(substr($v, -1) == 'g' || substr($v, -1) == 'G') {
                            $value[$k] = intval($v) * 1024 * 1024;
                        } else {
                            $value[$k] = intval($v);
                        }
                    }
                }

                $query->whereBetween($field, $value);
            }

        } elseif (!empty($value)) {
            $query->where($field, $value);
        }

        return $query;
    }

    /**
     * 修改入库
     *
     * @param $id     int    游戏ID
     * @param $status string 状态
     * @param $data   array  put 数据
     *
     * @return boolean
     */
    public function store($id, $status, $data)
    {

        // 处理关键字
        if(isset($data['keywords'])) {
            $keywords = new Keywords;
            $keywords->store($data['keywords'], $id);
        }

        // 处理分类/标签
        if(isset($data['cats'])) {
            $appCats = new AppCats;
            $appCats->store($id, $data['cats']);
        }

        // 处理图片
        if(isset($data['images'])) {
            $data['images'] = serialize($data['images']);
        } else {
            $data['images'] = '';
        }

        // 处理状态
        $data['status'] = $status;

        $data['has_ad']    = isset($data['has_ad']) ? 'yes' : 'no';
        $data['is_verify'] = isset($data['is_verify']) ? 'yes' : 'no';

        $fields = Schema::getColumnListing('apps');
        foreach($data as $field => $value) {
            if(! in_array($field, $fields) ) {
                unset($data[$field]);
            }
        }

        // 处理历史
        if($status == 'stock') {
            $this->history($id);
        }

        // 记录操作日志
        $action = [
            'stock' => '更新了游戏',
            'pending' => '编辑并提交到待审核',
            'draft' => '编辑并保存为草稿',
        ];

        $selfStatus = Apps::find($id)->status;
        $action_field = [
            'stock' => '游戏管理-上架游戏列表',
            'publish' => '游戏管理-添加编辑游戏',
            'notpass' => '游戏管理-审核不通过列表',
            'unstock' => '游戏管理-下架游戏列表',
        ];

        $logData['action_field'] = $action_field[$selfStatus];
        $logData['description'] = $action[$status] . ' 游戏ID为' . $id;
        Base::dolog($logData);

        return Apps::find($id)->update($data);
    }

    /**
     * 保存到历史
     *
     * @param $id int 游戏ID
     *
     * @return void
     */
    public function history($id) {
        $app = Apps::find($id)->toArray();

        $app['app_id'] = $id;
        unset($app['id']);
        
        $cats = new Cats;
        $app['cats'] = serialize($cats->appCats($id));
        $app['tags']  = serialize($cats->appTags($id));

        // 处理操作人
        $app['operator'] = Sentry::getUser()->id;

        Histories::create($app);
    }


    /**
     * 上传APK
     *
     * @param $dontSave string 是否要入库（空是入库）
     *
     * @return string 上传结果
     */
    public function appUpload($dontSave)
    {
        $uploader = (new CUpload)->instance('app', 'apks')->upload();

        if(!$uploader['result']) return $uploader;

        if(empty($dontSave)) {

            $data = $uploader['result']['data'];

            $app = Apps::where('pack', $data['pack'])
                       ->where('version_code', $data['version_code'])
                       ->first();

            if($app) {
                $status = Config::get('status.apps.status')[$app->status];
                unlink($uploader['result']['fullPath']);
                $uploader['error'] = [
                    'code' => 500, 
                    'message' => '已存在' . $status . '列表中'
                    ];
            } else {
                $app = Apps::create($data);

                $rating = [
                        'app_id' => $app->id, 
                        'title'  => $data['title'], 
                        'pack'   => $data['pack']
                    ];
                Ratings::create($rating);

                $keywords = new Keywords;
                $keywords->store($data['title'], $app->id);

                // 获取MD5队列
                Queue::push('AppQueue@md5', ['id' => $app->id, 'filename' => $app->download_link]);

                // 记录操作日志
                $logData['action_field'] = '游戏管理-添加编辑游戏';
                $logData['description'] = '上传了游戏 游戏ID为' . $app->id;
                Base::dolog($logData);
            }
        }
        
        return $uploader;
    }

    /**
     * 上传图片
     *
     * @return string 上传后路径
     */
    public function imageUpload()
    {
        $uploader = (new CUpload)->instance('image', 'pictures')->upload();

        return $uploader;
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

        $info = Apps::find($id)->toArray();

        if(empty($info)) return false;

        $cats = new Cats;
        $info['cats']   = $cats->appCats($id);
        $info['tags']   = $cats->appTags($id);
        $info['images'] = unserialize($info['images']);

        $keywords = new Keywords;
        $info['keywords'] = $keywords->appKeywords($id);

        return CUtil::array2Object($info);
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

        // 同作者游戏
        $info->sameAuthor = $this->sameAuthor($id, $info->author);

        // 同类游戏
        $info->sameCat = $this->sameCat($id, $info->cats);

        return CUtil::object2Array($info);
    }

    /**
     * 作者游戏
     *
     * @param $id     int    游戏id
     * @param $author string 游戏作者
     * @param $limit  int    数量
     *
     * @return array
     */
    public function sameAuthor($id, $author, $limit = 3)
    {
        $apps = Apps::where('author', $author)
                    ->where('id', '!=', $id)
                    ->limit($limit)
                    ->select(['id', 'title', 'icon'])
                    ->get()
                    ->toArray();

        return $apps;
    }

    /**
     * 同分类游戏
     *
     * @param $id    int   游戏id
     * @param $cats array 分类信息
     * @param $limit int   数量
     *
     * @return array
     */
    public function sameCat($id, $cats, $limit = 3)
    {

        $appCats = new AppCats;
        $ids = $appCats->sameCatAppId($id, $cats, $limit);

        if(empty($ids)) return [];

        $apps = Apps::whereIn('id', $ids)
                    ->select(['id', 'title', 'icon'])
                    ->get()
                    ->toArray();

        return $apps;
    }



}