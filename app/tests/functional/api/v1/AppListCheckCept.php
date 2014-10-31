<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('检查本地已安装的APP是否已经更新');
$data = [
    'apps' => [
            ['pack' => '', 'versionCode' => ''],
            ['pack' => '', 'versionCode' => ''],
            ['pack' => '', 'versionCode' => ''],
            ['pack' => '', 'versionCode' => ''],
    ]
];
$I->sendAjaxPostRequest('/v1/client/apps/list', $data);
$I->see('"msg":1');
