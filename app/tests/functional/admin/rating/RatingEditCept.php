<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('修改游戏评分列表');
//正确测试
$I->sendAjaxPostRequest('/admin/rating/8/edit', ['manual' => '4']);
$I->see('suss');
$I->sendAjaxPostRequest('/admin/rating/8/edit', ['manual' => '1.1']);
$I->see('suss');

//错误测试
$I->sendAjaxPostRequest('/admin/rating/1/edit', ['manual' => '11']);//不存在
$I->see('error');
$I->sendAjaxPostRequest('/admin/rating/8/edit', ['manual' => '0']);
$I->see('error');
$I->sendAjaxPostRequest('/admin/rating/8/edit', ['manual' => '6']);
$I->see('error');
$I->sendAjaxPostRequest('/admin/rating/8/edit', ['manual' => 'ad.de']);
$I->see('error');
