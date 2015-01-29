<?php

class GameDeltas extends \Eloquent {

    protected $table = 'game_deltas';

    protected $fillable = [];
    
    /**
     * 添加增量包记录
     *
     *
     */
    public function add($game)
    {
        $cDeltaApk = new CDeltaApk();
        $versions = (new GameVersions)->lists($game->id);
        $data = [];

        foreach ($versions as $version) {
            
            $fromVersionCode = $version->versionCode;

            $deltaPath = $cDeltaApk->setDeltaPath($fromVersionCode, $version->versionCode, $game->download_link);
            
            $fullLink = public_path() . $game->download_link;
            $fullDeltaPath = public_path() . $deltaPath;
            $oldPath = public_path() . $version->download_link;

            $result = $cDeltaApk->delta($oldPath, $fullLink, $fullDeltaPath);
            if ($result) {
                $data[] = [
                    'gameId' => $game->id,
                    'from_version_code' => $version->version_code,
                    'to_version_code' => $game->version_code,
                    'from_version' => $version->version,
                    'to_version' => $game->version,
                    'patch_link' => $deltaPath,
                    'status' => ''
                ];
            }
        }


        $this->deleteDelta($game->id);
        foreach ($data as $delta) {
            $this->create($delta);
        }
    }

    /**
     * 获得单个游戏的增量包数据
     *
     * @param $gameId int 游戏ID
     * @param $versionCode int 游戏当前版本代号
     * 
     * @return obj
     */
    public function getDelta($gameId, $versionCode)
    {
        $delta = $this->where('game_id', $gameId)->where('fromVersionCode', $versionCode)->first();
        
        return $delta;
    }

    /**
     * 删除某个游戏的增量包
     * 
     * @param $gameId int 游戏ID
     * 
     * @return void
     */
    public function deleteDelta($gameId)
    {
        $raw = sprintf('DELETE FROM `%s` WEHRE `game_id` = `%s`', $this->table, $gameId);
        DB::delete($raw);
    }

    
}