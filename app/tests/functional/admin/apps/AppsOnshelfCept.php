<?php
/*
测试角色场景

上架游戏君: 已上架游戏

    上架游戏A君   分类 休闲益智 标签 标签A君 包名 a.a.a 大小 1G 版本 3.0.0 上架时间 2014-09-03 下载次数 100
    上架游戏B君   分类 角色扮演 标签 标签B君 包名 b.b.b 大小 1M 版本 5.0.0 上架时间 2014-09-01 下载次数 101
    上架游戏C君   分类 角色扮演 标签 标签B君 包名 c.c.c 大小 2G 版本 5.0.0 上架时间 2014-09-05 下载次数 99

可怜软件君: 非游戏，异类

标签君: 游戏君的小荣誉标签

分页游戏君: 翻页才能看到的哦，咳咳分页游戏君B是个坏小子

填充游戏君: 专业占座

未知游戏君: 未知属性，找不到，不存在

下架游戏君: 已经下架游戏

上传游戏君: 刚上传并成功读取了APK数据的游戏

审核游戏君: 住在待审核列表
*/

$I = new FunctionalTester($scenario);
$I->wantTo('上架游戏列表功能');

// 登陆
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

$I->amOnAction('Admin_AppsController@onshelf');
$I->see('上架游戏C君');

/* --------------------------------------------------------
| 搜索功能 begin
-------------------------------------------------------- */

// 名称搜索 上架游戏A
$I->sendAjaxRequest('GET', '/admin/apps/onshelf?type=title&keyword=上架游戏A&size_int%5B%5D=&size_int%5B%5D=&onshelfed_at%5B%5D=&onshelfed_at%5B%5D=');
$I->see('上架游戏A君');
$I->dontSee('上架游戏B君');

// 包名搜索 b.b.b
$I->sendAjaxRequest('GET', '/admin/apps/onshelf?type=pack&keyword=b.b.b&size_int%5B%5D=&size_int%5B%5D=&onshelfed_at%5B%5D=&onshelfed_at%5B%5D=');
$I->see('上架游戏B君');
$I->dontSee('上架游戏A君');

// 版本号搜索 3.0.0
$I->sendAjaxRequest('GET', '/admin/apps/onshelf?type=version&keyword=3.0.0&size_int%5B%5D=&size_int%5B%5D=&onshelfed_at%5B%5D=&onshelfed_at%5B%5D=');
$I->see('上架游戏A君');
$I->dontSee('上架游戏B君');

// 大小搜索 1m
$I->sendAjaxRequest('GET', '/admin/apps/onshelf?type=&keyword=&size_int%5B%5D=1m&size_int%5B%5D=1m&onshelfed_at%5B%5D=&onshelfed_at%5B%5D=');
$I->see('上架游戏B君');
$I->dontSee('上架游戏A君');

// 日期搜索 2014-09-01
$I->sendAjaxRequest('GET', '/admin/apps/onshelf?type=&keyword=&size_int%5B%5D=1m&size_int%5B%5D=1m&onshelfed_at%5B%5D=2014-09-01&onshelfed_at%5B%5D=2014-09-01');
$I->see('上架游戏B君');
$I->dontSee('上架游戏A君');

// 联合搜索 名称搜索 上架游戏A 日期搜索 2014-09-03
$I->sendAjaxRequest('GET', '/admin/apps/onshelf?type=title&keyword=上架游戏A&size_int%5B%5D=&size_int%5B%5D=&onshelfed_at%5B%5D=2014-09-03&onshelfed_at%5B%5D=2014-09-03');
$I->see('上架游戏A君');
$I->dontSee('上架游戏B君');

/* --------------------------------------------------------
| 搜索功能 end
-------------------------------------------------------- */

/* --------------------------------------------------------
| 排序功能 begin
-------------------------------------------------------- */

$I->sendAjaxRequest('GET', '/admin/apps/onshelf?orderby=size_int.desc');
$I->see('上架游戏A君');
$I->dontSee('上架游戏B君');

$I->sendAjaxRequest('GET', '/admin/apps/onshelf?orderby=size_int.asc');
$I->see('上架游戏B君');
$I->dontSee('上架游戏A君');

$I->sendAjaxRequest('GET', '/admin/apps/onshelf?orderby=download_counts.asc');
$I->see('上架游戏A君');
$I->dontSee('上架游戏B君');

$I->sendAjaxRequest('GET', '/admin/apps/onshelf?orderby=download_counts.desc');
$I->see('上架游戏B君');
$I->dontSee('上架游戏A君');

$I->sendAjaxRequest('GET', '/admin/apps/onshelf?orderby=onshelfed_at.desc');
$I->see('上架游戏C君');
$I->see('上架游戏A君');
$I->dontSee('上架游戏B君');

$I->sendAjaxRequest('GET', '/admin/apps/onshelf?orderby=onshelfed_at.asc');
$I->see('上架游戏B君');
$I->dontSee('上架游戏A君');

/* --------------------------------------------------------
| 排序功能 end
-------------------------------------------------------- */
