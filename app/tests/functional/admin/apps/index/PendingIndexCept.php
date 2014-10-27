<?php
/*
测试角色场景

待审游戏君: 待审核的游戏

*/

$I = new FunctionalTester($scenario);
$I->wantTo('待审核游戏列表功能');

// 登陆
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

// 列表
$I->amOnAction('Admin_Apps_IndexController@pending');
$I->see('待审游戏A君');

/* --------------------------------------------------------
| 审核功能
-------------------------------------------------------- */

// 批量审核通过
$I->amOnPage('/admin/apps/pending');
$data = [
    'ids' => [34, 35],
];
$I->sendAjaxRequest('PUT', '/admin/apps/putStock', $data);
$I->seeInSession(['tips'=>['success' => true, 'message' => "亲，全部已经审核通过"]]);
$I->seeRecord('apps', ['id' => '34', 'status' => 'stock', 'deleted_at' => null]);
$I->seeRecord('apps', ['id' => '35', 'status' => 'stock', 'deleted_at' => null]);

// 批量审核不通过
$I->amOnPage('/admin/apps/pending');
$data = [
    'ids' => [36, 37],
    'reason' => '测试理由'
    ];
$I->sendAjaxRequest('PUT', '/admin/apps/putNotpass', $data);
$I->seeInSession(['tips'=>['success' => true, 'message' => "亲，全部已经审核不通过"]]);
$I->seeRecord('apps', ['id' => '36', 'status' => 'notpass', 'reason' => '测试理由', 'deleted_at' => null]);
$I->seeRecord('apps', ['id' => '37', 'status' => 'notpass', 'reason' => '测试理由', 'deleted_at' => null]);
