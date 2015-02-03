@extends('evolve.layout')
@section('custom')
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/common.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugins/jquery-ui/jquery-ui.min.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugin.css') }}">
<script type="text/javascript" src="{{ asset('/evolve/js/admin/jquery-1.9.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery-ui/datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery-ui/datepicker.zh-CN.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/common.js') }}"></script>
@stop
@section('content')
	<div class="breadcrumb">
    	<a href="javascript:;">广告位管理</a><span>&gt;</span><a href="draft.html">专题编辑管理</a><span>&gt;</span>查看
    </div>  
    <div class="content"> 
        <!-- 表单 -->
        <form name="form" action="" method="get">
            <p class="record-title">应用信息：</p>
            <table cellpadding="0" cellspacing="0" class="edit-zebra-table">
                <tbody>
                    <tr>
                        <td class="label">专题名称：</td>
                        <td>{{ $topic->title }}</td>
                    </tr>
                    <tr>
                        <td class="label">小编点评：</td>
                        <td>
                            <p class="text t2">{{ $topic->summary }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">上传图片：</td>
                        <td>
                            <img src="{{ $topic->image }}" class="icon230x120" />
                        </td>
                    </tr>
                    <tr>
                        <td class="label">添加游戏内容：</td>
                        <td>
                            <ul class="game-content fl">
                            	@forelse($apps as $app)
                                <li>
                                    <img src="{{ $app->icon }}" class="icon25" />
                                    <p class="gametag">{{ $app->title }}</p>
                                </li>
                                @empty
                                xxx
                                @endforelse
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="inline-button">
                <a href="{{ URL::route('topics.index') }}" class="button">返回列表</a>
            </p>
        </form>
        <!-- /表单 -->
    </div>
    <p class="copyright"><a class="link-gray">使用前必读</a><span>粤ICP证030173号</span></p>

@stop