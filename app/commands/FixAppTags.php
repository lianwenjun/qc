<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class FixAppTags extends Command
{
    /**
     * 命令名称
     *
     * @var string
     */
    protected $name = 'fix-apptags';

    /**
     * 命令注释
     *
     * @var string
     */
    protected $description = '修复所有游戏的标签数据，把旧表中没有导入过来的都导入到新表app_cats中';

    /**
     * Create a new command instance
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取执行命令的参数
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    protected function getOptions()
    {
        return [];
    }

    /**
     * Execute the console command
     *
     * @return void
     */
    public function fire()
    {
        $this->info("==========start fix all app tags==========");

        DB::connection('olds')->table('tbl_APP')
                           ->select('APP_Id', 'APP_Tag')
                           ->where('APP_Tag', '<>', '')
                           ->chunk(500, function($result)
                            {
                                foreach ($result as $key => $value) {
                                    // 找出老数据表中的标签数据
                                    $tags = $this->_htmlToArray($value->APP_Tag);

                                    // 现在的表中对应appid的标签数据
                                    $hasTags = DB::table('app_cats')
                                                   ->where('app_id', $value->APP_Id)
                                                   ->lists('cat_id');

                                    // 合并所有找到的标签去重组合成完整的标签数据
                                    $allTags = array_unique(array_merge($tags, $hasTags));

                                    // 将没有在app_cats表中的标签添加进去
                                    foreach ($allTags as $k => $v) {
                                        if (!in_array($v, $hasTags)) {
                                            $this->info("正在为app_id:{$value->APP_Id}添加cat_id:{$v}");
                                            AppCats::create([
                                                'app_id' => $value->APP_Id,
                                                'cat_id' => $v,
                                            ]);
                                        }
                                    }
                                }
                            });

        $this->info("==========fix done==========");
    }

    /**
     * 老数据表中的包含html代码的奇葩数据转换为数组
     *
     * @param string $str html代码字符串
     *
     * @return array
     */
    private function _htmlToArray($str)
    {
        $str = preg_replace('/<\/?[^>]+>/i', ',', $str);
        $str = str_replace(',,', '|', trim($str, ','));
        $arr = explode('|', $str);

        return $arr;
    }
}