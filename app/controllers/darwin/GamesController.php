<?php

class Darwin_GamesController extends \Darwin_BaseController {

	/**
     * 获得游戏基础数据
     * @param $game obj 游戏对象
     *
     * @return array
     */
    private function getBaseInfo($game)
    {
        $fields = [
            'id' => 'id',
            'cat' => 'cat',
            'icon' => 'icon',
            'size' => 'size',
            'md5' => 'md5',
            'version' => 'version',
            'version_code' => 'version_code',
            'feature' => 'features',
            'summary' => 'summary',
            'package' => 'package',
            'is_patch' => 'is_patch',
            'download_link' => 'download_link',
            'download_display' => 'download_display',
            'rate' => 'rate',
            'comments' => 'comments',
            'review' => 'review',
            'updated_at' => 'updated_at'
        ];
        
        $data = [];

        foreach ($fields as $key => $value) {
            $data[$key] = $game->$value;
        }

        $data['cat'] = ''; // 分类获取
        $data['is_patch'] = false; // 切分版本获取
        $data['updated_at'] = $data['updated_at']->format('Y/m/d');
        $data['size'] = Helper::friendlySize($data['size']);
        
        return $data;
    }

    /**
     * 通过游戏ID获得游戏详情的信息
     * GET /darwin/game/{id}
     *
     * @param $id int 游戏ID
     *
     * @return Response
     */
    public function getInfoById($id)
    {
        $game = GameStocks::find($id);
        if (! $game) {
            return $this->result(['status' => 200, 'message' => '未发现id为' . $id . '的数据']);
        }
        
        $data = $this->getBaseInfo($game);
        $sameAuthors = [];
        $sameCats = [];

        return $this->result(['data' => $data]);
    }

    /**
     * 通过游戏包名获得
     * GET /darwin/game/{pacakge}
     *
     * @param $id int 游戏ID
     *
     * @return Response
     */
    public function getInfoByPackage($package)
    {
        $game = GameStocks::wherePackage($package)->first();
        if (! $game) {
            return $this->result(['status' => 200, 'message' => '未发现pack为' . $package . '的数据']);
        }
        
        $data = $this->getBaseInfo($game);
        $data['screenshots'] = [];
        $data['same_author'] = [];
        $data['same_cat'] = [];
        $data['gift'] = [];
        $data['has_forum'] = false;
        
        return $this->result(['data' => $data]);
    }

	/**
	 * 第一次启动应用弹出精选必玩
	 * GET /darwin/games/chice
	 *
	 * @return Response
	 */
	public function choice()
	{
		$ads = Ads::whereLocation('banner_slide')
			->take('9')
			->orderBy('sort','asc')
			->get();
		$gameIds = [];

		foreach ($ads as $ad) {
			$gameIds[] = $ad->game_id;
		}

		$games = GameStocks::whereIn('id', $gameIds)->get();
		$data = [];
		foreach ($games as $game) {
			$data = $this->getBaseInfo($game);
		}
        
        if (! $data) {
            return $this->result(['status' => 200, 'message' => '还没有数据']);
        }
		
		return $this->result(['data' => $data]);

	}
	

}