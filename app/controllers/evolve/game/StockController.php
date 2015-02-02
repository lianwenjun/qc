<?php

class Evolve_Game_StockController extends \Evolve_BaseController {

    /**
     * 上架游戏
     * GET /evolve/game/stock
     *
     * @return Response
     */
    public function index()
    {
        $GameStocks = new GameStocks();
        $games = $GameStocks->lists()->paginate(20);

        // $cats    = new Cats;
        //$apps    = new ;
        $allCats = [];//$cats->allCats();
        // TODO 空提示

        return View::make('evolve.games.stock')
                   ->with('games', $games)
                   ->with('cats', $allCats);
    }

    /**
     * 上架游戏预览
     * GET /evolve/game/stock/{id}/preview
     *
     * @return Response
     */
    public function preview($id)
    {
        
        $game = GameStocks::find($id);
        if (! $game) {
            return ['success' => false, 'msg' => '未找到游戏'];
        }
        
        $data = ['title', 'icon', 'version', 'review'];
        $info = [];
        foreach ($data as $key) {
            $info[$key] = $game->$key;
        }
        $info['updated_at'] = $game->updated_at->format('Y/m/d');
        $info['screenshots'] = unserialize($game->screenshots);
        $info['size'] = Helper::friendlySize($game->size);
        $info['cat'] = '';
        
        $sameAuthor = (new GameStocks)->sameAuthor($game->author);
        $sameCat = [];
        
        return [
                'success' => true,
                'data' => [
                    'info' => $info,
                    'same_author_games' => $sameAuthor,
                    'same_cat_games' => $sameCat
                ],
                'msg' => '返回成功'
        ];
    }

    /**
     * 下架上架游戏
     * PUT /evolve/game/{id}/unstock
     *
     * @return Response
     */
    public function unstock($id)
    {
        $game = GameStocks::find($id);
        if (! $game) {
            return App::abort(404);
        }
        // 添加到处理库去
        // $new = (new GameProcesses)->unstock($game);
        
        // 删除线上数据
        // 记录操作日志
        $logData['action_field'] = '游戏管理-上架游戏列表';
        $logData['description'] = '下架了游戏 游戏ID为' . $id;
        Base::dolog($logData);
        
        //$game->delete();
        
        // 下架广告位
        // 下架相关的游戏的ID
        /*if($ads = Ads::where('app_id', $id)) {
            $ads->update(['is_stock' => 'no']);
        }*/
        Session::flash('tips', ['success' => true, 'message' => "亲，ID：{$id}已经下架"]);
        
        return Redirect::back();
    }


    /**
     * 更新上架游戏列表的数据，操作结果保存到草稿区
     * GET /evolve/game/stock/{id}/edit
     *
     * @param  $id int 上架游戏ID
     *
     * @return Response
     */
    public function edit($id)
    {
        $game = GameStocks::find($id);
        if (! $game) {
            return App::abort(404);
        }

        return View::make('evolve.games.stock.edit')
                   ->with('game', $game)
                   ->with('cat', $allCat);
    }


}