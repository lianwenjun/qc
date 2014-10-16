<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('删除编辑精选广告');
//存在测试
$I->sendAjaxRequest('DELETE' ,'/admin/editorads/25/delete');
$I->seeSessionHasValues(['msg' => '#25删除成功']);

//不存在测试
$I->sendAjaxRequest('DELETE' ,'/admin/editorads/20/delete');
$I->seeSessionHasValues(['msg' => '#20不存在']);

//保存失败测试

