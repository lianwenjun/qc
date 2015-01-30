<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class GameHistories extends \EBase
{
    
    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    
    protected $table = 'game_histories';
    protected $fillable = ['id', 'game_id'];
    
}