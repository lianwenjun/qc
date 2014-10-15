<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('删除屏蔽词管理');
//存在测试
$I->sendAjaxRequest('DELETE', '/admin/stopword/1/delete');
$I->seeSessionHasValues(['msg' => '#1删除成功']);

//不存在测试
$I->sendAjaxRequest('DELETE', '/admin/stopword/12/delete');
$I->seeSessionHasValues(['msg' => '#12不存在']);

