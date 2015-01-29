@extends('evolve.layout')
@section('custom')
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/common.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/fonts.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugins/jquery-ui/jquery-ui.min.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugin.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/pages/system.css') }}">
<script type="text/javascript" src="{{ asset('/evolve/js/admin/jquery-1.9.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery.tmpl.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/common.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/pages/system/system.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/pages/dialogValidate.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/pages/system/game-sort.js') }}"></script>
@stop

@section('content')
    <div class="breadcrumb">
        <a href="javascript:;">系统管理</a><span>&gt;</span><a href="game-sort.html">游戏分类管理</a><span>&gt;</span>添加分类
    </div>  
    <div class="content"> 
        <!-- 表格 -->
        <p class="record-title">添加分类：</p>
        <table cellpadding="0" cellspacing="0" class="edit-zebra-table">
            <tbody>
                <tr>
                    <td class="label">分类名称：</td>
                    <td>
                        <input type="text" placeholder="例：棋牌游戏" class="input" name="title" value="{{ $cat->title }}"/>
                    </td>
                </tr>
                <tr>
                    <td class="label">标签展示：</td>
                    <td>
                        <ul class="tags fl">
                            @if($cat->tags)
                            @forelse($cat->tags as $tag)
                            <li>
                               <p class="gametag">{{ $tag->title }}<span class="jq-delete">×</span></p> 
                            </li>
                            @empty

                            @endforelse
                            @endif
                            <li>
                                <input type="text" placeholder="标签输入时自动匹配" class="input jq-tags" />
                                <span class="input-delete jq-del">×</span>
                            </li>
                        </ul>
                        <input class="button jq-add" type="button" value="+">
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="inline-button">
            <input type="submit" value="  确  定  " class="button" />
            <a href="{{ URL::route('cats.index') }}" class="button">返回列表</a>
        </p>
        <!-- /表格 -->
    </div>
    <p class="copyright"><a class="link-gray">使用前必读</a><span>粤ICP证030173号</span></p>
@stop