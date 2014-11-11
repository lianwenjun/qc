<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('应用反馈列表功能');

// 登陆
$I->sendAjaxRequest('put', '/admin/users/signin', ['username' => 'test', 'password' => 'test']);

$I->amOnRoute('feedback.index');
$I->see('应用反馈列表');

// ID搜索
$I->amOnPage('/admin/feedback/index?type=id&keyword=1&created_at[]=&created_at[]=');
$I->see('应用反馈列表第一行内容', '//table');

// IMEI搜索
$I->amOnPage('/admin/feedback/index?type=imei&keyword=ABCDEF&created_at[]=&created_at[]=');
$I->see('应用反馈列表第二行内容', '//table');

// 内容搜索
$I->amOnPage('/admin/feedback/index?type=content&keyword=第二行&created_at[]=&created_at[]=');
$I->see('应用反馈列表第二行内容', '//table');

// 时间搜索
$I->amOnPage('/admin/feedback/index?type=&keyword=&created_at[]=2014-10-17&created_at[]=2014-10-18');
$I->see('应用反馈列表第三行内容', '//table');

