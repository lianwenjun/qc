<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('应用反馈列表功能');

// 登陆
$I->sendAjaxRequest('put', '/admin/users/signin', ['username' => 'test', 'password' => 'test']);

$I->amOnRoute('feedback.index');
$I->see('应用反馈列表');

// ID搜索
$I->selectOption('cate', 'id');
$I->fillField('keyword', '1');
$I->click('.Search_en');
$I->see('应用反馈列表第一行内容', '//table');

// IMEI搜索
$I->selectOption('cate', 'imei');
$I->fillField('keyword', 'ABCDEF');
$I->click('.Search_en');
$I->see('应用反馈列表第二行内容', '//table');

// 内容搜索
$I->selectOption('cate', 'content');
$I->fillField('keyword', '第二行');
$I->click('.Search_en');
$I->see('应用反馈列表第二行内容', '//table');

// 时间搜索
$I->amOnPage('/admin/feedback/index?cate=&keyword=&date[]=2014-10-17&date[]=2014-10-18');
$I->see('应用反馈列表第三行内容', '//table');

