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
<script type="text/javascript" src="{{ asset('/evolve//js/admin/plugins/owl.carousel.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery.tmpl.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/common.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/pages/apps/stock.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/pages/apps/phone-preview.js') }}"></script>
@stop

@section('breadcrumb')
<div class="breadcrumb"><a href="javascript:;">游戏管理</a><span>&gt;</span>上架游戏列表</div>
@stop

@section('content')
<div class="content"> 
    <form class="validate jq-search">  
        <!-- 查询-->
        <div class="search">
            <p>查询:
                <select class="select" name="gametype">
                    <option value="">游戏分类</option>
                    <option value="">格斗游戏</option>
                    <option value="">动作游戏</option>
                    <option value="">策略卡牌</option>
                    <option value="">体育竞技</option>
                </select>
                <select class="select" name="gamename">
                    <option value="">游戏名称</option>
                    <option value="">游戏包名</option>
                    <option value="">版本号</option>
                </select>
                <input class="input" type="text" name="keyword" />
            </p>
            <p>ID:
                <input class="input w60" type="text" name="id" /></p>
            <p>标签:
                <input class="input" type="text" name="tag" /></p>              
            <p>大小:
                <input class="input w60 jq-sizeStart" type="text" placeholder="0K" name="size[]" />—<input class="input w60 jq-sizeEnd" type="text" placeholder="10M" name="size[]" />
            </p>  
            <div class="jq-date date ">日期:
                <input class="input" type="text" name="date[]" placeholder="2014.10.10—2014.11.11" /><div class="date-table"></div>   
            </div> 
            <input class="button " type="submit" value="查询" />                                      
        </div>
        <!-- /查询 -->
    </form>
    <!-- 表格 -->
    <p class="record-title">上架游戏：共<b class="red">{{ $games->getTotal() }}</b>条记录</p>
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
                <th class="jq-sort pointer" data-asc-url="" data-desc-url="" data-sort="">大小<i class="icon-menu2 icon-arrow-down icon-arrow-up"></i></th>
                <th>版本号</th>
                <th>预览</th>
                <th class="jq-sort pointer" data-asc-url="" data-desc-url="" data-sort="">下载量<i class="icon-menu2 icon-arrow-down icon-arrow-up"></i></th>
                <th class="jq-sort pointer" data-asc-url="" data-desc-url="" data-sort="">上架时间<i class="icon-menu2 icon-arrow-down icon-arrow-up"></i></th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse($games as $game)
                <tr>
                    <td>{{ $game->id }}</td>
                    <td><img src="{{ $game->icon }}" alt="图标1" class="icon25" /></td>
                    <td><a href="javascript:;" class="link-blue elimit6em jq-download" title="{{ $game->title }}" data-url="{{ $game->download_link }}">{{ $game->title }}</a></td>
                    <td>{{ $game->author }}</td>
                    <td>{{ $game->vendor }}</td>
                    <td><span class="elimit12em cursor" title="{{ $game->package }}">{{ $game->package }}</span></td>
                    <td><span class="elimit6em cursor" title="{{ $game->cat }}">{{ $game->cat }}</span></td>
                    <td>{{ Helper::friendlySize($game->size) }}</td>
                    <td>{{ $game->version }}</td>
                    <td class="link-blue jq-preview">预览</td>
                    <td>9999</td>
                    <td><span class="elimit7em cursor" title="{{ Helper::friendlyDate($game->unstocked_at) }}">{{ Helper::friendlyDate($game->unstocked_at) }}</span></td>
                    <td>
                        <!--
                            <a href="gift.html" class="button">礼包</a>
                        -->
                        <a href="javascript:;" class="button jq-unstock" data-url="">下架</a>
                        <a href="edit.html" class="button">更新</a>
                        <a href="history.html" class="button">历史版本</a>
                    </td>               
                </tr>
            @empty
                <tr>没找到数据</tr>
            @endforelse
        </tbody>
    </table>
    <!-- /表格 -->
    <!-- 上下翻页 -->
    <ul class="pagination">
        {{ $games->appends(Input::all())->links('evolve.page') }}
    </ul> 
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
@stop

@section('footer')
<p class="copyright"><a class="link-gray">使用前必读</a>粤ICP证030173号</p>
@stop