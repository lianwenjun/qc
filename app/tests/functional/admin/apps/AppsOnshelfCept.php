<?php
/*
测试角色场景

上架游戏君: 已上架游戏

    上架游戏A君   分类 休闲益智 标签 标签A君 包名 a.a.a 大小 1G 版本 3.0.0 上传时间 2014-09-03
    上架游戏B君   分类 角色扮演 标签 标签B君 包名 b.b.b 大小 1M 版本 5.0.0 上传时间 2014-09-01

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
$I->amOnAction('Admin_AppsController@onshelf');
$I->see('上架游戏A君');

/* --------------------------------------------------------
| 搜索功能 begin
-------------------------------------------------------- */

// 模糊搜索
$I->selectOption('form select[name=field]', 'title');
$I->fillField(['name' => 'keyword'], '游戏');
$I->click('查询');
$I->see('上架游戏A君');
$I->see('上架游戏B君');
$I->dontSee('可怜软件A君');


// 精准搜索

// 1. 游戏名
$I->selectOption('form select[name=field]', 'title');
$I->fillField(['name' => 'keyword'], '上架游戏A君');
$I->click('查询');
$I->see('上架游戏A君');
$I->dontSee('上架游戏B君');

// 2. 包名
$I->selectOption('form select[name=field]', 'pack');
$I->fillField(['name' => 'keyword'], 'a.a.a');
$I->click('查询');
$I->see('上架游戏A君');
$I->dontSee('上架游戏B君');

// 3. 标签
$I->selectOption('form select[name=field]', 'tag');
$I->fillField(['name' => 'keyword'], '标签A君');
$I->click('查询');
$I->see('上架游戏A君');
$I->dontSee('上架游戏B君');

// 4. 分类
$I->selectOption('form select[name=field]', 'cate');
$I->fillField(['name' => 'keyword'], '角色扮演');
$I->click('查询');
$I->see('上架游戏B君');
$I->dontSee('上架游戏A君');

// 5. 版本号
$I->selectOption('form select[name=field]', 'version');
$I->fillField(['name' => 'keyword'], '5.0.0');
$I->click('查询');
$I->see('上架游戏B君');
$I->dontSee('上架游戏A君');

// 范围搜索

// 1. 大小范围
$I->selectOption('form select[name=field]', '');
$I->fillField(['name' => 'minsize'], '1m');
$I->fillField(['name' => 'maxsize'], '10m');
$I->click('查询');
$I->see('上架游戏B君');
$I->dontSee('上架游戏A君');

// 2. 时间范围
$I->selectOption('form select[name=field]', '');
$I->fillField(['name' => 'stime'], '2014-09-01');
$I->fillField(['name' => 'etime'], '2014-09-02');
$I->click('查询');
$I->see('上架游戏A君');
$I->dontSee('上架游戏B君');

// 额外提示
$I->selectOption('form select[name=field]', 'title');
$I->fillField(['name' => 'keyword'], '未知游戏X君');
$I->click('查询');
$I->see('没搜索到该游戏资料');

$I->selectOption('form select[name=field]', 'title');
$I->fillField(['name' => 'keyword'], '下架游戏A君');
$I->click('查询');
$I->see('此游戏已下架');

$I->selectOption('form select[name=field]', 'title');
$I->fillField(['name' => 'keyword'], '上传游戏A君');
$I->click('查询');
$I->see('此游戏已上传');

$I->selectOption('form select[name=field]', 'title');
$I->fillField(['name' => 'keyword'], '审核游戏A君');
$I->click('查询');
$I->see('此游戏待审核');

// 联合搜索
$I->selectOption('form select[name=field]', 'cate');
$I->fillField(['name' => 'keyword'], '角色扮演');
$I->fillField(['name' => 'minsize'], '1g');
$I->fillField(['name' => 'maxsize'], '10g');
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
$I->amOnAction('Admin_AppsController@onshelf');
$I->click('2');
$I->see('分页游戏A君');

// 带搜索分页
$I->amOnAction('Admin_AppsController@onshelf');
$I->fillField(['name' => 'keyword'], '游戏');
$I->click('查询');
$I->click('2');
$I->see('分页游戏B君');
$I->dontSee('分页游戏A君');