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
<div class="breadcrumb"><a href="javascript:;">游戏管理</a><span>&gt;</span>审核不通过列表</div>
@stop

@section('content')
<div class="content">
    @if (Session::get('success'))
        <p class="alert alert-danger">{{ Session::get('success') }}</p>
    @endif
    <form class="validate jq-search">
        <!-- 查询-->
        <div class="search">
            <p>查询:
                {{ Form::select('gametype', $cats, '', ['class' => 'select']) }}
                <input class="input" type="text" name="keyword" />
            </p>
            <div class="jq-date date">日期:
                <input class="input" type="text" name="date" placeholder="2014.10.10——2014.11.11" /><div class="date-table"></div>
            </div>
            <input type="submit" class="button" value="查询" />
        </div>
        <!-- /查询 -->
    </form>
    <!-- 表格 -->
    <p class="record-title">审核不通过列表：共<b class="red">{{ $games->getTotal() }}</b>条记录</p>
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
                <th>审核时间</th>
                <th>原因</th>
                <th>操作</th>
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
                    <td><span class="elimit7em cursor" title="{{ Helper::friendlyDate($game->checked_at) }}">{{ Helper::friendlyDate($game->checked_at) }}</span></td>
                    <td><span class="elimit12em cursor" title="{{ $game->reason }}">{{ $game->reason }}</span></td>
                    <td>
                        <a href="{{ route('game.process.edit', ['notpass', $game->id]) }}" class="button">编辑</a>
                        <a href="javascript:;" class="button red-button jq-delete" data-url="{{ route('game.process.destroy', ['notpass', $game->id])}}">删除</a>
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
@stop

@section('footer')
<p class="copyright"><a class="link-gray">使用前必读</a>粤ICP证030173号</p>
@stop