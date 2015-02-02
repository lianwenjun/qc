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

	<div class="breadcrumb"><a href="javascript: ;">广告位管理</a><span>&gt;</span>专题编辑管理</div>  
        <div class="content"> 
            <form action="#" method="post" class="validate jq-search">  
                <!-- 查询-->
                <div class="search">
                    <p>查询：
                        <select class="select" name="gamestate">
                            <option value="">状态</option>
                            <option value="">待发布</option>
                            <option value="">编辑中</option>
                        </select>
                        <input class="input" type="text" name="keyword" />
                    </p>
                    <div class="jq-date date">日期：
                        <input class="input" type="text" name="date[]" placeholder="2014.10.10——2014.11.11" />
                        <div class="date-table"></div>
                    </div>   
                    <input type="button" class="button" value="查询" />
                </div>
                <!-- /查询 -->
            </form>
            <!-- 表格 -->
            <p class="record-title">
            	待编辑专题：共<b class="red">{{ $datas->getTotal() }}</b>条记录
            	@if(Sentry::getUser()->hasAccess('topics.revocate'))
        			<a href="{{ URL::route('topics.create') }}" class="button fr">新增推广</a>
            	@endif
            </p>
            <table cellpadding="0" cellspacing="0" class="zebra-table tc">
                <thead>
                    <tr>
                        <th>排列序号</th>
                        <th>名称</th>
                        <th>创建时间</th>
                        <th>上架时间</th>
                        <th>状态</th>
                        <th>操作人</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                	@forelse($datas as $data)
                    <tr>
                        <td>1</td>
                        <td><span class="elimit6em cursor" title="{{ $data->title }}">{{ $data->title }}</span></td>
                        <td><span class="elimit8em cursor" title="{{ $data->created_at }}">{{ $data->created_at }}</span></td>
                        <td><span class="elimit8em cursor" title="{{ $data->stocked_at }}">{{ $data->stocked_at }}</span></td>
                        <td class="@if($data->status == 'pending') green @else red @endif">{{ $statusLang[$data->status] }}</td>
                        <td>{{ $data->operator }}</td>
                        <td>
                        	@if(Sentry::getUser()->hasAccess('topics.revocate'))
                            <a href="javascript:;" class="button @if($data->status == 'draft') disabled @else jq-delete @endif" data-url="{{ URL::route('topics.revocate', $data->id) }}">撤销</a>
                            @endif
                            @if(Sentry::getUser()->hasAccess('topics.show'))
                            <a href="{{ URL::route('topics.show', $data->id) }}" class="button">查看</a>
                            @endif
                            @if(Sentry::getUser()->hasAccess('topics.edit'))
                            <a href="{{ URL::route('topics.edit', $data->id) }}" class="button">@if($data->status == 'draft')草稿@else编辑@endif</a>
                            @endif
                            @if(Sentry::getUser()->hasAccess('topics.delete'))
                            <a href="javascript:;" class="button red-button jq-delete" data-url="{{ URL::route('topics.delete', $data->id) }}">删除</a>
                            @endif
                        </td>               
                    </tr>
                    @empty
                    <tr class="no-data">
                        <td colspan="7">亲！没有数据哦！</td>
                    <tr>
                	@endforelse

                </tbody>
            </table>
            <!-- /表格 -->
            <!-- 上下翻页 -->
            <ul class="pagination">
                <li><a class="disabled" href="http://localhost/static1/testproj/public/admin/users /lists?page=1">首页</a></li>
                <li><a class="disabled" href="http://localhost/static1/testproj/public/admin/users /lists?page=3">上一页</a></li>
                <li><span>...</span></li>
                <li><a href="http://localhost/static1/testproj/public/admin/users/lists?page=2">2</a></li>
                <li><a href="http://localhost/static1/testproj/public/admin/users/lists?page=3">3</a></li>
                <li><span class="current">4</span></li>
                <li><a href="http://localhost/static1/testproj/public/admin/users/lists?page=5">5</a></li>
                <li><a href="http://localhost/static1/testproj/public/admin/users/lists?page=6">6</a></li>
                <li><span>...</span></li>
                <li><a href="http://localhost/static1/testproj/public/admin/users /lists?page=5">下一页</a></li>
                <li><a href="http://localhost/static1/testproj/public/admin/users /lists?page=7">末页</a></li>
                <li>共<b>99</b>页</li>
                <li>
                    <form method="get" action="">
                        <input type="text" value="" />
                        <input type="submit" class="page" value="GO" />
                    </form>
                </li>
            </ul> 
            <!-- /上下翻页 -->
        </div>
        <p class="copyright"><a class="link-gray">使用前必读</a>粤ICP证030173号</p>
    
@stop