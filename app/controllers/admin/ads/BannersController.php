<?php

class Admin_Ads_BannersController extends \Admin_BaseController {

    /**
    * 定义Banners的广告位置类型
    *
    * @var bannerLocations array
    */
    protected $bannerLocations = ['banner_slide', 'banner_new', 'banner_hot'];

	/**
     * 首页广告位管理(app首页,新品抢玩,热门下载)三个首页的轮播焦点图
     * GET /banners
     *
     * @return Response
     */
	public function index()
	{      
        // 获取广告配置信息
        $locations = Config::get('status.ads.bannerLocation');
        $status = Config::get('status.ads.status');
        $location = Input::get('location');
        $ofStatus = Input::get('status');
        $title = Input::get('title');
        
		$banners = Ads::lists(
            $this->pagesize,
            $this->bannerLocations, 
            $location, 
            $ofStatus, 
            $title
        );
        
		$datas = [
            'banners' => $banners, 
            'status' => $status,   
            'locations' => $locations
        ];

		return view::make('evolve.ads.banners')->with('datas', $datas);
	}

	/**
     * 首页广告位添加页
     * GET /admin/ads/create
     *
     * @return Response
     */
    public function create()
    {
        $locations = Config::get('status.ads.bannerLocation');
        $datas = [
            'routeAs' => 'banners.',
            'type' => 'banners',
            'locations' => $locations
        ];
        
        return View::make('evolve.ads.create')->with('datas', $datas);
    }

	/**
	 * 首页广告位添加入库
	 * POST /banners
	 *
	 * @return Response
	 */
	public function store()
	{
		$data = Input::all();
		$validator = Ads::isNewValid($data, $this->bannerLocations);

		if ($validator->fails()) {
			return Redirect::to('admin/banners/create')->withErrors($validator);
        }

        if (Ads::create($data)) {
            return Redirect::to('admin/banners')->withSuccess('# ' .$id. ' 添加成功!');
        } 

        return Response::make('404 页面找不到', 404);
        
        
	}

	/**
	 * 首页广告位编辑页
	 * GET /banners/{id}/edit
	 *
	 * @param $id int 
	 * 
	 * @return Response
	 */
	public function edit($id)
	{
        $banner = Ads::isLocation($this->bannerLocations)->ofStatus('stock')
                                                         ->find($id);
		if ($banner) {
			$locations = Config::get('status.ads.bannerLocation');
	        $datas = [
	        	'banner' => $banner, 
	            'locations' => $locations
	        ];

			return View::make('evolve.ads.edit')->with('datas', $datas);
		} 

		return Response::make('404 页面找不到', 404);
		
	}

	/**
	 * 首页广告位更新
	 * PUT /banners/{id}
	 *
	 * @param $id int
	 *
	 * @return Response
	 */
	public function update($id)
	{
		$data = Input::all();
        $validator = Ads::isNewValid($data, $this->bannerLocations);
        
		if ($validator->fails()) {
			return Redirect::to('admin/ads/banners/'. $id .'/edit')->withErrors($validator);
		}

        $banner = Ads::where('id', $id)->isLocation($this->bannerLocations)
                                       ->ofStatus('stock')
                                       ->update($data);
		if ($banner) {
			return Redirect::to('admin/ads/banners')->withSuccess('# ' .$id. ' 更新成功!');
		} 

		return Response::make('404 页面找不到', 404);
		
	}

	/**
	 * 首页广告位删除
	 * DELETE /banners/{id}
	 *
	 * @param  $id int  
	 *
	 * @return Response
	 */
	public function destroy($id)
	{
        $banner = Ads::where('id', $id)->isLocation($this->bannerLocations)
                                       ->ofStatus('unstock')
                                       ->delete();

		if ($banner) {
			return Redirect::to('admin/ads/banners')->withSuccess('# ' .$id. ' 删除成功!');
		}

		return Response::make('404 页面找不到', 404);
		
	}

    /**
     * 首页广告位下架
     * PUT /banners/{id}/unstock
     *
     * @param  $id int  
     *
     * @return Response
     */
    public function unstock($id)
    {
        $banner = Ads::where('id', $id)->isLocation($this->bannerLocations)
                                       ->ofStatus('stock')
                                       ->update(['status'=>'unstock']);
                                       
        if ($banner) {
            return Redirect::to('admin/ads/banners')->withSuccess('# ' .$id. ' 已下架!');
        } 

        return Response::make('404 页面找不到', 404);
        
    }

    /**
     * 首页广告位图片上传
     * POST /banners/image
     *
     * @return Response
     */
    public function imageUpload()
    {
        return (new CUpload('ad'))->run();
    }



}