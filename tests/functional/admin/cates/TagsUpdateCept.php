<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('更新标签');
//正确测试
$I->sendAjaxPostRequest('/admin/tag/1/edit', ['word' => '我是来打酱油的', 'sort'=>'1']); // POST
$I->see('suss');
$I->sendAjaxPostRequest('/admin/tag/3/edit', ['word' => '12345678901234567890']);
$I->see('suss');
$I->sendAjaxPostRequest('/admin/tag/1/edit', ['word' => '我是来打酱油的', 'sort' => '']); // POST
$I->see('suss');
//错误的
$I->sendAjaxPostRequest('/admin/tag/1/edit', ['word1' => '我是来打酱油的']); // POST
$I->see('word is must need');
$I->sendAjaxPostRequest('/admin/tag/1/edit', ['word1' => '我是来打酱油的', 'sort' => '1']); // POST
$I->see('word is must need');
$I->sendAjaxPostRequest('/admin/tag/1/edit', ['word' => '']); // POST
$I->see('word is must need');
$I->sendAjaxPostRequest('/admin/tag/1/edit', ['word' => '', 'sort' => '']); // POST
$I->see('word is must need');
//不存在的数据
$I->sendAjaxPostRequest('/admin/tag/150/edit', ['word' => '', 'sort' => '']); // POST
$I->see('cate is valid');
$I->sendAjaxPostRequest('/admin/tag/150/edit', ['word' => '我是来打酱油的', 'sort' => '']); // POST
$I->see('cate is valid');