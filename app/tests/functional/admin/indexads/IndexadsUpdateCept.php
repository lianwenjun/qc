<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('更新首页图片为广告');
//先登录
$data = ['username' => 'test', 'password' => 'test'];
$I->sendAjaxRequest('PUT', '/admin/users/signin', $data);

$url = '/admin/indexads/28/edit';
$data = [
        'location' => 'suggest',
        'image' => '/ads/3/e/3ee1125c624089a91a0d50695f3c17c4.jpg',
        'is_top' => 'no',
        'stocked_at' => '2014-09-29 12:00:00',
        'unstocked_at' => '2014-09-30 12:00:00',];
$I->sendAjaxPostRequest($url, $data);
//$I->seeSessionHasValues('msg');
$I->see('编辑');