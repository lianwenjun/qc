<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('添加关键字');
//正确测试
$I->sendAjaxPostRequest('/admin/keyword/create', ['word' => '我是来打酱油的']); // POST
$I->see('suss');
$I->sendAjaxPostRequest('/admin/keyword/create', ['word' => '12345678901234567890']);
$I->see('suss');
//错误的
$I->sendAjaxPostRequest('/admin/keyword/create', ['word1' => '我是来打酱油的']); // POST
$I->see('word is must need');
$I->sendAjaxPostRequest('/admin/keyword/create', ['word' => '']); // POST
$I->see('word is must need');
