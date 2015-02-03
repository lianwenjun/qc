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

<div class="breadcrumb"><a href="javascript: ;">广告位管理</a><span>&gt;</span>首页图片位管理</div>  
    <div class="content"> 
        <form action="#" method="post" class="validate jq-search">  
            <!-- 查询-->
            <div class="search">
                <p>查询：
                    {{ Form::select('status', $datas['status'], '', ['class' => 'select']) }}
                    <!-- <select class="select" name="gamestate">
                        <option value="">状态</option>
                        <option value="">线上展示</option>
                        <option value="">已下架</option>
                    </select> -->
                    {{ Form::select('location', $datas['locations'], '', ['class' => 'select']) }}
                    <!-- <select class="select" name="gametype">
                        <option value="">所属类别</option>
                        <option value="">轮播焦点图</option>
                        <option value="">新品抢玩专题位</option>
                        <option value="">热门下载专题位</option>
                        <option value="">专题位一</option>
                        <option value="">专题位二</option>
                        <option value="">专题位三</option>
                        <option value="">专题位四</option>
                    </select> -->
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
        <p class="record-title">上架游戏：共
            <b class="red">{{ $datas['banners']->getTotal()}}</b>条记录
            @if(Sentry::getUser()->hasAccess('banners.create'))
            <a href="{{ URL::route('banners.create') }}" class="button fr">新增推广</a>
            @endif
        </p>
        <table cellpadding="0" cellspacing="0" class="zebra-table tc">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>图标</th>
                    <th>名称</th>
                    <th>所属类别</th>
                    <th>排列序号</th>
                    <th>上线时间</th>
                    <th>下线时间</th>
                    <th>状态</th>
                    <th>操作人</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse($datas['banners'] as $banner)
                <tr>
                    <td>{{ $banner->id }}</td>
                    <td><img src="../images/pages/icon1.jpg" alt="图标1" class="icon25" /></td>
                    <td><span class="elimit6em cursor" title="我叫MT  online">{{ $banner->title }}</span></td>
                    <td>{{ $datas['locations'][$banner->location] }}</td>
                    <td>{{ $banner->sort }}</td>
                    <td><span class="elimit8em cursor" title="{{ date('Y-m-d h:m:s', $banner->stocked_at) }}">{{ date('Y-m-d h:m:s', $banner->stocked_at) }}</span></td>
                    <td><span class="elimit8em cursor" title="{{ date('Y-m-d h:m:s', $banner->unstocked_at) }}">{{ date('Y-m-d h:m:s', $banner->unstocked_at) }}</span></td>
                    <td class="green">{{ $datas['status'][$banner->status] }}</td>
                    <td>{{ $banner->operator }}</td>
                    <td>
                        @if(Sentry::getUser()->hasAccess('banners.unstock'))
                        <a href="javascript:;" class="button jq-unstock @if($banner->status != 'stock') disabled @endif" data-url="@if($banner->status == 'stock'){{ URL::route('banners.unstock', $banner->id) }} @endif">下架</a>
                        @endif
                        @if(Sentry::getUser()->hasAccess('banners.edit'))
                        <a href="@if($banner->status == 'stock'){{ URL::route('banners.edit', $banner->id) }} @else javascript:; @endif" class="button @if($banner->status != 'stock') disabled @endif">编辑</a>
                        @endif
                        @if(Sentry::getUser()->hasAccess('banners.delete'))
                        <a href="javascript:;" class="@if($banner->status == 'stock') button disabled @else red-button @endif" data-url="@if($banner->status != 'stock') {{URL::route('banners.delete', $banner->id)}} @endif">删除</a>
                        @endif
                    </td>               
                </tr>
                @empty
                <tr class="no-data">
                    <td colspan="10">亲！还没有数据哦！</td>
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