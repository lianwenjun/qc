<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('删除游戏评论');
//存在测试
$I->sendAjaxRequest('DELETE', '/admin/comment/1/delete');
$I->seeSessionHasValues(['msg' => '#1删除成功']);

//不存在测试
$I->sendAjaxRequest('DELETE', '/admin/comment/120/delete');
$I->seeSessionHasValues(['msg' => '#120不存在']);

$I->sendAjaxRequest('DELETE', '/admin/comment/0/delete');
$I->seeSessionHasValues(['msg' => '#0不存在']);
