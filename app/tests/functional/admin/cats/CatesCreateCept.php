<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('添加分类');
//正确测试
$I->sendAjaxPostRequest('/admin/cat/create', ['word' => '我是来打酱油的']); // POST
$I->see('suss');
$I->sendAjaxPostRequest('/admin/cat/create', ['word' => '12345678901234567890']);
$I->see('suss');

//错误测试
$I->sendAjaxPostRequest('/admin/cat/create', ['word1' => '12345678901234567890']);
$I->see('error');
$I->sendAjaxPostRequest('/admin/cat/create', ['word' => '']);
$I->see('error');