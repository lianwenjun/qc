<?php
/*
测试角色场景

上传游戏君: 刚上传并成功读取了APK数据的游戏

    上传游戏A君:  分类 休闲益智 上传时间 2014-09-03 10:00:00
    上传游戏B君:  分类 角色扮演 上传时间 2014-09-01 10:00:00

可怜软件君: 非游戏，异类 上传时间 2014-09-02 10:00:00

标签君: 游戏君的小荣誉标签

分页游戏君: 翻页才能看到的哦，咳咳分页游戏君B是个坏小子

填充游戏君: 专业占座
*/

$I = new FunctionalTester($scenario);
$I->wantTo('添加编辑游戏列表功能');

// 列表
$I->amOnAction('Admin_AppsController@draft');
$I->see('上传游戏A君');

/* --------------------------------------------------------
| 搜索功能 begin
-------------------------------------------------------- */

// 模糊搜索
$I->amOnPage('/admin/apps/draft?cate_id=&title=游戏&start-created_at=&end-created_at=');
$I->see('上传游戏A君');
$I->see('上传游戏B君');
$I->dontSee('可怜软件A君');


// 精准搜索
$I->amOnPage('/admin/apps/draft?cate_id=&title=上传游戏A君&start-created_at=&end-created_at=');
$I->see('上传游戏A君');
$I->dontSee('上传游戏B君');

// 分类搜索
$I->amOnPage('/admin/apps/draft?cate_id=2&title=&start-created_at=&end-created_at=');
$I->see('上传游戏B君');
$I->dontSee('上传游戏A君');

// 时间搜索
$I->amOnPage('/admin/apps/draft?cate_id=&title=&start-created_at=2014-09-01&end-created_at=2014-09-02');
$I->see('上传游戏B君');
$I->dontSee('上传游戏A君');

// 联合搜索
$I->amOnPage('/admin/apps/draft?cate_id=1&title=游戏&start-created_at=2014-09-02&end-created_at=2014-09-03');
$I->see('上传游戏A君');
$I->dontSee('上传游戏B君');
$I->dontSee('可怜软件A君');

/* --------------------------------------------------------
| 搜索功能 end
-------------------------------------------------------- */

// 分页
$I->amOnPage('/admin/apps/draft?page=2');
$I->see('分页游戏A君');

// 带搜索分页
$I->amOnPage('/admin/apps/draft?cate_id=&title=游戏&start-created_at=&end-created_at=&page=2');
$I->see('分页游戏B君');
$I->dontSee('分页游戏A君');
