<?php 
/*
测试角色场景

草稿游戏君: 刚上传并成功读取了APK数据的游戏

    草稿游戏A君 ID 9 状态 draft 

待审游戏君: 待审游戏君

*/
$I = new FunctionalTester($scenario);
$I->wantTo('添加编辑游戏编辑功能');
$I->seeRecord('apps', ['id' => '9', 'status' => 'new', 'deleted_at' => null]);
$I->amOnPage('/admin/apps/9/edit');
$I->fillField(['name' => 'keywords'], '草稿游戏A君');
$I->checkOption(['name' => 'cates'], '角色扮演'); // 用法未确定
$I->fillField(['name' => 'author'], '草稿游戏有限公司');
$I->selectOption('form select[name=os]', 'Android');
$I->fillField(['name' => 'os_version'], '2.3');
$I->fillField(['name' => 'sort'], '0');
$I->fillField(['name' => 'summary'], '草稿游戏A君即将变成待审游戏君的自白');
// 图片咋整
$I->fillField(['name' => 'changes'], '主要是草稿游戏君去到了待审游戏君的星球');
$I->click('编辑');
$I->seeRecord('apps', ['id' => '9', 'status' => 'pending', 'deleted_at' => null]);


// 必填验证