<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('首页游戏广告位编辑');
$I->amOnPage('/admin/appsads/4/edit');
$fields = [
            'location' => 'hotdown',
            'images' => 'xxxoooo',
            'is_top' => 'yes',
            'restocked_at' => '',
            'unstocked_at' => '',
            ];
$I->sendAjaxPostRequest('/admin/appsads/4/edit', $fields);
$I->seeSessionHasValues(['msg' => '修改成功']);