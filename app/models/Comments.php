<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Comments extends \Eloquent {
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    protected $table = 'comments';
    protected $fillable = [];

    public $rules = ['content' => 'required'];
}