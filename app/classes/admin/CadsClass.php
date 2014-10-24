<?php

class Admin_CadsClass {
    public $adsCreateRules = [
                'app_id' => 'required|integer',
                'title' => 'required',
                'location' => 'required',
                'image' => 'required',
                'is_top' => 'in:yes,no',
                'stocked_at' => 'required',
                'unstocked_at' => 'required'
            ];
    //广告更新检测      
    public  $adsUpdateRules = [
                'is_top' => 'in:yes,no',
            ];
    //添加排行广告检测
    public $rankadsCreateRules = [
                'app_id' => 'required|integer',
                'title' => 'required',
                'location' => 'required',
                'sort' => 'integer',
                'stocked_at' => 'required',
                'unstocked_at' => 'required'
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
            'stocked_at' => Input::get('stocked_at'),
            'unstocked_at' => Input::get('unstocked_at'),
            'type' => $type,
            'is_stock' => 'yes', 
            'sort' => Input::get('sort', 0), 
            'word' => Input::get('word', ''),
            ];
        $ad = Ads::create($fields);
        return $ad;
    }
    /*
    * 更新广告
    * @param ad
    * @param Input::all()
    * @respone data
    */
    public function UpdateAds($ad) {
        $ad->location = Input::get('location', $ad->location);
        $ad->is_top = Input::get('is_top', 'no');
        $ad->image = Input::get('image', $ad->image);
        $ad->sort = Input::get('sort', $ad->sort);
        $ad->word = Input::get('word', $ad->word);
        $ad->stocked_at = Input::get('stocked_at', $ad->stocked_at);
        $ad->unstocked_at = Input::get('unstocked_at', $ad->unstocked_at);
        $ad->is_stock = 'yes';
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
            if ( $status == 'stock' ) {
                $query = $query->where('is_stock', 'yes')
                    ->where('stocked_at', '>', date('Y-m-d h:m:s', time()));
            }
            if ( $status == 'unstock' ){
                $query = $query->where('is_stock', 'no');
            }
            if ( $status == 'online' ){
                $query = $query->where('stocked_at', '<=', date('Y-m-d h:m:s', time()))
                    ->where('unstocked_at', '>', date('Y-m-d h:m:s', time()))
                    ->where('is_stock', 'yes');
            }
            if ( $status == 'expired' ){
                $query = $query->where('unstocked_at', '<', date('Y-m-d h:m:s', time()))
                ->where('is_stock', 'yes');
            }
        }
        return $query;
    }
    // 下架广告
    public function unstock($id, $type){
        $ad = Ads::where('id', $id)->where('type', $type)->where('is_stock', 'yes')->first();
        if (!$ad) {
            return false;
        }
        $ad->is_stock = 'no';
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
}
?>