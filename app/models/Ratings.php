<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Ratings extends \Eloquent {
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    protected $table = 'ratings';
    protected $fillable = [];
}