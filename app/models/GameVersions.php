<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class GameVersions extends \Eloquent
{

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

    /**
     * 增加历史数据
     * 
     * @param $game obj 单个游戏
     *
     * @return void
     */
    public function add($game)
    {
        $fields = [
            'game_id' => 'game_id',
            'entity_id' => 'entity_id',
            'title' => 'title',
            'summary' => 'summary',
            'author' => 'author',
            'icon' => 'icon',
            'md5' => 'md5',
            'size' => 'size',
            'download_link' => 'download_link',
            'package' => 'package',
            'screenshots' => 'screenshots',
            'version' => 'version',
            'version_code' => 'version_code',
            'os' => 'os',
            'os_version' => 'os_version',
            'creator_id' => 'creator_id',
            'creator' => 'creator',
            'operator_id' => 'operator_id',
            'operator' => 'operator',
            'review' => 'review',
            'vendor' => 'vendor',
            'vendor_id' => 'vendor_id',
            'sort' => 'sort',
            'stocked_at' => 'stocked_at',
            'unstocked_at' => 'unstocked_at',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
        ];

        $data = [];
        foreach ($fields as $key => $value) {
            $data[$key] = $game->value;
        }
        $data['game_id'] = $game->id;
        $this->create($data);
    }
}