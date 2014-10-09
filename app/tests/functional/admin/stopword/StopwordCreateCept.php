<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('添加屏蔽词测试');

//正确测试
$I->sendAjaxPostRequest('/admin/stopword/create', ['word' => '我是来打酱油的']); // POST
$I->see('suss');
$I->sendAjaxPostRequest('/admin/stopword/create', ['word' => '12345678901234567890']);
$I->see('suss');
//错误的
$I->sendAjaxPostRequest('/admin/stopword/create', ['word1' => '我是来打酱油的']); // POST
$I->see('error');
$I->sendAjaxPostRequest('/admin/stopword/create', ['word' => '']); // POST
$I->see('error');
