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
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/owl.carousel.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/common.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/pages/apps/stock.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/pages/phone-preview.js') }}"></script>
@stop

@section('breadcrumb')
<div class="breadcrumb"><a href="javascript:;">游戏管理</a><span>&gt;</span>历史版本</div>
@stop

@section('content')
<div class="content"> 
    <form class="validate jq-search">  
        <!-- 查询-->
        <div class="search">
            <p>查询:
                <select class="select" name="gametype">
                    <option value="">游戏分类 </option>
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
            <div class="jq-date date">日期:
                <input class="input" type="text" name="date[]" placeholder="2014.10.10—2014.11.11" /><div class="date-table"></div>   
            </div> 
            <input class="button" type="submit" value="查询" />                                      
        </div>
        <!-- /查询 -->
    </form>
    <!-- 表格 -->
    <p class="record-title">历史版本：共<b class="red">{{ $games->getTotal() }}</b>条记录</p>
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
                <th>更新时间</th>
                <th>操作人</th>
                <th><a href="{{ route('game.stocks') }}" class="button gray-button">返回</a></th>
            </tr>
        </thead>
        <tbody>
            @forelse($games as $game)
                <tr>
                    <td>{{ $games->id }}</td>
                    <td><img src="{{ $game->icon }}" alt="图标1" class="icon25" /></td>
                    <td><a href="javascript:;" class="link-blue elimit6em jq-download" title="{{ $game->title }}" data-url="{{ $game->download_link }}">{{ $game->title }}</a></td>
                    <td>{{ $game->author }}</td>
                    <td>{{ $game->vendor }}</td>
                    <td><span class="elimit12em cursor" title="{{ $game->package }}">{{ $game->package }}</span></td>
                    <td><span class="elimit6em cursor" title="{{ $game->cats }}">{{ $game->cats }}</span></td>
                    <td>{{ Helper::friendlySize($game->size) }}</td>
                    <td>{{ $game->version }}</td>
                    <td class="link-blue jq-preview" data-url="">预览</td>
                    <td><span class="elimit7em cursor" title="{{ $game->update_at }}">{{ $game->update_at }}</span></td>
                    <td>{{ $game->operator }}</td>
                    <td></td>
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
@stop

@section('footer')
<p class="copyright"><a class="link-gray">使用前必读</a>粤ICP证030173号</p>
@stop