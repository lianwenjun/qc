<?php
/*
测试角色场景

上传游戏君: 刚上传并成功读取了APK数据的游戏

    上传游戏D君 ID 8 状态 new

草稿游戏君: 草稿

*/
$I = new FunctionalTester($scenario);
$I->wantTo('添加编辑游戏草稿功能');

$I->seeRecord('apps', ['id' => '8', 'status' => 'new', 'deleted_at' => null]);
$I->amOnPage('/admin/apps/draft/8');
$data['summary'] = '大家好，我是上传有游戏君，即将成为草稿君';
$I->sendAjaxRequest('PUT', '/admin/apps/draft/8', $data);
$I->seeRecord('apps', ['id' => '8', 'status' => 'draft', 'deleted_at' => null]);





