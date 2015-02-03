<?php

class Admin_Ads_GameAdsController extends \Admin_BaseController {

    /**
    * 定义ranks的广告位置类型
    *
    * @var rankLocations array
    */
    protected $rankLocations = ['app_rise', 'rank_new', 'rank_hot'];

    /**
    * 定义apps的广告位置类型
    *
    * @var appLocations array
    */
    protected $appLocations = ['app_rise', 'app_new', 'app_hot'];

    /**
    * 定义choice的广告位置类型
    *
    * @var choiceLocations array
    */
    protected $choiceLocations = ['app_choice'];

    /**
    * 获得相应广告类型
    *
    * @param $type string 广告类型
    *
    * @return $param array
    */
    protected function adsType($type)
    {
        switch ($type) {
            case 'ranks':
                $param = [
                    'locations' => $this->rankLocations, 
                    'status' => 'stock',
                    'location' => Config::get('status.ads.rankLocation')
                ];

                return $param;
                break;
            
            case 'apps':
                $param = [
                    'locations' => $this->appLocations, 
                    'status' => 'stock',
                    'location' => Config::get('status.ads.appLocation')
                ];

                return $param;
                break;
             
            case 'choice':
                $param = [
                    'locations' => $this->choiceLocations, 
                    'status' => null,
                    'location' => ''
                ];

                return $param;
                break;

            default:
                return $param;
                break;
        }
    }

    /**
     * 排行广告位首页
     * GET /rank
     *
     * @return Response
     */
    public function ranks()
    {      
        // 获取广告配置信息
        $locations = Config::get('status.ads.rankLocation');
        $status = Config::get('status.ads.status');
        $location = Input::get('location');
        $ofStatus = Input::get('status');
        $title = Input::get('title');
        
        $ranks = Ads::lists(
            $this->pagesize,
            $this->rankLocations, 
            $location, 
            $ofStatus, 
            $title
        );
        
        $datas = [
            'ranks' => $ranks, 
            'status' => $status,   
            'locations' => $locations
        ];

        return view::make('evolve.ads.ranks')->with('datas', $datas);
    }

    /**
     * 游戏app广告位首页
     * GET /app
     *
     * @return Response
     */
    public function apps()
    {      
        // 获取广告配置信息
        $locations = Config::get('status.ads.appLocation');
        $status = Config::get('status.ads.status');
        $location = Input::get('location');
        $ofstatus = Input::get('status');
        $title = Input::get('title');
        
        $apps = Ads::lists(
            $this->pagesize,
            $this->appLocations, 
            $location, 
            $ofstatus, 
            $title
        );
        
        $datas = [
            'apps' => $apps, 
            'status' => $status,   
            'locations' => $locations
        ];

        return view::make('evolve.ads.apps')->with('datas', $datas);
    }

    /**
     * 游戏精选广告位首页
     * GET /choice
     *
     * @return Response
     */
    public function choice()
    {             
        $title = Input::get('title');
        $choice = Ads::lists($this->pagesize, $this->choiceLocations, $title);

        return view::make('evolve.ads.choice')->with('choice', $choice);        
    }

    /**
     * 游戏广告添加页
     * GET /{type}/create
     * 
     * @return Response
     */
    public function create()
    {
        $route = Route::current()->getName();
        $paths = explode('.', $route);

        if(!isset($paths[1]) && !in_array($paths[1], ['apps', 'ranks', 'choice'])) {
            App::abort(404);
        }

        $type = $paths[1];
        $param = $this->adsType($type);
        $datas = [
            'locations' => $param['location'],
            'type' => $type,
            'routeAs' => 'ads.'.$type.'.', // 添加路由别名变量
        ];

        return view::make('evolve.ads.create')->with('datas', $datas); 
        
    }

    /**
     * 游戏广告添加接口
     * POST /{type}/create
     * 
     * @return Response
     */
    public function store()
    {
        $route = Route::current()->getName();
        $paths = explode('.', $route);

        if (!isset($paths[1]) && !in_array($paths[1], ['apps', 'ranks', 'choice'])) {
            App::abort(404);
        }

        $type = $paths[1];
        $data = Input::all();
        $param = $this->adsType($type);
        $validator = Ads::isNewValid($data, $param['locations']);

        if ($validator->fails()) {
            return Redirect::to('admin/ads/'. $type .'/create')
                ->withErrors($validator);
        }

        if (Ads::create($data)) {
            return Redirect::to('admin/ads/'. $type)->withSuccess('添加成功！');
        }
                            
    }

