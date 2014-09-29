<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('首页游戏广告位删除');
//存在测试
$I->amOnpage('/admin/appsads/1/delete');
$I->seeSessionHasValues(['msg' => '#1删除成功']);
//不存在测试
$I->amOnpage('/admin/appsads/120/delete');
$I->seeSessionHasValues(['msg' => '#120不存在']);