<?php

class V1_AppsController extends \V1_BaseController {
    //搜索字段对应
    private $searchFields = [
        'comment' => 'commentCnt',
        'download_link' => 'downUrl',
        'download_manual' => 'downloadCnt',
        'gameCategory' => 'gameCategory',
        'id' => 'id',
        'icon' => 'logoImageUrl',
        'md5' => 'md5',
        'title' => 'name',
        'pack' => 'packageName',
        'rating' => 'score',
        'size_int' => 'size',
        'version' => 'version',
        'version_code' => 'versionCode',
    ];
    //游戏信息对应
    private $infoFields = [
        'download_manual' => 'downloadCnt', 
        'id' => 'id',
        'md5' => 'md5', 
        'title' => 'name', 
        'pack' => 'packageName',
        'size_int' => 'size',
        'version' => 'version',
        'version_code' => 'versionCode',
        'author' => 'author',
        'summary' => 'description',
        'changes' => 'updateContent',
        
        'updated_at' => 'uploadTime', //
        'images' => 'screenshotImageUrls',//
        'is_verify' => 'secureVerify',//
        'has_ad' => 'ad', //
        'download_link' => 'downUrl', //
        'icon' => 'logoImageUrl', // 

        'comment' => 'commentCnt', //评论统计
        'rating' => 'score', // 评分
        'gameCategory' => 'gameCategory', //分类名
        'tagList' => 'tagList', //标签列表
        'categoryId' => 'categoryId',//分类ID
    ];
    //字段对应
    private function appFields($fields, $app) {
        if (is_null($app)) return [];
        $app = $app->toArray();
        $data = [];
        foreach ($fields as $key => $value) {
            $data[$value] = '';
        }
        foreach ($app as $key => $value) {
            if (isset($fields[$key])) $data[$fields[$key]] = $value;
        }
        return $data;
    }
    private function searchByAuthor($author, $exclude, $pageSize, $pageIndex) {
        $count = Api_Apps::whereStatus('stock')
            ->whereAuthor($author)
            ->whereNotIn('id', [$exclude])
            ->count();
        $start = (intval($pageIndex) - 1) * intval($pageSize);
        $apps = Api_Apps::whereStatus('stock')
            ->whereAuthor($author)
            ->whereNotIn('id', [$exclude])
            ->skip($start)->take($pageSize)
            ->orderBy('id', 'desc')
            ->get();
        if ($exclude != '0' && !is_null($apps)) {   
            $appIds = array_map(function($x){
                return $x['id'];
            }, $apps->toArray());
            //缓存APC
            Cache::add('author.apps.' . $exclude, serialize($appIds), '100');
        }
        $apps = (new Api_Ratings)->getAppsRatings($apps);
        $apps = (new Api_Comments)->getAppsComments($apps);
        return ['count' => $count, 'apps' => $apps];
        
    }
    private function searchByCat($catId, $exclude, $pageSize, $pageIndex) {
        //需要预先一次取出
        $apps = Api_AppCats::where('cat_id', $catId)->get();
        $appIds = [];
        foreach ($apps as $app) {
            $appIds[] = $app->app_id;
        }
        $start = (intval($pageIndex) - 1) * intval($pageSize);
        //当$exclude 不为0的时候，检查该游戏的作者的数据
        $exIds = []; 
        if ($exclude != '0') { 
            $exIds = Cache::get('author.apps.' . $exclude, '');
            $exIds = $exIds ? unserialize($exIds) : [];
        }
        $appIds = array_diff($appIds, [$exclude] + $exIds);
        if (!$appIds) {
            return ['count' => 0, 'apps' => []];
        }
        $count = Api_Apps::whereStatus('stock')
            ->whereIn('id', $appIds)
            ->count();
        $apps = Api_Apps::whereStatus('stock')
            ->whereIn('id', $appIds)
            ->skip($start)->take($pageSize)
            ->orderBy('sort', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        $apps = (new Api_Ratings)->getAppsRatings($apps);
        $apps = (new Api_Comments)->getAppsComments($apps);
        return ['count' => $count, 'apps' => $apps];
    }
    private function searchByTitle($keyword, $exclude, $pageSize, $pageIndex) {
        $start = (intval($pageIndex) - 1) * intval($pageSize);
        $count = Api_Apps::whereStatus('stock')
            ->ofTitle($keyword)
            ->whereNotIn('id', [$exclude])
            ->count();
        $apps = Api_Apps::whereStatus('stock')
            ->ofTitle($keyword)
            ->whereNotIn('id', [$exclude])
            ->skip($start)->take($pageSize)
            ->orderBy('sort', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        $apps = (new Api_Ratings)->getAppsRatings($apps);
        $apps = (new Api_Comments)->getAppsComments($apps);
        return ['count' => $count, 'apps' => $apps];
    }
    /**
     * 游戏搜索
     * GET /v1/game/search/{type}/{keyword}/{exclude}/{pageSize}/{pageIndex}
     * @return Response
     */
    public function search($type, $keyword, $exclude, $pageSize, $pageIndex)
    {
        if (intval($pageSize) < 1) {
            return $this->result(['data' => '[]', 'msg' => 0, 'msgbox' => '每页条数大于0']); 
        };
        switch ($type) {
            case '1':
                $res = $this->searchByAuthor($keyword, $exclude, $pageSize, $pageIndex);
                break;
            case '2':
                $res = $this->searchByCat($keyword, $exclude, $pageSize, $pageIndex);
                break;
            case '3':
                $res = $this->searchByTitle($keyword, $exclude, $pageSize, $pageIndex);
                break;
            default:
                return $this->result(['data' => '[]', 'msg' => 0, 'msgbox' => '分类不存在']); 
        }
        $data['pageCount'] = CUtil::setPageNum($res['count'], $pageSize);
        $data['recordCount'] = $res['count'];
        foreach ($res['apps'] as $app) {
            $data['modelList'][] = $this->appFields($this->searchFields, $app);
        }
        return $this->result(['data' => $data, 'msg' => 1, 'msgbox' => '数据获取成功']); 
    }

    /*
    * 确认游戏是否新的
    *
    */
    public function check()
    {
        $input = file_get_contents('php://input');
        $input = json_decode($input);
        $clientApps = [];
        foreach ($input as $index) {
            $versionCode = isset($index->versionCode) ? $index->versionCode : 0;
            $appId = isset($index->id) ? $index->id : 0;
            $title = isset($index->title) ? $index->title : '';
            if ($index->id != 0){
                $app = Api_Apps::whereStatus('stock')->ofNew($versionCode)->find($appId);
            } else {
                $app = Api_Apps::whereStatus('stock')->ofNew($versionCode)->whereTitle($title)->first();
            }
            if (!$app) continue;
            $apps = [$app];
            $apps = (new Api_Ratings)->getAppsRatings($apps);
            $apps = (new Api_Comments)->getAppsComments($apps);
            $res = $this->appFields($this->infoFields, $apps[0]);
            if ($res) $clientApps[] = $res;
        }
        return $this->result(['data' => $clientApps, 'msg' => 1, 'msgbox' => '请求成功']); 
    }

    /*
    * 确认本地安装游戏是否有更新
    *
    * @param list apps
    * @-param string packs
    * @-param int versionCode
    * @return  JSON
    */
    public function clientList()
    {
        $input = Input::get('apps');
        if (!is_array($input)) {
            return $this->result(['data' => '', 'msg' => 0, 'msgbox' => '请输入JSON数据']);
        }
        $clientApps = [];
        foreach ($input as $index) {
            if (!isset($index['pack'])) continue;
            $app = Api_Apps::whereStatus('stock')->wherePack($index['pack'])->first();
            if (!$app) continue;
            $apps = [$app];
            $apps = (new Api_Ratings)->getAppsRatings($apps);
            $apps = (new Api_Comments)->getAppsComments($apps);
            $res = $this->appFields($this->infoFields, $apps[0]);
            if ($res) $clientApps[] = $res;
        }
        return $this->result(['data' => $clientApps, 'msg' => 1, 'msgbox' => '请求成功']);
    }
    /**
     * 获得单个游戏的信息
     * GET /api/v1/game/info/appid/{appid}
     *
     * @param  int  $appid
     * @return Response
     */
    public function info($appid)
    {
        $app = Api_Apps::whereStatus('stock')->find($appid);
        if (!$app) {
            return $this->result(['data' => '[]', 'msg' => 0, 'msgbox' => '数据不存在']);
        }
        $apps = [$app];
        $apps = (new Api_Ratings)->getAppsRatings($apps);
        $apps = (new Api_Comments)->getAppsComments($apps);
        $data = $this->appFields($this->infoFields, $apps[0]);
        return $this->result(['data' => $data, 'msg' => 1, 'msgbox' => '数据获取成功']);
    }

    /**
     * 根据关键字自动匹配游戏名称
     * GET /api/v1/game/search/autocomplete/{keyword}
     *
     * @param  string  $keyword
     * @return Response json
     */
    public function autoComplete($keyword)
    {
        $apps = Api_Apps::whereStatus('stock')
            ->ofTitle($keyword)
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();
        $data = [];
        foreach ($apps as $app) {
            $data[] = [
                'id' => $app->id, 
                'name' => $app->title,
                'type' => 1
            ];
        }
        return $this->result(['data' => $data, 'msg' => 1, 'msgbox' => '数据获取成功']);
    }

}