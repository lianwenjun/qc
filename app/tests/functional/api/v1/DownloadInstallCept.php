<?php
$I = new FunctionalTester($scenario);
$I->wantTo('下载游戏安装');
$appid = '100';
$data = [
    'appid' => $appid,
    'imei' => '44a0dfuasdfasdfasdf',
    'ip' => '192.168.10.2',
    'uuid' => '123197917203edfcfdadefdfdda',
    'device' => 'sumsung',
    'version' => '4.2',
];
$URL = '/v1/api/game/info/edit/download/installed';
$I->sendAjaxGetRequest($URL, $data);
$I->see('"msg":1');
