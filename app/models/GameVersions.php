<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class GameVersions extends \Eloquent {

    use SoftDeletingTrait;
    
    protected $dates = ['deleted_at'];

    protected $softDelete = true;

    protected $table = 'game_versions';

    protected $fillable = [];

    /**
     * 根据游戏ID获得游戏的所有版本数据
     * @param $gameId int 游戏ID
     * @param $versionCode int 包代号 
     *
     * @return array
     */
    public function lists($gameId, $versionCode = '')
    {
        $versions = $this->where('game_id', $gameId)->get();
        
        return $versions;
    }
}