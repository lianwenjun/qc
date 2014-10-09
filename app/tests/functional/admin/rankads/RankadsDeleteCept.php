<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('游戏排行广告删除');
//存在测试
$I->amOnPage('/admin/rankads/15/delete');
$I->seeSessionHasValues(['msg' => '#15删除成功']);
//不存在测试
$I->amOnPage('/admin/rankads/1/delete');
$I->seeSessionHasValues(['msg' => '#1不存在']);
$I->amOnPage('/admin/rankads/100/delete');
$I->seeSessionHasValues(['msg' => '#100不存在']);
$I->amOnPage('/admin/rankads/13/delete');
$I->seeSessionHasValues(['msg' => '#13不存在']);