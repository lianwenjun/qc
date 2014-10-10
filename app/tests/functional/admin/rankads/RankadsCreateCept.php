<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('游戏排行广告位添加');
$I->amOnPage('/admin/rankads/create');
$I->see('最新');
$I->click('返回列表');
$url = '/admin/rankads/create';
$data = ['app_id' => '4',
        'title' => '可怜软件A君',
        'location' => 'hot',
        'sort' => '1',
        'onshelfed_at' => '2014-09-29 12:00:00',
        'offshelfed_at' => '2014-09-30 12:00:00'];
$I = new FunctionalTester($scenario);
$I->sendAjaxPostRequest($url, $data);
$I->see('添加成功');