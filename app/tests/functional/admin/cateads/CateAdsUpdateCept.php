<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('更新分类广告的数据');
$I->sendAjaxPostRequest('/admin/cateads/2/edit', ['image' => 'xxxxx2222222.jpg']);
$I->see('ok');

$I->sendAjaxPostRequest('/admin/cateads/111/edit', ['image' => 'xxxxx2222222.jpg']);
$I->see('valid');

$I->sendAjaxPostRequest('/admin/cateads/3/edit', ['image1' => 'xxxxx2222222.jpg']);
$I->see('error');