<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Stopwords extends \Eloquent {
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    protected $table = 'stopwords';
    protected $fillable = [];
    public $messages = [
        'required' => '屏蔽词必须填写',
        'unique' => '屏蔽词已经存在了',
    ];
    public $rules = [
            'word' => 'required|unique:stopwords,word,NULL,id,deleted_at,NULL'
            ];
    public function updateRules($id) {
        return $rules = [
            'word' => 'required|unique:stopwords,word,'.$id .',id,deleted_at,NULL',
            ];
    }
}