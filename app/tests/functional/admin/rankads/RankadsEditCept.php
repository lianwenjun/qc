<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('游戏排行广告位修改');
$I->amOnPage('/admin/rankads/17/edit');
$I->see('最新');
$I->click('返回列表');
$url = '/admin/rankads/17/edit';
$data = [
        'location' => 'hot',
        'sort' => '1',
        'onshelfed_at' => '2014-09-29 12:00:00',
        'offshelfed_at' => '2014-09-30 12:00:00'];
$I = new FunctionalTester($scenario);
$I->sendAjaxPostRequest($url, $data);
$I->seeSessionHasValues(['msg' => '修改成功']);
