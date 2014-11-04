<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('应用反馈列表功能');

//登陆
$I->sendAjaxRequest('put', '/admin/users/signin', ['username' => 'test', 'password' => 'test']);

$I->amOnRoute('feedback.index');
$I->see('应用反馈');

//搜索
$I->selectOption('cate', 'id');
$I->fillField('keyword', '1');
$I->click('.Search_en');
$I->dontSee('没数据', '//table');
$I->seeNumberOfElements('//table/tr', 2);


//搜索错误
$I->selectOption('cate', 'content');
$I->fillField('keyword', 'hehe');
$I->click('.Search_en');
$I->see('没数据');

$I->sendAjaxGetRequest('/admin/feedback/index', ['date' => ['2014-11-16', '2014-11-15']]);
$I->see('没数据');

$I->selectOption('cate', 'imei');
$I->fillField('keyword', 'hehe');
$I->click('搜索');
$I->see('没数据');
