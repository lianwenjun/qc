<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('分类/标签删除');
//标签测试
$I->amOnpage('/admin/tag/1/delete');
//$I->seeSessionHasValues(['msg' => '#1删除成功']);
$I->see('ok');
//不存在测试
$I->amOnpage('/admin/tag/20/delete');
//$I->seeSessionHasValues(['msg' => '#2不存在']);
$I->see('error');

//分类测试
$I->amOnpage('/admin/cate/2/delete');
//$I->seeSessionHasValues(['msg' => '#1删除成功']);
$I->see('ok');
//不存在测试
$I->amOnpage('/admin/cate/3/delete');
//$I->seeSessionHasValues(['msg' => '#2不存在']);
$I->see('error');



