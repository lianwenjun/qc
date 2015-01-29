<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class GameProcesses extends \EBase
{
    
    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    
    protected $table = 'game_processes';
    protected $fillable = ['id', 'game_id'];
    protected $guarded    = ['id'];
    
    
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
    
}