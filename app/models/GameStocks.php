<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class GameStocks extends \EBase
{
    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
    protected $softDelete = false;
    
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
     *
     *
     *
     */
    public function preview($id)
    {
        $game = $this->select('id', 'title', 'screenHots')->find($id);
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
                      ->take(5)
                      ->get();
        return $games;
    }    
}