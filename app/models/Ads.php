<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Ads extends \Eloquent {
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    protected $table = 'ads';
    
    protected $fillable = ['app_id', 'title', 'location', 'image', 'onshelfed_at', 
                'offshelfed_at', 'type', 'is_onshelf', 'is_top', 'sort', 'word'];
    //添加广告检测
    public $adsCreateRules = [
                'app_id' => 'required|integer',
                'title' => 'required',
                'location' => 'required',
                'image' => 'required',
                'is_top' => 'in:yes,no',
                'onshelfed_at' => 'required',
                'offshelfed_at' => 'required'
            ];
    //广告更新检测      
    public $adsUpdateRules = [
                'is_top' => 'in:yes,no',
            ];
    //添加排行广告检测
    public $rankadsCreateRules = [
                'app_id' => 'required|integer',
                'title' => 'required',
                'location' => 'required',
                'sort' => 'integer',
                'onshelfed_at' => 'required',
                'offshelfed_at' => 'required'
            ];
    //更新排行广告检测
    public $rankadsUpateRules = [
                'sort' => 'integer',
            ];
    /*
    * 添加广告
    * @param type
    * @param Input::all()
    * @respone data
    */
    public function createAds($type) {
        $fields = [
            'app_id' => Input::get('app_id'),
            'title' => Input::get('title'),
            'location' => Input::get('location'),
            'image' => Input::get('image', ''),
            'is_top' => Input::get('is_top', 'no'),
            'onshelfed_at' => Input::get('onshelfed_at'),
            'offshelfed_at' => Input::get('offshelfed_at'),
            'type' => $type,
            'is_onshelf' => 'yes', 
            'sort' => Input::get('sort', 0), 
            'word' => Input::get('word', ''),
            ];
        $ad = Ads::create($fields);
        return $ad;
    }

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
    // 下架广告
    public function offshelf($id, $type){
        $ad = Ads::where('id', $id)->where('type', $type)->first();
        if (!$ad) {
            return false;
        }
        $ad->is_onshelf = 'no';
        if (!$ad->save()){
            return false;
        }
        return true;
    }
    // 删除广告
    public function deleteAds($id, $type, $userId = false){
        $ad = Ads::where('id', $id)->where('type', $type)->first();
        if (!$ad) {
            return false;
        }
        if (!$ad->delete()){
            return false;
        }
        return true;
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