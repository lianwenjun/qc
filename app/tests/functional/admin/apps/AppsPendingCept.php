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
$I->amOnAction('Admin_AppsController@pending');
$I->see('待审游戏A君');

/* --------------------------------------------------------
| 审核功能
-------------------------------------------------------- */

// 审核通过
$I->amOnPage('/admin/apps/pending');
$data = [];
$I->sendAjaxRequest('PUT', '/admin/apps/30/dopass', $data);
$I->seeInSession(['tips'=>['success' => true, 'message' => "亲，ID：30已经审核通过"]]);
$I->seeRecord('apps', ['id' => '30', 'status' => 'onshelf', 'deleted_at' => null]);

// 审核不通过
$I->amOnPage('/admin/apps/pending');
$data = ['reason' => '测试理由'];
$I->sendAjaxRequest('PUT', '/admin/apps/31/donopass', $data);
$I->seeInSession(['tips'=>['success' => true, 'message' => "亲，ID：31已经审核不通过"]]);
$I->seeRecord('apps', ['id' => '31', 'status' => 'nopass', 'reason' => '测试理由', 'deleted_at' => null]);


/* --------------------------------------------------------
| 批量审核功能
-------------------------------------------------------- */

// 批量审核通过
$I->amOnPage('/admin/apps/pending');
$data = [
    'ids' => [34, 35],
];
$I->sendAjaxRequest('PUT', '/admin/apps/doallpass', $data);
$I->seeInSession(['tips'=>['success' => true, 'message' => "亲，全部已经审核通过"]]);
$I->seeRecord('apps', ['id' => '34', 'status' => 'onshelf', 'deleted_at' => null]);
$I->seeRecord('apps', ['id' => '35', 'status' => 'onshelf', 'deleted_at' => null]);

// 批量审核不通过
$I->amOnPage('/admin/apps/pending');
$data = [
    'ids' => [36, 37],
    'reason' => '测试理由'
    ];
$I->sendAjaxRequest('PUT', '/admin/apps/doallnopass', $data);
$I->seeInSession(['tips'=>['success' => true, 'message' => "亲，全部已经审核不通过"]]);
$I->seeRecord('apps', ['id' => '36', 'status' => 'nopass', 'reason' => '测试理由', 'deleted_at' => null]);
$I->seeRecord('apps', ['id' => '37', 'status' => 'nopass', 'reason' => '测试理由', 'deleted_at' => null]);
