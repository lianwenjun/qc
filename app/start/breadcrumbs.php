<?php

Breadcrumbs::register('apps.stock', function($breadcrumbs) {
    $breadcrumbs->push('游戏管理', 'javascript:;');
    $breadcrumbs->push('上架游戏列表', route('apps.stock'));
});

Breadcrumbs::register('apps.draft', function($breadcrumbs) {
    $breadcrumbs->push('游戏管理', 'javascript:;');
    $breadcrumbs->push('添加编辑游戏', route('apps.draft'));
});

Breadcrumbs::register('apps.pending', function($breadcrumbs) {
    $breadcrumbs->push('游戏管理', 'javascript:;');
    $breadcrumbs->push('待审核列表', route('apps.pending'));
});

Breadcrumbs::register('apps.notpass', function($breadcrumbs) {
    $breadcrumbs->push('游戏管理', 'javascript:;');
    $breadcrumbs->push('审核不通过列表', route('apps.notpass'));
});

Breadcrumbs::register('apps.unstock', function($breadcrumbs) {
    $breadcrumbs->push('游戏管理', 'javascript:;');
    $breadcrumbs->push('下架游戏列表', route('apps.unstock'));
});

Breadcrumbs::register('apps.edit', function($breadcrumbs) {
    $breadcrumbs->push('游戏管理', 'javascript:;');
    $breadcrumbs->push('编辑', route('apps.draft'));
});

Breadcrumbs::register('apps.history', function($breadcrumbs) {
    $breadcrumbs->push('游戏管理', 'javascript:;');
    $breadcrumbs->push('上架游戏列表', route('apps.stock'));
    $breadcrumbs->push('历史', 'javascript:;');
});