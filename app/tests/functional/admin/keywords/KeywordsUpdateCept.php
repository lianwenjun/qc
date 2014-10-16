<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('编辑关键词');
//正常
$I->sendAjaxPostRequest('/admin/keyword/1/edit', ['word' => '实际就是来打酱油的', 'is_slide' => 'no']);
$I->see('suss');
$I->sendAjaxPostRequest('/admin/keyword/1/edit', ['word' => '实际就是来打酱油的', 'is_slide' => 'yes']);
$I->see('suss');
$I->sendAjaxPostRequest('/admin/keyword/1/edit', ['word' => '实际就是来打酱油的2']);
$I->see('suss');
//word缺少
$I->sendAjaxPostRequest('/admin/keyword/1/edit', ['word1' => '实际就是来打酱油的', 'is_slide' => 'yes']);
$I->see('suss');
//word为空
$I->sendAjaxPostRequest('/admin/keyword/1/edit', ['word' => '', 'is_slide' => 'no']);
$I->see('suss');
//错误方式
//不存在该数据
$I->sendAjaxPostRequest('/admin/keyword/250/edit', ['word' => '实际就是来打酱油的', 'is_slide' => 'yes']);
$I->see('id is valid');
//slide状态错误
$I->sendAjaxPostRequest('/admin/keyword/1/edit', ['word' => '实际就是来打酱油的', 'is_slide' => 'OK']);
$I->see('word is must need');


//word缺少
$I->sendAjaxPostRequest('/admin/keyword/1/edit', ['word1' => '实际就是来打酱油的']);
$I->see('suss');
