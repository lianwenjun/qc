<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('游戏广告位编辑');
$I->amOnPage('/admin/appsads/create');
$fields = [
            'app_id' => 1,
            'title' => '非常无耻的APP',
            'location' => 'hotdown',
            'images' => 'xxxoooo',
            'is_top' => Input::get('is_top'),
            'onshelfed_at' => Input::get('onshelfed_at'),
            'offshelfed_at' => Input::get('offshelfed_at'),
            ];
$this->fillFormFields($fields);
$I->click('Submit');
