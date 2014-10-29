<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Api_Cats extends \Eloquent {
    use SoftDeletingTrait;
    protected $fillable = [];
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    protected $table = 'cats';

}