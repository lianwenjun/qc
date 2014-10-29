<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('反馈提交');
//正常测试
$data = [
    'AppVersion' => '123456',
    'Content' => '44a0dfuasdfasdfasdf',
    'UserEmail' => 'lanchangqing@ltbl.cn',
    'IMEI' => '123197917203edfcfdadefdfdda',
    'Device' => 'sumsung',
    'SystemVersion' => '4.2',
];
$URL = '/v1/game/feedback/add';
$I->sendAjaxPostRequest($URL, $data);
$I->see('"msg":1');
//错误测试
$data = [
    'AppVersion' => '123456',
    'Content' => '44a0dfuasdfasdfasdf',
    'UserEmail' => '',
    'IMEI' => '123197917203edfcfdadefdfdda',
    'Device' => 'sumsung',
    'SystemVersion' => '4.2',
];
$URL = '/v1/game/feedback/add';
$I->sendAjaxPostRequest($URL, $data);
$I->see('"msg":0');