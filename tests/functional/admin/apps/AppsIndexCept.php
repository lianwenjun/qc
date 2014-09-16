<?php
/*
测试角色场景

上传游戏君: 刚上传并成功读取了APK数据的游戏

    上传游戏A君:  分类 休闲益智 上传时间 2014-09-03
    上传游戏B君:  分类 角色扮演 上传时间 2014-09-01

可怜软件君: 非游戏，异类

标签君: 游戏君的小荣誉标签

分页游戏君: 翻页才能看到的哦，咳咳分页游戏君B是个坏小子

填充游戏君: 专业占座
*/

$I = new FunctionalTester($scenario);
$I->wantTo('添加编辑游戏功能');

// 列表
$I->amOnAction('AppsController@getIndex');
$I->see('上传游戏A君');

/* --------------------------------------------------------
| 搜索功能 begin
-------------------------------------------------------- */

// 模糊搜索
$I->fillField(['name' => 'keyword'], '游戏');
$I->click('查询');
$I->see('上传游戏A君');
$I->see('上传游戏B君');
$I->dontSee('可怜软件A君');


// 精准搜索
$I->fillField(['name' => 'keyword'], '上传游戏A君');
$I->click('查询');
$I->see('上传游戏A君');
$I->dontSee('上传游戏B君');

// 分类搜索
$I->selectOption('form select[name=cate]', '角色扮演');
$I->click('查询');
$I->see('上传游戏B君');
$I->dontSee('上传游戏A君');

// 时间搜索
$I->selectOption('form select[name=cate]', '全部');
$I->fillField(['name' => 'stime'], '2014-09-01');
$I->fillField(['name' => 'etime'], '2014-09-02');
$I->click('查询');
$I->see('上传游戏A君');
$I->dontSee('上传游戏B君');

// 联合搜索
$I->selectOption('form select[name=cate]', '休闲益智');
$I->fillField(['name' => 'keyword'], '游戏');
$I->fillField(['name' => 'stime'], '2014-09-02');
$I->fillField(['name' => 'etime'], '2014-09-03');
$I->click('查询');
$I->see('上传游戏A君');
$I->dontSee('上传游戏B君');
$I->dontSee('可怜软件A君');

/* --------------------------------------------------------
| 搜索功能 end
-------------------------------------------------------- */

// 分页
$I->amOnAction('AppsController@getIndex');
$I->click('2');
$I->see('分页游戏A君');

// 带搜索分页
$I->amOnAction('AppsController@getIndex');
$I->fillField(['name' => 'keyword'], '游戏');
$I->click('查询');
$I->click('2');
$I->see('分页游戏B君');
$I->dontSee('分页游戏A君');
