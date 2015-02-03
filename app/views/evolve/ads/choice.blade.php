@extends('evolve.layout')
@section('custom')
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/common.css') }}">
<script type="text/javascript" src="{{ asset('/evolve/js/admin/jquery-1.9.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/common.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/pages/editable.js') }}"></script>
@stop

@section('content')
<div class="breadcrumb"><a href="javascript: ;">广告位管理</a><span>&gt;</span>精选必玩</div>  
    <div class="content"> 
        <form action="" method="get" class="validate jq-search">  
            <!-- 查询-->
            <div class="search">
                <p>查询：<input class="input" type="text" name="title" /></p>   
                <input type="submit" class="button" value="查询" />
            </div>
            <!-- /查询 -->
        </form>
        <!-- 表格 -->
        <p class="record-title">上架游戏：共
            <b class="red">{{ $choice->getTotal()}}</b>条记录
            @if(Sentry::getUser()->hasAccess('ads.choice.create'))
            <a href="{{ URL::route('ads.choice.create') }}" class="button fr">新增推广</a>
            @endif
        </p>
        <table cellpadding="0" cellspacing="0" class="zebra-table tc">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>图标</th>
                    <th>名称</th>
                    <th>包名</th>
                    <th>大小</th>
                    <th>版本</th>
                    <th>排列序号</th>
                    <th>上线时间</th>
                    <th>操作人</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse($choice as $chose)
                <tr>
                    <td>{{ $chose->id }}</td>
                    <td><img src="{{ $chose->icon }}" alt="{{ $chose->title }}" class="icon25" /></td>
                    <td><span class="elimit6em cursor" title="{{ $chose->title }}">{{ $chose->title }}</span></td>
                    <td><span class="elimit12em cursor" title="{{ $chose->package }}">{{ $chose->package }}</span></td>
                    <td>{{ $chose->size }}</td>
                    <td>{{ $chose->version }}</td>
                    <td class="jq-editable">
                        <span>{{ $chose->sort }}</span>
                        <input class="input w200 none jq-editNo jq-isNum" type="text" value="" />
                    </td>
                    <td><span class="elimit7em cursor" title="{{ $chose->stocked_at }}">{{ $chose->stocked_at }}</span></td>
                    <td>{{ $chose->operator }}</td>
                    <td>
                        <a href="javascript:;" class="button jq-edit">编辑</a>
                        <a href="javascript:;" class="button red-button jq-delete" data-url="">删除</a>
                        <a href="javascript:;" class="button jq-confirm none" data-url="">确认</a> 
                        <a href="javascript:;" class="button red-button jq-cancel none">取消</a>
                    </td>                
                </tr>
                @empty
                <tr class="no-data">
                    <td colspan="10">亲！还没有数据哦！</td>
                <tr>
                @endforelse

            </tbody>
        </table>
        <form action="" method="post" class="jq-tableForm">
            <input type="hidden" name="submitNum" value="" data-ref="jq-editNo" />
        </form>
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