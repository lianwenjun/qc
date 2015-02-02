<?php

//use Illuminate\Database\Eloquent\SoftDeletingTrait;

class GameStocks extends \EBase
{
    //use SoftDeletingTrait;

    protected $dates = ['deleted_at', 'created_at', 'updated_at'];
    //protected $softDelete = false;
    
    protected $table = 'game_stocks';
    protected $fillable = ['id', 'game_id'];

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
     * 增加为上线数据
     *
     *
     */
    public function add()
    {

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