<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('修改屏蔽词测试');

//正确测试
$I->sendAjaxPostRequest('/admin/stopword/1/edit', ['word' => '我是来打酱油的']); // POST
$I->see('suss');
$I->sendAjaxPostRequest('/admin/stopword/2/edit', ['word' => '12345678901234567890', 'to_word' => '小二上茶']);
$I->see('suss');

//错误的
$I->sendAjaxPostRequest('/admin/stopword/3/edit', ['to_word' => '', 'word' => '']);
$I->see('error');
$I->sendAjaxPostRequest('/admin/stopword/1/edit', ['word1' => '我是来打酱油的']); // POST
$I->see('error');
$I->sendAjaxPostRequest('/admin/stopword/1/edit', ['word' => '']); // POST
$I->see('error');
$I->sendAjaxPostRequest('/admin/stopword/150/edit', ['word' => '我是来打酱油的']); // POST
$I->see('error');
$I->sendAjaxPostRequest('/admin/stopword/1/edit', ['word1' => '我是来打酱油的', 'to_word'=>'']); // POST
$I->see('error');
$I->sendAjaxPostRequest('/admin/stopword/3/edit', ['to_word' => '小二上茶2']);
$I->see('error');

