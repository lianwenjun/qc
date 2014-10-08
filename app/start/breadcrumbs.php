<?php

Breadcrumbs::register('apps.onshelf', function($breadcrumbs) {
    $breadcrumbs->push('游戏管理', route('admin.index'));
    $breadcrumbs->push('上架游戏列表', route('apps.onshelf'));
});

Breadcrumbs::register('apps.draft', function($breadcrumbs) {
    $breadcrumbs->push('游戏管理', route('admin.index'));
    $breadcrumbs->push('添加编辑游戏', route('apps.draft'));
});

Breadcrumbs::register('apps.pending', function($breadcrumbs) {
    $breadcrumbs->push('游戏管理', route('admin.index'));
    $breadcrumbs->push('待审核列表', route('apps.pending'));
});

Breadcrumbs::register('apps.nopass', function($breadcrumbs) {
    $breadcrumbs->push('游戏管理', route('admin.index'));
    $breadcrumbs->push('审核不通过列表', route('apps.nopass'));
});

Breadcrumbs::register('apps.offshelf', function($breadcrumbs) {
    $breadcrumbs->push('游戏管理', route('admin.index'));
    $breadcrumbs->push('下架游戏列表', route('apps.offshelf'));
});

Breadcrumbs::register('apps.edit', function($breadcrumbs) {
    $breadcrumbs->push('游戏管理', route('admin.index'));
    $breadcrumbs->push('添加编辑游戏', route('apps.draft'));
    $breadcrumbs->push('编辑', route('apps.draft'));
});