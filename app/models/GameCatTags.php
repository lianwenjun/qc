<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class GameCatTags extends \Eloquent {

    use SoftDeletingTrait;

    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    protected $table = 'game_cat_tags';
    protected $fillable = [];

 }