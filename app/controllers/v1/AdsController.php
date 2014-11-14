<?php

class V1_AdsController extends \V1_BaseController {
    //编辑精选的字段对应
    private $editorFileds = [
            'download_link' => 'downUrl',
            'title' => 'name',
            'version_code' => 'versionCode',
            'size_int' => 'size',
            'version' => 'version',
            'icon' => 'logourl',
            'md5' => 'md5',
            'gameCategory' => 'gameCategory',
            'pack' => 'packageName',
    ];
    //游戏广告的字段对应
    private $appFiles = [
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
    //字段对应处理，应该可以放置
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
    //取首页广告图片列表
    private function indexAds($location, $pageSize, $pageIndex) {
        $start = (intval($pageIndex) - 1) * intval($pageSize);
        $query = Api_Ads::whereType('banner')->whereLocation($location)->isStock();
        $count = $query->count();
        if ($count == 0){
            return ['count' => 0, 'ads' => []];
        }
        $ads = $query->orderBy('id', 'desc')->orderBy('is_top', 'desc')->skip($start)->take($pageSize)->get();
        $data = [];
        foreach ($ads as $ad) {
            $tmp['id'] = $ad->app_id;
            $tmp['ImgUrl'] = $ad->image;
            $data[] = $tmp;
        }
        $res = [];
        if (count($data) >= 4 || $location != 'banner_slide' || count($data) == 0){
            $res = $data;
        } else {
            while ($location == 'banner_slide' && count($res) < 4) {
                foreach ($data as $value) {
                    if (count($res) < 4) {
                        $res[] = $value;
                    }
                }
            }
        }
        return ['count' => $count, 'ads' => $res];
    }
    //首页游戏位广告列表
    private function appAds($location, $pageSize, $pageIndex, $isTop = 'no') {
        //检测类型
        $types = [
                'hot' => 'app_hot', 
                'new' => 'app_new',
                'search' => 'app_search',
                'surge' => 'app_rise'
        ];
        if (!isset($types[$location])) {
            return ['count' => 0, 'ads' => []];
        }
        $location = $types[$location];
        
        $start = (intval($pageIndex) - 1) * intval($pageSize);
        $query = Api_Ads::whereType('app')->whereLocation($location)->isStock()->isTop($isTop);
        $count = $query->count();
        if ($count == 0){
            return ['count' => 0, 'ads' => []];
        }
        $ads = $query->orderBy('id', 'desc')->skip($start)->take($pageSize)->get();
        $data = [];
        $appIds = [0];
        foreach ($ads as $ad) {
            $appIds[] = $ad->app_id;
            $data[] = $ad->app_id;
        }
        $apps = Api_Apps::whereStatus('stock')->whereIn('id', $appIds)->get();
        $appTmp = [];
        foreach ($apps as $app) {
            $appTmp[$app->id] = $this->appFields($this->appFiles, $app);   
        }
        $res = [];
        foreach ($data as $ad) {
            $tmp = isset($appTmp[$ad]) ? $appTmp[$ad] : [];
            $res[] = $tmp;
        }
        $data = [];
        if (count($res) >= 4 || $isTop != 'yes' || count($data) == 0){
            $data = $res;
        } else {
            while ($isTop == 'yes' && count($data) < 4) {
                foreach ($res as $value) {
                    if (count($data) < 4) {
                        $data[] = $value;
                    }
                }
            }
        }
        return ['count' => $count, 'ads' => $data];
    }
    
    //首页排行位广告列表
    private function edtiorAds($top, $pageSize, $pageIndex) {
        $start = (intval($pageIndex) - 1) * intval($pageSize);
        $query = Api_Ads::whereType('banner')->whereLocation('banner_suggest')->IsStock();
        if ($top == 'yes') {
            $query->isTop();
        }
        $count = $query->count();
        if ($count == 0){
            return ['count' => 0, 'ads' => []];
        }
        $ads = $query->orderBy('id', 'desc')->skip($start)->take($pageSize)->get();
        $data = [];
        $appIds = [0];
        foreach ($ads as $ad) {
            $tmp['id'] = $ad->app_id;
            $tmp['ImgUrl'] = $ad->image;
            $tmp['advert'] = $ad->word;
            $appIds[] = $ad->app_id;
            $data[] = $tmp;
        }
        $apps = Api_Apps::whereStatus('stock')->whereIn('id', $appIds)->get();
        $appTmp = [];
        foreach ($apps as $app) {
            $appTmp[$app->id] = $this->appFields($this->editorFileds, $app);   
        }
        $res = [];
        foreach ($data as $ad) {
            $tmp = isset($appTmp[$ad['id']]) ? $appTmp[$ad['id']] : [];
            if (empty($tmp)) continue;
            $res[] = $tmp + $ad;
        }
        return ['count' => $count, 'ads' => $res];
    }
    /**
     * 首页广告
     * GET /v1/game/extend/{type}/{pageSize}/{pageIndex}
     * @param $type string 类型
     * @param $pageSize string 每页条数
     * @param $pageIndex string 当前请求页码
     * @return Response
     */
    public function banner($type, $pageSize, $pageIndex)
    {
        if (intval($pageSize) < 1) {
            return $this->result(['data' => '[]', 'msg' => 0, 'msgbox' => '每页条数大于0']); 
        };
        $types = ['banner' => 'banner_slide', 'hot' => 'banner_hot', 'new' => 'banner_new'];
        if (!isset($types[$type])) {
            return $this->result(['data' => '[]', 'msg' => 0, 'msgbox' => '分类不存在']);
        }
        $res = $this->indexAds($types[$type], $pageSize, $pageIndex);    
        $pageIndex = intval($pageIndex) > 0 ? $pageIndex : 1;
        $data['pageCount'] =  CUtil::setPageNum($res['count'], $pageSize);
        $data['recordCount'] = $res['count'];
        $data['modelList'] = $res['ads'];
        return $this->result(['data' => $data, 'msg' => 1, 'msgbox' => '数据获取成功']); 
    }
    /**
     * 编辑推荐
     * GET /v1/game/cull{type}/{pageSize}/{pageIndex}
     * @param $type string 类型
     * @param $pageSize string 每页条数
     * @param $pageIndex string 当前请求页码
     * @return Response
     */
    public function editor($type, $pageSize, $pageIndex)
    {
        if (intval($pageSize) < 1) {
            return $this->result(['data' => '[]', 'msg' => 0, 'msgbox' => '每页条数大于0']); 
        };
        $pageIndex = intval($pageIndex) > 0 ? $pageIndex : 1;
        $types = ['cull' => 'yes', 'all' => 'no'];
        if (!isset($types[$type])) {
            return $this->result(['data' => '[]', 'msg' => 0, 'msgbox' => '分类不存在']);
        }
        $res = $this->edtiorAds($types[$type], $pageSize, $pageIndex);
        $data['pageCount'] =  CUtil::setPageNum($res['count'], $pageSize);
        $data['recordCount'] = $res['count'];
        $data['modelList'] = $res['ads'];
        return $this->result(['data' => $data, 'msg' => 1, 'msgbox' => '数据获取成功']);
    }
    /**
     * 游戏广告
     * GET /v1/game/list/{area}/{pageSize}/{pageIndex}
     * @param $type string 类型
     * @param $pageSize string 每页条数
     * @param $pageIndex string 当前请求页码
     * @return Response
     */
    public function app($type, $pageSize, $pageIndex)
    {
        if (intval($pageSize) < 1) {
            return $this->result(['data' => '[]', 'msg' => 0, 'msgbox' => '每页条数大于0']); 
        };
        $types = ['4' => 'yes', '10' => 'no'];
        if (!isset($types[$pageSize])) {
            return $this->result(['data' => '[]', 'msg' => 0, 'msgbox' => '分类不存在']);
        }
        $res = $this->appAds($type, $pageSize, $pageIndex, $types[$pageSize]);
            
        $pageIndex = intval($pageIndex) > 0 ? $pageIndex : 1;
        $data['pageCount'] =  CUtil::setPageNum($res['count'], $pageSize);
        $data['recordCount'] = $res['count'];
        $data['modelList'] = $res['ads'];
        return $this->result(['data' => $data, 'msg' => 1, 'msgbox' => '数据获取成功']);
    }
}