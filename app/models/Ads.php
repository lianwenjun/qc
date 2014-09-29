<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Ads extends \Eloquent {
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    protected $table = 'ads';
    protected $fillable = [];
    
    public $adsCreateRules = [
                'app_id' => 'required|integer',
                'title' => 'required',
                'location' => 'required',
                'image' => 'required',
                'is_top' => 'required|in:yes,no',
                'onshelfed_at' => 'required',
                'offshelfed_at' => 'required'
            ];
            
    public $adsUpdateRules = [
                'image' => 'image',
                'is_top' => 'in,yes,no',
            ];
}