<?php
/**
 * 日志管理 & 组定义
 *
 */

return [
    '游戏管理' => [
        '上架游戏列表' => [
            '下架' => 'put_apps.putUnstock',
            '更新' => 'put_stock_apps.stock.edit',
        ],
        '添加编辑游戏' => [
            '删除' => 'delete_apps.delete',
            '编辑并保存为草稿' => 'put_apps.draft.edit',
            '编辑并提交到待审核' => 'publish_put_apps.pending.edit',
            'APK上传' => 'post_apps.appupload',
            '图片上传' => 'post_apps.imageupload',
        ],
        '待审核列表' => [
            '审核通过' => 'put_apps.putStock',
            '审核不通过' => 'put_apps.putNotpass',
        ],
        '审核不通过列表' => [
            '编辑并提交到待审核' => 'notpass_put_apps.pending.edit',
        ],
        '下架游戏列表' => [
            '编辑并提交到待审核' => 'unstock_put_apps.pending.edit',
        ],
    ],
    '广告位管理' => [
        '首页游戏位管理' => [
            '新增' => 'post_appsads.create',
            '下架' => 'get_appsads.unstock',
            '编辑' => 'post_appsads.edit',
            '删除' => 'delete_appsads.delete',
            '上传' => 'post_appsads.upload',
        ],
        '排行游戏位管理' => [
            '新增' => 'post_rankads.create',
            '下架' => 'get_rankads.unstock',
            '编辑' => 'post_rankads.edit',
            '删除' => 'delete_rankads.delete',
        ],
        '首页图片位管理' => [
            '新增' => 'post_indexads.create',
            '下架' => 'unstock_indexads.unstock',
            '编辑' => 'post_indexads.edit',
            '删除' => 'delete_indexads.delete',
        ],
        '编辑精选管理' => [
            '新增' => 'post_editorads.create',
            '下架' => 'get_editorads.unstock',
            '编辑' => 'post_editorads.edit',
            '删除' => 'delete_editorads.delete',
        ],
        '分类页图片位推广' => [
            '上传' => 'post_catads.upload',
            '编辑' => 'post_catads.edit',
        ],
    ],
    '系统管理' => [
        '游戏分类管理' => [
            '新增' => 'post_cat.create',
            '编辑' => 'post_cat.edit',
            '删除' => 'get_cat.delete',
        ],
        '游戏标签管理' => [
            '新增' => 'post_tag.create',
            '编辑' => 'post_tag.edit',
            '删除' => 'delete_tag.delete',
        ],
        '关键字管理' => [
            '新增' => 'post_keyword.store',
            '编辑' => 'post_keyword.update',
            '删除' => 'delete_keyword.delete',
        ],
        '屏蔽词管理' => [
            '新增' => 'post_stopword.create',
            '编辑' => 'post_stopword.edit',
            '删除' => 'delete_stopword.delete',
        ],
    ],
    '评论管理' => [
        '游戏评分列表' => [
            '编辑' => 'post_rating.edit',
        ],
        '游戏评论列表' => [
            '编辑' => 'post_comment.edit',
            '删除' => 'delete_comment.delete',
        ],
    ],
    '权限管理' => [
        '管理员管理' => [
            '新增' => 'post_users.create',
            '编辑' => 'put_users.edit',
            '删除' => 'delete_users.delete',
        ],
        '角色管理' => [
            '新增' => 'post_roles.create',
            '编辑' => 'put_roles.edit',
            '删除' => 'delete_roles.delete',
        ],
    ],
];