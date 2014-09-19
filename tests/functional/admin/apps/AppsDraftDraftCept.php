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
$I->amOnPage('/admin/apps/8/edit');
$I->fillField(['name' => 'summary'], '上传游戏D君即将变成草稿游戏君的自白');
$I->click('存为草搞件');
$I->seeRecord('apps', ['id' => '8', 'status' => 'draft', 'deleted_at' => null]);





