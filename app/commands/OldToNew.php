<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * 旧后台转新后台数据库处理
 *
 * @author RavenLee
 */
class OldToNew extends Command
{

    /**
     * 命令名称
     *
     * @var string
     */
    protected $name = 'oldtonew';

    /**
     * 命令注释
     *
     * @var string
     */
    protected $description = '旧后台转新后台数据库处理';

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
     * Execute the console command
     *
     * @return mixed
     */
    public function fire()
    {
        $limit = 200;

        $db = 'olds';  // 旧版数据所在库

        $this->info("=================== start  ====================");

        /**
         * 预处理
         */

        // tbl_Apk表
        // DB::connection($db)->statement(DB::raw("update tbl_Apk set Apk_System = REPLACE(Apk_System, 'Android ', '');"));
        // DB::connection($db)->statement(DB::raw("update tbl_Apk set Apk_System = REPLACE(Apk_System, '以上', '')"));
        // DB::connection($db)->statement(DB::raw("update tbl_Apk set Apk_System = REPLACE(Apk_System, '安卓', '');"));

        // // tbl_APP表
        // DB::connection($db)->statement(DB::raw("update tbl_APP set APP_Category = replace(APP_Category, '</id><id>', '|')"));
        // DB::connection($db)->statement(DB::raw("update tbl_APP set APP_Category = replace(APP_Category, '</id>', '')"));
        // DB::connection($db)->statement(DB::raw("update tbl_APP set APP_Category = replace(APP_Category, '<id>', '')"));

        // DB::connection($db)->statement(DB::raw("update tbl_APP set APP_Tag = replace(APP_Tag, '</id><id>', '|')"));
        // DB::connection($db)->statement(DB::raw("update tbl_APP set APP_Tag = replace(APP_Tag, '</id>', '')"));
        // DB::connection($db)->statement(DB::raw("update tbl_APP set APP_Tag = replace(APP_Tag, '<id>', '')"));

        // DB::connection($db)->statement(DB::raw("update tbl_APP set APP_Word = replace(APP_Word, '</id><id>', '|')"));
        // DB::connection($db)->statement(DB::raw("update tbl_APP set APP_Word = replace(APP_Word, '</id>', '')"));
        // DB::connection($db)->statement(DB::raw("update tbl_APP set APP_Word = replace(APP_Word, '<id>', '')"));

        // // 纠正错误数据
        // DB::connection($db)->statement(DB::raw("update tbl_Apk set Apk_From = 3 where Apk_Icon != '' and Apk_From != 3"));
        // echo "预处理 done\n";

        // 清空表
        // DB::statement('truncate table apps');
        // DB::statement('truncate table cats');
        // DB::statement('truncate table keywords');
        DB::statement('truncate table app_cats');
        // DB::statement('truncate table app_keywords');
        // DB::statement('truncate table ratings');
        echo "清空表 done\n";
        
        /*
        // 待审核游戏导入基本信息
        DB::statement("insert into apps (`id`, `icon`, `pack`, `size_int`, `version`, `version_code`, `author`, `changes`, `reason`, `md5`, `os_version`, `download_link`, `stocked_at`, `unstocked_at`, `created_at`, `updated_at`, `has_ad`,`is_verify`,`source`, `entity_id`,`status`) select `Apk_APPId`, `Apk_Icon`, `Apk_PageName`, `Apk_Size`/1024 as size, `Apk_Version`, `Apk_UpdateVersion`, `Apk_Author`, `Apk_UpdateContent`, `Apk_Remark`, `Apk_MD5`, `Apk_System`, `Apk_DownUrl`, `Apk_UpTime`, `Apk_DownTime`, `Apk_AddTime`, `Apk_UpdateTime`, IF(`Apk_IsHaveAd` = 1, 'yes', 'no'), IF(`Apk_IsSafe` = 1, 'yes', 'no'), IF(`Apk_From` = 3, 'uc', 'lt'), `Apk_ProtoID`, 'pending' from {$db}.tbl_Apk where Apk_IsPush = 0 and Apk_IsEdit = 1 and Apk_IsAudit = 0");
        echo "待审核游戏导入基本信息 done\n";

        // 审核不通过游戏导入基本信息
        DB::statement("insert into apps (`id`, `icon`, `pack`, `size_int`, `version`, `version_code`, `author`, `changes`, `reason`, `md5`, `os_version`, `download_link`, `stocked_at`, `unstocked_at`, `created_at`, `updated_at`, `has_ad`,`is_verify`,`source`, `entity_id`, `status`) select `Apk_APPId`, `Apk_Icon`, `Apk_PageName`, `Apk_Size`/1024 as size, `Apk_Version`, `Apk_UpdateVersion`, `Apk_Author`, `Apk_UpdateContent`, `Apk_Remark`, `Apk_MD5`, `Apk_System`, `Apk_DownUrl`, `Apk_UpTime`, `Apk_DownTime`, `Apk_AddTime`, `Apk_UpdateTime`, IF(`Apk_IsHaveAd` = 1, 'yes', 'no'), IF(`Apk_IsSafe` = 1, 'yes', 'no'), IF(`Apk_From` = 3, 'uc', 'lt'), `Apk_ProtoID`, 'notpass' from {$db}.tbl_Apk where Apk_IsPush = 0 and Apk_IsEdit = 1 and Apk_IsAudit = 1 and Apk_IsAuditNo = 0 and Apk_APPId not in(select id from apps)");
        echo "审核不通过游戏导入基本信息 done\n";

        // 已下架游戏导入基本信息
        DB::statement("insert into apps (`id`, `icon`, `pack`, `size_int`, `version`, `version_code`, `author`, `changes`, `reason`, `md5`, `os_version`, `download_link`, `stocked_at`, `unstocked_at`, `created_at`, `updated_at`, `has_ad`,`is_verify`,`source`, `entity_id`, `status`) select `Apk_APPId`, `Apk_Icon`, `Apk_PageName`, `Apk_Size`/1024 as size, `Apk_Version`, `Apk_UpdateVersion`, `Apk_Author`, `Apk_UpdateContent`, `Apk_Remark`, `Apk_MD5`, `Apk_System`, `Apk_DownUrl`, `Apk_UpTime`, `Apk_DownTime`, `Apk_AddTime`, `Apk_UpdateTime`, IF(`Apk_IsHaveAd` = 1, 'yes', 'no'), IF(`Apk_IsSafe` = 1, 'yes', 'no'), IF(`Apk_From` = 3, 'uc', 'lt'), `Apk_ProtoID`, 'unstock' from {$db}.tbl_Apk where Apk_IsPush = 2 and Apk_IsEdit = 1 and Apk_IsAudit = 1 and Apk_IsAuditNo = 1 and Apk_APPId not in(select id from apps)");
        echo "已下架游戏导入基本信息 done\n";

        // 编辑游戏导入基本信息
        DB::statement("insert into apps (`id`, `icon`, `pack`, `size_int`, `version`, `version_code`, `author`, `changes`, `reason`, `md5`, `os_version`, `download_link`, `stocked_at`, `unstocked_at`, `created_at`, `updated_at`, `has_ad`,`is_verify`,`source`, `entity_id`, `status`) select `Apk_APPId`, `Apk_Icon`, `Apk_PageName`, `Apk_Size`/1024 as size, `Apk_Version`, `Apk_UpdateVersion`, `Apk_Author`, `Apk_UpdateContent`, `Apk_Remark`, `Apk_MD5`, `Apk_System`, `Apk_DownUrl`, `Apk_UpTime`, `Apk_DownTime`, `Apk_AddTime`, `Apk_UpdateTime`, IF(`Apk_IsHaveAd` = 1, 'yes', 'no'), IF(`Apk_IsSafe` = 1, 'yes', 'no'), IF(`Apk_From` = 3, 'uc', 'lt'), `Apk_ProtoID`, 'publish' from {$db}.tbl_Apk where Apk_IsPush = 0 and Apk_IsEdit = 0 and Apk_IsAudit = 0 and Apk_IsAuditNo = 0 and Apk_APPId not in(select id from apps)");
        echo "编辑游戏导入基本信息 done\n";

        // 上架游戏导入基本信息
        DB::statement("insert into apps (`id`, `icon`, `pack`, `size_int`, `version`, `version_code`, `author`, `changes`, `reason`, `md5`, `os_version`, `download_link`, `stocked_at`, `unstocked_at`, `created_at`, `updated_at`, `has_ad`,`is_verify`,`source`, `entity_id`, `status`) select `Apk_APPId`, `Apk_Icon`, `Apk_PageName`, `Apk_Size`/1024 as size, `Apk_Version`, `Apk_UpdateVersion`, `Apk_Author`, `Apk_UpdateContent`, `Apk_Remark`, `Apk_MD5`, `Apk_System`, `Apk_DownUrl`, `Apk_UpTime`, `Apk_DownTime`, `Apk_AddTime`, `Apk_UpdateTime`, IF(`Apk_IsHaveAd` = 1, 'yes', 'no'), IF(`Apk_IsSafe` = 1, 'yes', 'no'), IF(`Apk_From` = 3, 'uc', 'lt'), `Apk_ProtoID`, 'stock' from {$db}.tbl_Apk where Apk_IsPush = 1 and Apk_IsAuditNo = 1 and Apk_IsAudit = 1 and Apk_APPId not in(select id from apps)");
        echo "上架游戏导入基本信息 done\n";

        // 更新OS
        DB::statement("update apps set `os` = 'Android'");
        echo "更新OS done\n";

        // 标题更新
        DB::statement("update apps as a set title = (select APP_Name from {$db}.tbl_APP as o where o.APP_Id = a.id)");
        echo "标题更新 done\n";

        // 描述更新
        DB::statement("update apps as a set summary = (select App_Content from {$db}.tbl_APP as o where o.APP_Id = a.id)");
        echo "描述更新 done\n";

        // 手动下载统计
        DB::statement("update apps as a set download_manual = (select APP_Download from {$db}.tbl_APP as o where o.APP_Id = a.id)");
        echo "手动下载统计 done\n";

        // 真实下载统计
        DB::statement("update apps as a set download_counts = (select APP_RelDownload from {$db}.tbl_APP as o where o.APP_Id = a.id)");
        echo "真实下载统计 done\n";

        // 处理显示大小
        $offset = 0;
        do {
            $sql = "select id,size_int from apps limit {$offset}, {$limit}";
            $result = DB::select($sql);

            if (!empty($result)) {
                foreach ($result as $key => $value) {
                    $app = Apps::find($value->id);
                    $app->update(['size' => CUtil::friendlyFilesize($value->size_int*1024)]);
                }
            }
            $offset += $limit;
        } while (!empty($result));
        unset($result);
        echo "处理显示大小 done\n";
        */

        // 处理游戏截图
        echo "处理游戏截图 start\n";
        $offset = 0;
        do {
            $sql = "select id from apps limit {$offset}, {$limit}";

            $result = DB::select($sql);

            if (!empty($result)) {
                foreach ($result as $value) {

                    // 获取最新一个app_id
                    $sql = "select Apk_Id from tbl_Apk where Apk_APPId = {$value->id} order by Apk_APPId desc limit 1";
                    $last = DB::connection($db)->select($sql);

                    // print_r($last[0]->Apk_Id);die;

                    if(isset($last[0])) {
                        $sql = "select Album_ImgUrl from tbl_Apk_Album where Album_ApkId = {$last[0]->Apk_Id} order by Album_SortId asc";
                        $album = DB::connection($db)->select($sql);

                        $data = [];
                        if(!empty($album)) {
                            foreach($album as $v) {
                                $data[] = $v->Album_ImgUrl;
                            }
                        }

                        $app = Apps::find($value->id);
                        $app->update(['images' => serialize($data)]);
                    }

                }
            }

            echo $offset . "\n";

            $offset += $limit;
        } while (!empty($result));
        unset($result);
        echo "处理游戏截图 done\n";

        // 处理游戏截图大小写问题
        DB::statement("update apps set images = replace(images, '/uploads', '/Uploads')");
        echo "处理游戏截图大小写问题 done\n";

        /*

        // 处理本地上传
        $offset = 0;
        do {
            $sql = "select id from apps where source = 'lt' limit {$offset}, {$limit}";

            $result = DB::select($sql);

            if (!empty($result)) {
                foreach ($result as $value) {

                    $app = Apps::find($value->id);

                    $update = [
                        'icon'          => sprintf('/Uploads/ApkIcon/%s.image', $app->md5),
                        'download_link' => sprintf('/Uploads/Apk/%s.apk', $app->md5)
                    ];
                    $app->update($update);

                }
            }

            $offset += $limit;
        } while (!empty($result));
        unset($result);
        echo "处理处理本地上传数据 done\n";

        // 处理Category表数据
        $categorys = DB::connection($db)->select('select * from tbl_Category');
        if (!empty($categorys)) {
            foreach ($categorys as $key => $value) {
                DB::table('cats')->insert(array(
                    'id'            => $value->Category_Id,
                    'title'         => $value->Category_Title,
                    'parent_id'     => $value->Category_ParentId,
                    'search_total'  => $value->Category_RelSearchCount,
                    'sort'          => $value->Category_SortId,
                    'created_at'    => $value->Category_AddTime,
                ));
            }
        }
        unset($categorys);
        echo "处理Category表数据 done\n";
        */
        

        // 游戏分类id处理
        echo "游戏分类id处理 start\n";
        $offset = 0;
        do {
            $result = DB::connection($db)->select("select APP_Id, APP_Category from tbl_APP limit {$offset}, {$limit}");

            if (!empty($result)) {
                foreach ($result as $value) {
                    $c = explode('|', trim($value->APP_Category));
                    foreach ($c as $v) {
                        if(empty($v)) continue;

                        // 是否存在
                        $ex = DB::select("select id from app_cats where app_id = {$value->APP_Id} and cat_id = {$v}");
                        if(empty($ex)) {
                            DB::table('app_cats')->insert(array(
                                'app_id'        => $value->APP_Id,
                                'cat_id'        => $v,
                                'created_at'    => date('Y-m-d H:i:s'),
                            ));
                        }
                    }
                }
            }

            echo $offset . "\n";

            $offset += $limit;
        } while (!empty($result));
        unset($result);
        echo "游戏分类id处理 done\n";

        // 游戏标签id处理
        echo "游戏标签id处理 start\n";
        $offset = 0;
        do {
            $result = DB::connection($db)->select("select APP_Id, APP_Tag from tbl_APP limit {$offset}, {$limit}");

            if (!empty($result)) {
                foreach ($result as $value) {
                    $c = explode('|', trim($value->APP_Tag));
                    foreach ($c as $v) {
                        if(empty($v)) continue;

                        // 是否存在
                        $ex = DB::select("select id from app_cats where app_id = {$value->APP_Id} and cat_id = {$v}");
                        if(empty($ex)) {
                            DB::table('app_cats')->insert(array(
                                'app_id'        => $value->APP_Id,
                                'cat_id'        => $v,
                                'created_at'    => date('Y-m-d H:i:s'),
                            ));
                        }
                    }
                }
            }

            echo $offset . "\n";

            $offset += $limit;
        } while (!empty($result));
        unset($result);
        echo "游戏标签id处理 done\n";

        /*

        // 处理KeyWord表数据
        $offset = 0;
        do {
            $result = DB::connection($db)->select("select Word_Id, Word_Title, Word_SearchCount, IsSlide from tbl_KeyWord limit {$offset}, {$limit}");

            if (!empty($result)) {
                foreach ($result as $value) {
                    DB::table('keywords')->insert(array(
                        'id'            => $value->Word_Id,
                        'word'          => $value->Word_Title,
                        'search_total'  => $value->Word_SearchCount,
                        'is_slide'      => intval($value->IsSlide) > 0 ? 'yes' : 'no',
                        'created_at'    => date('Y-m-d H:i:s'),
                    ));
                }
            }

            $offset += $limit;
        } while (!empty($result));
        unset($result);
        echo "处理KeyWord表数据 done\n";
        

        // 关键字ID处理
        $offset = 0;
        do {
            $result = DB::connection($db)->select("select APP_Id, APP_Word from tbl_APP limit {$offset}, {$limit}");

            if (!empty($result)) {
                foreach ($result as $value) {
                    $c = explode('|', trim($value->APP_Word));
                    foreach ($c as $v) {
                        if(empty($v)) continue;

                        // 是否存在
                        $ex = DB::select("select id from app_keywords where app_id = {$value->APP_Id} and keyword_id = {$v}");
                        if(empty($ex)) {
                            DB::table('app_keywords')->insert(array(
                                'app_id'     => $value->APP_Id,
                                'keyword_id' => $v,
                                'created_at' => date('Y-m-d H:i:s'),
                            ));
                        }
                    }
                }
            }

            $offset += $limit;
        } while (!empty($result));
        unset($result);
        echo "关键字ID处理 done\n";


        // 处理评分
        $offset = 0;
        do {
            $result = DB::connection($db)->select("select APP_Id, APP_Name, App_TotalScore, App_Score, App_RelScore from tbl_APP limit {$offset}, {$limit}");

            if (!empty($result)) {
                foreach ($result as $value) {
                    $app = Apps::find($value->APP_Id);
                    DB::table('ratings')->insert(array(
                        'app_id'     => $value->APP_Id,
                        'title'      => $value->APP_Name,
                        'total'      => $value->App_TotalScore,
                        'avg'        => $value->App_RelScore,
                        'manual'     => $value->App_Score,
                        'pack'       => $app->pack,
                        'created_at' => date('Y-m-d H:i:s'),
                    ));
                }
            }

            $offset += $limit;
        } while (!empty($result));
        unset($result);
        echo "处理评分 done\n";
        */


        // 处理导漏的游戏截图
        echo "处理导漏的游戏截图 start\n";
        $offset = 0;
        do {
            $sql = "select id from apps where id in (select Album_ApkId from {$db}.tbl_Apk_Album) and images = 'a:0:{}' limit {$offset}, {$limit}";

            $result = DB::select($sql);

            if (!empty($result)) {
                foreach ($result as $value) {

                    $sql = "select Album_ImgUrl from tbl_Apk_Album where Album_ApkId = {$value->id} order by Album_SortId asc";
                    $album = DB::connection($db)->select($sql);

                    $data = [];
                    if(!empty($album)) {
                        foreach($album as $v) {
                            $data[] = $v->Album_ImgUrl;
                        }
                    }

                    $app = Apps::find($value->id);
                    $app->update(['images' => serialize($data)]);

                }
            }

            echo $offset . "\n";

            $offset += $limit;
        } while (!empty($result));
        unset($result);
        echo "处理导漏的游戏截图 done\n";

        // 检查是否导完tags
        // select APP_Id from olds.tbl_APP where APP_Tag != '' and APP_Id not in (select app_id from app_cats);

        // 检查是否导完关键字
        // select APP_Id from olds.tbl_APP where APP_Word != '' and APP_Id not in (select app_id from app_keywords);

        // 检查是否导完截图

        $this->info("=================== end  ====================");

    }

    protected function getArguments() {
        return [];
    }

    protected function getOptions() {
        return [];
    }
}