    /**
     * 游戏广告编辑页
     * GET /{type}/{id}/edit
     *
     * @param $id int 广告id 
     * 
     * @return Response
     */
    public function edit($id)
    {
        $route = Route::current()->getName();
        $paths = explode('.', $route);

        if (!isset($paths[1]) && !in_array($paths[1], ['apps', 'ranks', 'choice'])) {
            App::abort(404);
        }

        $type = $paths[1];
        $param = $this->adsType($type);
        $info = Ads::gameAdsInfo($id, $param['locations'], $param['status']);

        if ($info) {
            $datas = [
                'routeAs' => 'ads.'.$type.'.',
                'type' => $type,
                'info' => $info
            ];

            return view::make('admin.ads.edit')->with('datas', $datas);           
        } 
            
        return Response::make('404 页面找不到', 404);
        
    }

    /**
     * 游戏广告更新接口
     * PUT /{type}/{id}
     *
     * @param $id int 广告id 
     * 
     * @return Response
     */
    public function update($id)
    {
        $route = Route::current()->getName();
        $paths = explode('.', $route);

        if (!isset($paths[1]) && !in_array($paths[1], ['apps', 'ranks', 'choice'])) {
            App::abort(404);
        }

        $type = $paths[1];
        $data = Input::all();
        $param = $this->adsType($type);
        $validator = Ads::isNewValid($data, $param['locations']);

        if ($validator->fails()) {
            $redirect = Redirect::to('admin/ads/'. $type .'/'. $id .'/edit');
            
            return $redirect->withErrors($validator);
        }

        $ads = Ads::isLocation($param['locations'])->ofstatus($param['status'])
                                                   ->where('id', $id)
                                                   ->update($data);

        if ($ads) {
            return Redirect::to('admin/ads/'. $type)->withSuccess('#'.$id.' 更新成功!');                               
        } 

        return Response::make('404 页面找不到', 404);
        
    }

    /**
     * 游戏广告删除接口
     * DELETE /{type}/{id}
     *
     * @param $id int 广告id 
     * 
     * @return Response
     */
    public function destroy($id) 
    {
        $route = Route::current()->getName();
        $paths = explode('.', $route);

        if (!isset($paths[1]) && !in_array($paths[1], ['apps', 'ranks', 'choice'])) {
            App::abort(404);
        }

        $type = $paths[1];
        $param = $this->adsType($type);
        $query = Ads::isLocation($param['locations']);
        $ads = $query->ofstatus($param['status'])
                     ->where('id', $id)
                     ->delete();

        if ($ads) {
            $redirect = Redirect::to('admin/ads/'. $type);

            return $redirect->withSuccess('# ' .$id. ' 删除成功!'); 
        } 

        return Response::make('404 页面找不到', 404);
                                                  
    }

    /**
     * 游戏广告下架接口(ranks,apps)
     * PUT /{type}/{id}/unstock
     *
     * @param $type string 广告类型,$id int 广告id 
     * 
     * @return Response
     */
    public function unstock($id) 
    {
        $route = Route::current()->getName();
        $paths = explode('.', $route);

        if (!isset($paths[1]) && !in_array($paths[1], ['apps', 'ranks', 'choice'])) {
            App::abort(404);
        }

        $type = $paths[1];
        if ($type != 'choice') {
            $param = $this->adsType($type);
            $query = Ads::isLocation($param['locations']);
            $ads = $query->ofstatus($param['status'])
                         ->where('id', $id)
                         ->update(['status'=>'unstock']);

            if ($ads) {
                $redirect = Redirect::to('admin/ads/'. $type);

                return $redirect->withSuccess('# ' .$id. ' 已下架!'); 
            }

            return Response::make('404 页面找不到', 404);
        }

        return Response::make('404 页面找不到', 404);                             
    }
}