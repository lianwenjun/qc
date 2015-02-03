<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * 将Cat表结构拆分后导入老版本表的数据到新版表中
 *
 * @author Mrlian
 */
class NewCats extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'newcats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->info("=================== 开始导入数据  ====================");
        echo "清空表!\n";
        DB::statement('truncate table cats');
        DB::statement('truncate table tags');
        DB::statement('truncate table game_cat_tags');
        // 获取老版本数据
        $cats = DB::select('select id,title,sort,created_at,updated_at,deleted_at from cats_bak where parent_id = 0');
        $tags = DB::select('select id,title,sort,parent_id,created_at,updated_at,deleted_at from cats_bak where parent_id > 0');
        // 导入cats新表数据
        if (! empty($cats)) {
            // 新表cats有个新字段position,这里默认定义为hotcats;
            $position = 'hotcats';

            foreach ($cats as $cat) {
                DB::insert('insert into cats (id,title,sort,position,created_at,updated_at,deleted_at) values(?,?,?,?,?,?,?)', [$cat->id, $cat->title, $cat->sort, $position, $cat->created_at, $cat->updated_at, $cat->deleted_at]);
            }
            echo "cats数据导入成功！\n";
        } else {
            echo "导入失败!\n";
        }

        // 导入tags新表数据 & 导入game_cat_tags新表数据 注：如果有同名的tags该怎么处理？如果强行处理合并的话id的结构会被破坏掉
        if (! empty($tags)) {
            foreach ($tags as $tag) {
                DB::insert('insert into tags (id,title,search_count,sort,deleted_at,created_at,updated_at) values(?,?,?,?,?,?,?)', [$tag->id, $tag->title, 0, $cat->sort, $cat->deleted_at, $cat->updated_at, $cat->created_at]);
                DB::insert('insert into game_cat_tags (cat_id,tag_id,deleted_at,created_at,updated_at) values(?,?,?,?,?)', [$tag->parent_id, $tag->id, $cat->deleted_at, $cat->updated_at, $cat->created_at]);
            }
            echo "tags数据导入成功！\ngame_cat_tags数据导入成功！\n";

        } else {
            echo "导入失败!\n";
        }
        $this->info("=================== 成功！ ====================");
        
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

}
