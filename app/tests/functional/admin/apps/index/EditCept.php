<?php 
/*
测试角色场景

草稿游戏君: 刚上传并成功读取了APK数据的游戏

    草稿游戏A君 ID 14 状态 draft 

待审游戏君: 待审游戏君

*/
$I = new FunctionalTester($scenario);
$I->wantTo('添加编辑游戏编辑功能');

// 登陆
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

// 必填验证
$I->amOnPage('/admin/apps/draft/14');
$data = [
    'cates'           => [1,2],
    'author'          => '草稿制造厂',
    'os_version'      => '3.0',
    // 'version_code'    => 22,
    'sort'            => 99,
    'download_manual' => '1万+',
    'summary'         => '我是即将变成审核游戏君的男人',
    'images'          => ['/pictures/6/b/6bcfd1ee3b3dbdd58dea0e046f08ee6e.jpg'],
    'changes'         => 'fixes bugs',
];
$I->sendAjaxRequest('PUT', '/admin/apps/pending/14', $data);
$I->seeInSession(['tips'=>['success' => false, 'message' => "请按要求填写表单"]]);

// 提交保存
$I->seeRecord('apps', ['id' => '14', 'status' => 'draft', 'deleted_at' => null]);
$I->amOnPage('/admin/apps/draft/14');
$data = [
    'cats'           => [1,2],
    'author'          => '草稿制造厂',
    'os_version'      => '3.0',
    'version_code'    => 22,
    'sort'            => 99,
    'download_manual' => '1万+',
    'summary'         => '我是即将变成审核游戏君的男人',
    'images'          => ['/pictures/6/b/6bcfd1ee3b3dbdd58dea0e046f08ee6e.jpg'],
    'changes'         => 'fixes bugs',
];
$I->sendAjaxRequest('PUT', '/admin/apps/pending/14', $data);
$I->seeRecord('apps', ['id' => '14', 'status' => 'pending', 'deleted_at' => null]);