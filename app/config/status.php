<?php
    return [
        // 游戏app
        'apps' => [
            //审核+上下架状态
            'status' => [
                'new' => '新上传',
                'draft' => '草稿',
                'pending' => '待审核',
                'nopass' => '审核不通过',
                'onshelf' => '上架', 
                'offshelf' => '下架',
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
                'expired' => '已过期',
                'noexpire' => '线上展示',
                'onshelf' => '上架',
                'offshelf' => '已下架',
            ],
            //状态颜色
            'statusColor' => [
                'expired' => 'class="Red"',
                'noexpire' => 'class="Green"',
                'onshelf' => '',
                'offshelf' => '',
            ],
            //时间颜色
            'timeColor' => [
                'expired' => 'class="Red"',
                'noexpire' => '',
                'onshelf' => '',
                'offshelf' => '',
            ],
            //是否上架
            'is_onshelf' => [
                'yes' => '上架', 'no' => '下架',
            ],
            //是否过期
            'is_expire' => [
                'yes' => '已过期', 'no' => '线上显示',
            ],
            //是否置顶
            'is_top' => [
                'yes' => '是', 'no' => '否',
            ],
            //排行广告区域
            'ranklocation' => [
                'new' => '最新',
                'hot' => '最热',
                'up' => '飙升',
            ],
            //首页，图片，编辑广告区域
            'location' => [
                'search' => '搜索页推广',
                'new' => '新品抢玩',
                'hotdown' => '热门下载',
                'suggest' => '精品推荐',
            ],
            //首页，图片，编辑广告区域
            'applocation' => [
                'search' => '搜索页推广',
                'new' => '新品抢玩',
                'hotdown' => '热门下载',
                'suggest' => '精品推荐',
            ],
        ],
        //关键词
        'keywords' => [
            //是否轮播
            'is_slide' => [
                'yes' => '是', 'no'=>'否',
            ],
        ],
    ];
?>
