<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('游戏排行广告管理下架');
//存在测试
$I->amOnPage('/admin/rankads/17/offshelf');
$I->seeSessionHasValues(['msg' => '亲，#17下架成功了']);
//不存在测试
$I->amOnPage('/admin/rankads/1/offshelf');
$I->seeSessionHasValues(['msg' => '亲，你要下架的1数据不存在']);

$I->amOnPage('/admin/rankads/13/offshelf');
$I->seeSessionHasValues(['msg' => '亲，你要下架的13数据不存在']);