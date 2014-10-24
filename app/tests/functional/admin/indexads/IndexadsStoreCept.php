<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('添加首页游戏位广告');
$url = '/admin/indexads/create';
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

$data = ['app_id' => '4',
        'title' => '可怜软件A君',
        'location' => 'suggest',
        'image' => '/ads/3/e/3ee1125c624089a91a0d50695f3c17c4.jpg',
        'is_top' => 'yes',
        'stocked_at' => '2014-09-29 12:00:00',
        'unstocked_at' => '2014-09-30 12:00:00',];
$I->sendAjaxPostRequest($url, $data);
$I->seeSessionHasValues(['msg' => '添加成功']);