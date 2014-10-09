<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('编辑更新游戏评论');

//正确测试
$I->sendAjaxPostRequest('/admin/comment/1/edit', ['content' => '我是来打酱油的']); // POST
$I->see('suss');

//错误测试
$I->sendAjaxPostRequest('/admin/comment/1/edit', ['content' => '']); // POST
$I->see('error');

$I->sendAjaxPostRequest('/admin/comment/1/edit', ['content1' => '我是来打酱油的']); // POST
$I->see('error');

$I->sendAjaxPostRequest('/admin/comment/1/edit'); // POST
$I->see('error');