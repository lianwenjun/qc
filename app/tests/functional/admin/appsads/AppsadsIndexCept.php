<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('首页游戏位广告列表');
//存在测试
$I->amOnpage('/admin/appsads/index');
$I->see('状态');
$I->see('所属类别');
$I->click('搜索');
$I->click('添加游戏');
$I->see('首页游戏位管理');