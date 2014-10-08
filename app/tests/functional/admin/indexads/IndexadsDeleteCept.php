<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('首页图片位管理删除');
//存在测试
$I->amOnPage('/admin/indexads/18/delete');
$I->seeSessionHasValues(['msg' => '#18删除成功']);
//不存在测试
$I->amOnPage('/admin/indexads/1/delete');
$I->seeSessionHasValues(['msg' => '#1不存在']);
