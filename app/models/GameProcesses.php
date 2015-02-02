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


    public function unstock($game)
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
        
        $data['status'] = 'unstock';
        $this->create($data);
    }
    
}