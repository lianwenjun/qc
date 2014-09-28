<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('添加分类');
//正确测试
$I->sendAjaxPostRequest('/admin/cate/create', ['word' => '我是来打酱油的']); // POST
$I->see('suss');
$I->sendAjaxPostRequest('/admin/cate/create', ['word' => '12345678901234567890']);
$I->see('suss');

//错误测试
$I->sendAjaxPostRequest('/admin/cate/create', ['word1' => '12345678901234567890']);
$I->see('error');
$I->sendAjaxPostRequest('/admin/cate/create', ['word' => '']);
$I->see('error');