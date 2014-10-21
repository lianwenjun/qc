<?php
use Illuminate\Database\Eloquent\SoftDeletingTrait;
class Keywords extends \Eloquent {
    
    use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $softDelete = true;
    protected $table = 'keywords';
    protected $guarded    = ['id'];


    //过滤更新
    public function validateUpate(){
        $validator = Validator::make(
            [
                'word' => Input::get('word'),
                'is_slide' => Input::get('is_slide'),
            ],
            [
                'word' => 'min:1',
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
                'word' => 'required|min:1|unique:keywords',
            ]
        );
        return $validator;
    }


    /**
     * 保存关键字
     *
     * @param $words string 关键字(多关键字,隔开)
     * @param $id    int    游戏ID
     *
     * @return void
     **/
    public function store($words, $id = 0)
    {
        $keywords = explode(',', $words);

        if(! empty($id) ) {
            AppKeywords::where('app_id', $id)->delete();
        }

        foreach($keywords as $key => $value) {
            $keyword = Keywords::firstOrCreate(['word' => $value]);

            if(! empty($id) ) {
                AppKeywords::create(['app_id' => $id, 'keyword_id' => $keyword->id]);
            }
        }
    }

    /**
     * 获取单个游戏的关键字
     *
     * @param $id int 游戏 ID
     *
     * @return array ['xxx', 'xxx2'] 关键字数组
     */
    public function appKeywords($id)
    {

        $data = [];
        $ids = AppKeywords::select('keyword_id')
                       ->where('app_id', $id)
                       ->get()->toArray();

        if($ids) {
            $data = Keywords::select(['word'])
                         ->whereIn('id', $ids)
                         ->get()->toArray();
        }

        $keywords = [];
        foreach($data as $val) {
            $keywords[] = $val['word'];
        }

        return $keywords;
    }
}