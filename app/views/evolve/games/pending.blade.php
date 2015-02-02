@extends('evolve.layout')

@section('custom')
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/common.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugins/owl-carousel/owl.carousel.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugins/owl-carousel/owl.theme.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugins/jquery-ui/jquery-ui.min.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/fonts.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugin.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/pages/apps.css') }}">
<script type="text/javascript" src="{{ asset('/evolve/js/admin/jquery-1.9.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery-ui/datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery-ui/datepicker.zh-CN.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/owl.carousel.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery.tmpl.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/common.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/pages/apps/phone-preview.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/pages/dialogValidate.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/pages/apps/pending.js') }}"></script>
@stop

@section('breadcrumb')
<div class="breadcrumb"><a href="javascript:;">游戏管理</a><span>&gt;</span>待审核列表</div>
@stop

@section('content')
<div class="content"> 
    <form action="#" method="post" class="validate jq-search">
        <!-- 查询-->
        <div class="search">
            <p>查询:
                <select class="select" name="gametype">
                    <option value="">全部</option>
                    <option value="">角色扮演</option>
                    <option value="">休闲益智</option>
                    <option value="">射击游戏</option>
                    <option value="">冒险游戏</option>
                    <option value="">动作游戏</option>
                    <option value="">策略游戏</option>
                    <option value="">实时策略</option>
                    <option value="">格斗游戏</option>
                    <option value="">竞速游戏</option>
                    <option value="">体育游戏</option>
                    <option value="">单机游戏</option>
                    <option value="">棋牌游戏</option>
                </select>
                <input class="input" type="text" name="keyword" />
            </p>
            <div class="jq-date date">日期:
                <input class="input" type="text" name="date" placeholder="2014.10.10——2014.11.11" /><div class="date-table"></div>
            </div>
            <input type="button" class="button" value="查询" />
        </div>
        <!-- /查询 -->
    </form>
    <!-- 表格 -->
    <p class="record-title">待审核列表：共<b class="red">{{ $games->getTotal() }}</b>条记录</p>
    <table cellpadding="0" cellspacing="0" class="zebra-table tc">
        <thead>
            <tr>
                <th>ID</th>
                <th>图标</th>
                <th>名称<i class="icon-download ml5"></i></th>
                <th>作者</th>
                <th>供应商</th>
                <th>包名</th>
                <th>分类</th>
                <th>大小</th>
                <th>版本号</th>
                <th>预览</th>
                <th>上传人</th>
                <th>编辑人</th>
                <th>上架时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse($games as $game)
                <tr>
                    <td>{{ $game->id }}</td>
                    <td><img src="../images/pages/icon2.jpg" alt="图标1" class="icon25" /></td>
                    <td><a href="javascript:;" class="link-blue elimit6em jq-download" title="会说话的汤姆猫" data-url="">会说话的汤姆猫</a></td>
                    <td>巨象互动</td>
                    <td>UC九游</td>
                    <td><span class="elimit12em cursor" title="1234567890adcvbnmawertgyu0000000">1234567890adcvbnmawertgyu0000000</span></td>
                    <td><span class="elimit6em cursor" title="策略游戏,休闲游戏">策略游戏,休闲游戏</span></td>
                    <td>180.5M</td>
                    <td>4.4.3</td>
                    <td class="link-blue jq-preview">预览</td>
                    <td>吸毒欧阳顺</td>
                    <td>吸毒欧阳顺</td>
                    <td><span class="elimit7em cursor" title="2014-09-03 19:09">2014-09-03 19:09</span></td>
                    <td>
                        <a href="javascript:;" class="button jq-pass" data-url="">通过</a>
                        <a href="javascript:;" class="button jq-notpass" data-url="">不通过</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="13">没找到数据</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <!-- /表格 -->
    <!-- 上下翻页 -->
    {{ $games->appends(Input::all())->links('evolve.page') }}
    <!-- /上下翻页 -->
</div>
<!-- 手机预览弹窗内容 -->
<div class="phone-wrap jq-previewModal">
    <h1 class="phone-title"><i class="icon-arrow-left2 fl"></i><span class="jq-ptitle"></span><i class="icon-search fr"></i></h1>
    <div class="phone-content">
        <h2 class="phone-subtitle">
            <span class="current">游戏详情</span>
            <span>游戏评论</span>
            <span>游戏社区</span>
        </h2>
        <div class="phone-infos">
            <img class="icon50 jq-picon" src="" alt="图标" />
            <ul class="jq-pinfo">
                <li class="jq-ptitle"></li>
                <li class="star">
                    <i class="star-score jq-pscore"></i>
                </li>
                <li class="small"><span class="jq-pcat"></span><span class="jq-psize"></span></li>
                <li class="small"><span class="jq-pversion"></span><span class="jq-pdate"></span></li>
            </ul>
        </div>
        <div class="list"><p class="lh150 jq-pcomment"></p></div>
        <div class="list">
            <ul class="text jq-pgifts">
            </ul>
        </div>
        <h3>游戏截图</h3>
        <div class="list">
            <ul class="owl-carousel owl-theme carousel jq-carousel">
                <li><img src="" alt="游戏截图" /></li>
                <li><img src="" alt="游戏截图" /></li>
                <li><img src="" alt="游戏截图" /></li>
                <li><img src="" alt="游戏截图" /></li>
                <li><img src="" alt="游戏截图" /></li>
            </ul>
        </div>
        <h3>游戏相关</h3>
        <div class="list">
            <ul class="division-wrap2 division"> 
                <li class="blue2-bg"><i class="icon-tags mr5"></i>攻略</li>
                <li class="red2-bg"><i class="icon-tools mr5"></i>资讯</li>
            </ul>
        </div>
        <h3>同作者游戏</h3>
        <div class="list">
            <ul class="division-wrap4 division jq-psameAuthor">
            </ul>
        </div>
        <h3>同类游戏</h3>
        <div class="list">
            <ul class="division-wrap4 division jq-psameCat">
            </ul>
        </div>
        <h3>本周热门标签</h3>
        <div class="phone-tags">
            <span>汤姆猫</span><span>糖果大屠杀</span><span>航海大时代礼包</span><span>神魔</span>
            <span>象棋</span><span>进击的部落礼包</span><span>三剑豪</span><span>天天爱消除</span>
        </div>
    </div>
    <span class="phone-exit jq-exit">退出预览</span>
</div>
<!-- /手机预览弹窗内容 -->
<!-- 不通过弹窗 -->   
<div class="jq-notpassModal none" title="不通过原因">
    <p class="mb20"><label><input type="radio" name="reason" value="恶意软件" checked="checked" style="outline: none" />恶意软件</label></p>
    <p class="mb20"><label><input type="radio" name="reason" value="游戏信息错误" />游戏信息错误</label></p>
    <p>
        <label class="mr5"><input type="radio" name="reason" value="" class="jq-other" />其他</label>
        <input class="input w250 jq-insertReason" type="text" value="" placeholder="请输入原因......" />
    </p>
    <form action="" method="post" class="jq-notpassForm validate validate-em">
        <input class="jq-reason" type="hidden" value="" name="notpass-reason" />
    </form>
</div>   
<!-- /不通过弹窗 -->
@stop

@section('footer')
<p class="copyright"><a class="link-gray">使用前必读</a>粤ICP证030173号</p>
@stop