<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('首页图片位管理下架');
//存在测试
$I->amOnPage('/admin/indexads/18/offshelf');
$I->seeSessionHasValues(['msg' => '亲，#18下架成功']);
//不存在测试
$I->amOnPage('/admin/indexads/1/offshelf');
$I->seeSessionHasValues(['msg' => '亲，#1下架失败了']);
