<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Stopwords extends \Eloquent {
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    protected $table = 'stopwords';
    protected $fillable = [];
}