<?php

//use Illuminate\Database\Eloquent\SoftDeletingTrait;

class GameStocks extends \EBase
{
    //use SoftDeletingTrait;

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];
    //protected $softDelete = false;
    
    protected $table = 'game_stocks';
    
    protected $fillable = [
            'id',
            'game_id',
            'entity_id',
            'title',
            'summary',
            'author',
            'icon',
            'md5',
            'size',
            'download_link',
            'package',
            'screenshots',
            'version',
            'version_code',
            'os',
            'os_version',
            'creator_id',
            'creator',
            'operator_id',
            'operator',
            'review',
            'vendor',
            'vendor_id',
            'sort',
            'stocked_at',
            'unstocked_at'
    ];

    /**
     * 游戏列表
     *
     * @param $status array 状态
     * @param $data   array 条件数据
     *
     * @return obj 游戏列表对象
     */
    public function lists()
    {
        return $this->where('status', 'stock')->orderBy('id', 'desc');
    }

    /**
     * 增加上架数据
     * 
     * @param $game obj 单个游戏
     *
     * @return void
     */
    public function add($game, $userId, $username)
    {
        $fields = [
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
            $data[$key] = $game->$value;
        }
        $data['id'] = $game->id;
        $data['operator_id'] = $userId;
        $data['operator'] = $username;
        
        $this->create($data);
    }

    /**
     * 更新为上线数据
     *
     *
     */
    public function patch()
    {

    }

    /**
     * 同一作者的游戏
     * @param string $author
     *
     * @return array
     */
    public function sameAuthor($author)
    {
        $games = $this->select('id', 'icon', 'title')
                      ->where('author', $author)
                      ->take(4)
                      ->get();
        return $games;
    }    
}