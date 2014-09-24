<?php

Breadcrumbs::register('apps.draft', function($breadcrumbs) {
    $breadcrumbs->push('游戏管理', route('admin.index'));
    $breadcrumbs->push('添加编辑游戏', route('apps.draft'));
});

Breadcrumbs::register('apps.edit', function($breadcrumbs) {
    $breadcrumbs->push('游戏管理', route('admin.index'));
    $breadcrumbs->push('添加编辑游戏', route('apps.draft'));
    $breadcrumbs->push('编辑', route('apps.draft'));
});