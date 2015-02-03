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
    protected $description = 'cats表的拆分与数据导入';

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
        if (Schema::hasTable('cats_bak'))
        {   
            $this->info("=================== 开始导入数据  ====================");
            echo "cats表已备份为cats_bak,开始清空新表!\n";
            DB::statement('truncate table cats');
            echo "cats表清空!\n";
            DB::statement('truncate table tags');
            echo "tags表清空!\n";
            DB::statement('truncate table game_cat_tags');
            echo "game_cat_tags表清空\n";

            // 获取老版本数据
            $cats = DB::select('select id,title,sort,created_at,updated_at,deleted_at from cats_bak where parent_id = 0');
            $tags = DB::select('select id,title,sort,parent_id,created_at,updated_at,deleted_at from cats_bak where parent_id > 0');
           
            // 导入cats新表数据
            if (! empty($cats)) {
                // 新表cats有个新字段position,这里默认定义为hotcats;
                $position = 'gamecats';
                $catId = [];

                foreach ($cats as $cat) {
                    DB::insert('insert into cats (id,title,sort,position,created_at,updated_at,deleted_at) values(?,?,?,?,?,?,?)', [$cat->id, $cat->title, $cat->sort, $position, $cat->created_at, $cat->updated_at, $cat->deleted_at]);
                    $catId[] = $cat->id;
                }

                $catIds = implode(',', $catId);
                $catsGames = DB::select('select app_id,cat_id,created_at,updated_at from app_cats where cat_id in ('.$catIds.')');

                echo "cats数据导入成功！\n";
            } else {
                echo "导入失败!\n";
            }

            // 导入tags新表数据 & 导入game_cat_tags新表数据 注：如果有同名的tags该怎么处理？如果强行处理合并的话id的结构会被破坏掉
            if (! empty($tags)) {
                $tagId = [];

                foreach ($tags as $tag) {
                    DB::insert('insert into tags (id,title,search_count,sort,deleted_at,created_at,updated_at) values(?,?,?,?,?,?,?)', [$tag->id, $tag->title, 0, $cat->sort, $cat->deleted_at, $cat->updated_at, $cat->created_at]);
                    DB::insert('insert into game_cat_tags (cat_id,tag_id,deleted_at,created_at,updated_at) values(?,?,?,?,?)', [$tag->parent_id, $tag->id, $cat->deleted_at, $cat->updated_at, $cat->created_at]);
                    $tagId[] = $tag->id;
                }

                $tagIds = implode(',', $tagId);
                $tagsGames = DB::select('select app_id,cat_id,created_at,updated_at from app_cats where cat_id in ('.$tagIds.')');

                echo "tags数据导入成功！\ngame_cat_tags数据导入成功！\n";

            } else {
                echo "导入失败!\n";
            }

            // app_cats 的分类游戏数据导入
            if (! empty($catsGames)) {
                foreach ($catsGames as $catsGame) {
                    DB::insert('insert into game_cat_tags (game_id,cat_id,created_at,updated_at) values(?,?,?,?)', [$catsGame->app_id, $catsGame->cat_id, $catsGame->updated_at, $catsGame->created_at]);
                }

                echo "app_cats分类游戏数据导入到game_cat_tags成功！\n";
            }

            // app_cats 的标签游戏数据导入
            if (! empty($tagsGames)) {
                foreach ($tagsGames as $tagsGame) {
                    DB::insert('insert into game_cat_tags (game_id,tag_id,created_at,updated_at) values(?,?,?,?)', [$catsGame->app_id, $catsGame->cat_id, $catsGame->updated_at, $catsGame->created_at]);
                }

                echo "app_cats标签游戏数据导入到game_cat_tags成功！\n";
            }

            $this->info("=================== 成功！ ====================");
        } else {
            $this->info("=================== 警告！请先备份cats表 ====================");
        }
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
