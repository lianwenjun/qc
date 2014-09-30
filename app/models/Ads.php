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
                'is_top' => 'in:yes,no',
                'onshelfed_at' => 'required',
                'offshelfed_at' => 'required'
            ];
            
    public $adsUpdateRules = [
                'is_top' => 'in:yes,no',
            ];
    //搜索条件过滤
    public function indexQuery($query) {
        if (Input::get('word')){
            $sql = '%' . Input::get('word') . '%';
            $query = $query->where('title', 'like', $sql);
        }
        if (Input::get('status')){
            $status = Input::get('status');
            if ( $status == 'onshelf' ) {
                $query = $query->where('is_onshelf', 'yes')
                    ->where('onshelfed_at', '>', date('Y-m-d h:m:s', time()));
            }
            if ( $status == 'offshelf' ){
                $query = $query->where('is_onshelf', 'no');
            }
            if ( $status == 'online' ){
                $query = $query->where('onshelfed_at', '<=', date('Y-m-d h:m:s', time()))
                    ->where('offshelfed_at', '>', date('Y-m-d h:m:s', time()))
                    ->where('is_onshelf', 'yes');
            }
            if ( $status == 'expired' ){
                $query = $query->where('offshelfed_at', '<', date('Y-m-d h:m:s', time()))
                ->where('is_onshelf', 'yes');
            }
        }
        return $query;
    }
    //广告图片上传     
    public function imageUpload() {
        return Plupload::receive('file', function ($file)
        {
            list($dir, $filename) = uploadPath('ads', $file->getClientOriginalName());
            $file->move($dir, $filename);

            $savePath = $dir . '/' . $filename;

            return str_replace(public_path(), '', $savePath);
        });
    }
}