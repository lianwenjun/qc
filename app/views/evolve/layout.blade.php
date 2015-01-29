<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>游戏商店后台-欢迎</title>
@section('custom')

@show
</head>
<body>
    <!-- 左侧盒子 -->
    <div class="side-wrap">
        <h1 class="title">游戏商店系统</h1 >
        @if( Sentry::check() )
        <h2 class="subtitle">hi! <span>{{ Sentry::getUser()->username }}</span></h2>
        
        <p class="operate"><a href="change-pwd.html">修改密码</a><a href="../signin.html">退出系统</a></p>
        @endif
        <!-- 左侧菜单 -->
        <ul class="jq-menu nested-ul">
            @if(
                Sentry::getUser()->hasAnyAccess(
                    [
                        'apps.stock',
                        'apps.draft',
                        'apps.pending',
                        'apps.notpass',
                        'apps.unstock',
                        'cats.index',
                        'tags.index',
                        'gamecattags.index',
                        'topics.index'
                    ]
                )
            )
            <li class="nested-li">
                <h3>游戏管理</h3>
                <ul>
                    @if(Sentry::getUser()->hasAccess('apps.stock'))
                       <li><a href="{{ URL::route('apps.stock') }}">上架游戏列表</a></li>
                    @endif
                    @if(Sentry::getUser()->hasAccess('apps.draft'))
                       <li><a href="{{ URL::route('apps.draft') }}">添加编辑游戏</a></li>
                    @endif
                    @if(Sentry::getUser()->hasAccess('apps.pending'))
                       <li><a href="{{ URL::route('apps.pending') }}">待审核列表</a></li>
                    @endif
                    @if(Sentry::getUser()->hasAccess('apps.notpass'))
                       <li><a href="{{ URL::route('apps.notpass') }}">审核不通过列表</a></li>
                    @endif
                    @if(Sentry::getUser()->hasAccess('apps.unstock'))
                       <li><a href="{{ URL::route('apps.unstock') }}">下架游戏列表</a></li>
                    @endif
                </ul>
            </li>
            @endif
            <li class="nested-li">
                <h3>广告位管理</h3>
                <ul>
                    <li><a href="../ads/frontendpics.html">首页图片位管理</a></li>
                    <li><a href="../ads/frontendgame.html">首页游戏位管理</a></li>
                    <li><a href="../ads/banner.html">banner图片管理</a></li>
                    @if(Sentry::getUser()->hasAccess('tags.index')) 
                    <li><a href="{{ URL::route('topics.index', 'dptopics') }}">专题编辑管理</a></li>
                    @endif  
                    @if(Sentry::getUser()->hasAccess('tags.index')) 
                    <li><a href="{{ URL::route('topics.index', 'sutopics') }}">上架专题管理</a></li>
                    @endif 
                    <li><a href="../ads/rank.html">排行游戏位管理</a></li>
                    <li><a href="../ads/sort.html">分类页图片管理</a></li>
                    <li><a href="../ads/gift.html">礼包广告位管理</a></li>
                    <li><a href="../ads/select.html">精选必玩管理</a></li>
                    <li><a href="../ads/launch.html">启动页管理</a></li>
                </ul>
            </li>
            <li class="nested-li">
                <h3>系统管理</h3>
                <ul>
                    @if(Sentry::getUser()->hasAccess('cats.index'))
                    <li><a href="{{ URL::route('cats.index') }}">游戏分类管理</a></li>
                    @endif   
                    @if(Sentry::getUser()->hasAccess('gamecattags.index'))    
                    <li><a href="{{ URL::route('gamecattags.index') }}">分类标签管理</a></li>
                    @endif  
                    @if(Sentry::getUser()->hasAccess('tags.index'))     
                    <li><a href="{{ URL::route('tags.index') }}">标签库管理</a></li>   
                    @endif  
                    <li><a href="../system/supplier.html">供应商管理</a></li>
                    <li><a href="../system/channel.html">渠道商管理</a></li>
                    <li><a href="../system/keyword.html">关键字管理</a></li>
                    <li><a href="../system/shield-word.html">屏蔽词管理</a></li>
                    <li><a href="../system/version.html">版本管理</a></li>
                </ul>
            </li>
            <li class="nested-li">
                <h3>评论管理</h3>
                <ul>
                    <li><a href="../comment/score.html">游戏评分列表</a></li>
                    <li><a href="../comment/comment.html">游戏评论列表</a></li>
                    <li><a href="../comment/feedback.html">应用反馈</a></li>
                </ul>
            </li> 
            <li class="nested-li">
                <h3>数据中心</h3>
                <ul>
                    <li><a href="../analysis/active.html">平台活跃统计</a></li>
                    <li><a href="../analysis/download.html">游戏下载统计</a></li>
                    <li><a href="../analysis/version.html">版本分布统计</a></li>
                    <li><a href="../analysis/activation.html">平台激活统计</a></li>
                    <li><a href="../analysis/path.html">页面路径统计</a></li>
                    <li><a href="../analysis/event.html">按钮事件统计</a></li>
                    <li><a href="../analysis/visit.html">页面访问统计</a></li>
                    <li><a href="../analysis/search.html">用户搜索统计</a></li>
                    <li><a href="../analysis/realtime.html">实时充值数据</a></li>
                    <li><a href="../analysis/platform.html">平台充值统计</a></li>
                    <li><a href="../analysis/payment.html">付费率</a></li>
                    <li><a href="../analysis/signup.html">用户注册统计</a></li>
                </ul>
            </li>
            <li class="nested-li">
                <h3>用户中心</h3>
                <ul>
                    <li><a href="../user/signup.html">注册用户数据</a></li>
                    <li><a href="../user/active.html">活跃用户数据</a></li>
                    <li><a href="../user/query.html">用户查询</a></li>
                </ul>
            </li>
            <li class="nested-li">
                <h3>权限管理</h3>
                <ul>
                    <li><a href="../auth/user.html">管理员管理</a></li>
                    <li><a href="../auth/role.html">角色管理</a></li>
                </ul>
            </li>
            <li class="nested-li">
                <h3>日志管理</h3>
                <ul>
                    <li><a href="../logs/log.html">日志查询</a></li>
                </ul>
            </li>
        </ul>
        <!-- /左侧菜单 --> 
    </div>
    <!-- /左侧盒子 -->
    <!-- 右侧主体盒子 -->
    <div class="main-wrap">
        
        @section('breadcrumb')

        @show
        
        @yield('content')
        
        @section('footer')
        
        @show
    </div>
    <!-- /右侧主体盒子 -->
</body>
</html>