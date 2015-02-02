<?php

class Evolve_Game_HistoryController extends \Evolve_BaseController {

    /**
     * 历史列表
     * GET /evolve/game/{gameId}/history
     *
     * @return Response
     */
    public function index($gameId)
    {
        $games = GameHistories::where('game_id', $gameId)->paginate($this->pageSize);

        return View::make('evolve.games.history')->withGames($games);
    }

    /**
     * 列表预览
     * GET /evolve/game/{gameId}/history/{id}/preview
     *
     * @param $gameId int 游戏ID
     * @param $id int 历史ID
     *
     * @return Response
     */
    public function preview($gameId, $id)
    {
        $game = GameHistories::where('game_id', $gameId)->find($id);
        if (! $game) {
            //return App::abort(404);
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

}