<?php
    return [
        // 游戏app
        'apps' => [
            //审核+上下架状态
            'status' => [
                'publish' => '新上传',
                'draft' => '草稿',
                'pending' => '待审核',
                'notpass' => '审核不通过',
                'stock' => '上架', 
                'unstock' => '下架',
            ],
            //是否有广告
            'has_ads' => [
                'yes' => '有', 'no' => '无',
            ],
            
            //是否安全认证
            'is_verify' => [
                'yes' => '是', 'no' => '否',
            ],
            // 系统
            'os' => [
                'Android',
            ],
        ],
        // 广告
        'ads' => [
            //状态名称
            'status' =>[
                '' => '状态',
                // 'expired' => '已过期',
                // 'online' => '线上展示',
                'stock' => '线上展示',
                'unstock' => '已下架',
            ],
            //首页图片，编辑广告区域
            'bannerLocation' => [
                '' => '所属类别',
                'banner_slide' => '轮播广告图',
                'banner_new' => '新品抢玩',
                'banner_hot' => '热门下载'
            ],
            //排行广告区域
            'rankLocation' => [
                '' => '所属类别',
                'rank_new' => '最新',
                'rank_hot' => '最热',
                'rank_rise' => '飙升'
            ],
            //首页，图片，编辑广告区域
            'appLocation' => [
                '' => '所属类别',
                'app_new' => '新品抢玩',
                'app_hot' => '热门下载',
                'app_rise' => '飙升'
            ],
            // 编辑专题广告状态 
            'editTopicsStatus' => [
                '' => '状态',
                'pending' => '待发布',
                'draft' => '编辑中'
            ],
            // 上架专题广告状态 
            'stockTopicsStatus' => [
                '' => '状态',
                'stock' => '线上展示',
                'unstock' => '下架'
            ],
            // 专题广告展示区域
            'topicsLocation' => [
                '' => '展示区域',
                'defaultlist' => '默认列表',
                'slide' => '首页轮播'
            ]
        ],
        //关键词
        'keywords' => [
            //是否轮播
            'is_slide' => [
                'yes' => '是', 'no'=>'否',
            ],
        ],

        // 渠道号
        'release' => [
            '' => '请选择',
            '0' => '游戏中心',
            '1' => '天天',
            '2' => '应用宝',
        ],


    ];
?>
