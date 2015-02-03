@extends('evolve.layout')

@section('custom')
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/common.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugins/jquery-ui/jquery-ui.min.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/fonts.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugin.css') }}">
<script type="text/javascript" src="{{ asset('/evolve/js/admin/jquery-1.9.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery-ui/datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery-ui/datepicker.zh-CN.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery-ui/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/common.js') }}"></script>
@stop

@section('breadcrumb')
<div class="breadcrumb"><a href="javascript:;">游戏管理</a><span>&gt;</span>下架游戏列表</div>
@stop

@section('content')
<div class="content"> 
    <form class="validate jq-search">  
        <!-- 查询-->
        <div class="search">
            <p>查询:
                {{ Form::select('gametype', $cats, '', ['class' => 'select']) }}
                <input class="input" type="text" name="keyword" />
            </p>
            <div class="jq-date date">日期:
                <input class="input" type="text" name="date[]" placeholder="2014.10.10—2014.11.11" /><div class="date-table"></div>   
            </div> 
            <input class="button" type="submit" value="查询" />                                      
        </div>
        <!-- /查询 -->
    </form>
    <!-- 表格 -->
    <p class="record-title">下架游戏列表：共<b class="red">{{ $games->getTotal() }}</b>条记录</p>
    <table cellpadding="0" cellspacing="0" class="zebra-table tc">
        <thead>
            <tr>
                <th>ID</th>
                <th>图标</th>
                <th>名称<i class="icon-download ml5"></i></th>
                <th>包名</th>
                <th>分类</th>
                <th>大小</th>
                <th>版本号</th>
                <th>下载量</th>
                <th>上架时间</th>
                <th>下架时间</th>
                <th>操作人</th>
            </tr>
        </thead>
        <tbody>
            @forelse($games as $game)
                <tr>
                    <td>{{ $game->id }}</td>
                    <td><img src="{{ $game->icon }}" alt="图标1" class="icon25" /></td>
                    <td><a href="javascript:;" class="link-blue elimit6em jq-download" title="{{ $game->title }}" data-url="{{ $game->download_link }}">{{ $game->title }}</a></td>
                    <td><span class="elimit12em cursor" title="{{ $game->package }}">{{ $game->package }}</span></td>
                    <td><span class="elimit6em cursor" title="{{ $game->cats }}">{{ $game->cats }}</span></td>
                    <td>{{ Helper::friendlySize($game->size) }}</td>
                    <td>{{ $game->version }}</td>
                    <td>{{ $game->download_total }}</td>
                    <td><span class="elimit7em cursor" title="{{ Helper::friendlyDate($game->stocked_at) }}">{{ Helper::friendlyDate($game->stocked_at) }}</span></td>
                    <td><span class="elimit7em cursor" title="{{ Helper::friendlyDate($game->unstocked_at) }}">{{ Helper::friendlyDate($game->unstocked_at) }}</span></td>
                    <td>{{ $game->operator }}</td>
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