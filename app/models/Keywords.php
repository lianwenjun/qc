<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Keywords extends \Eloquent {
    
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    protected $table = 'keywords';
    protected $fillable = [];
    //过滤更新
    public function validateUpate(){
        $validator = Validator::make(
            [
                'word' => Input::get('word'),
                'is_slide' => Input::get('is_slide'),
            ],
            [
                'word' => 'required|min:1',
                'is_slide' => 'in:yes,no',
            ]
        );
        return $validator;
    }
    //过滤添加
    public function validateCreate(){
        $validator = Validator::make(
            [
                'word' => Input::get('word'),
            ],
            [
                'word' => 'required|min:1',
            ]
        );
        return $validator;
    }
}