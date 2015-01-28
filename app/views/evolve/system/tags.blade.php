@extends('admin.layout')
@section('custom')
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/common.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugins/jquery-ui/jquery-ui.min.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugin.css') }}">
<script type="text/javascript" src="{{ asset('/evolve/js/admin/jquery-1.9.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/common.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/pages/editable.js }}"></script>
@stop
@section('content')

    <div class="breadcrumb"><a href="javascript: ;">系统管理</a><span>&gt;</span>标签库管理</div>  
    <div class="content"> 
        
            <!-- 查询-->
            <div class="search">
            {{ Form::open(['url' => '/admin/system/tags', 'method' => 'get']) }}
                <div>
                    <p>查询：
                        <input class="input" type="text" placeholder="请输入关键字" />
                    </p>
                    <input type="button" class="button" value="查询" />
                </div>
            {{ Form::close() }}
            {{ Form::open(['url' => '/admin/system/tags', 'method' => 'post']) }}
                <p>添加：
                    <input class="input" type="text" placeholder="请输入关键字" name="title" />
                </p>
                <input type="submit" class="button" value="添加" />
            {{ Form::close() }}
            </div>
            <!-- /查询 -->
        </form>
        <!-- 表格 -->
        <p class="record-title">标签数量：共<b class="red">{{ $tags->getTotal() }}</b>条记录</p>
        <!--临时提示窗口-->
        <p class="record-title">@if(Session::has('success')) 成功:{{ Session::get('success') }} @endif</p>
        <p class="record-title">{{ $errors->first() }} </p>
        <!--/临时提示窗口-->
        <table cellpadding="0" cellspacing="0" class="zebra-table tc">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>名称</th>
                    <th>搜索量</th>
                    <th>自然排名</th>
                    <th>干扰排名</th>
                    <th>最后更新时间</th>
                    <th>操作人</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
            @forelse($tags as $tag)
                <tr>
                    <td>{{ $tag->id }}</td>
                    <td><span class="elimit6em cursor" title="{{ $tag->title }}">{{ $tag->title }}</span></td>
                    <td>{{ $tag->search_count }}</td>
                    <td>0</td>
                    <td class="jq-text">1</td>
                    <td><span class="elimit7em cursor" title="2014-10-16 16:29:53">{{ $tag->updated_at }}</span></td>
                    <td>{{ $tag->operator }}</td>
                    <td>
                        <a href="javascript:;" class="button jq-edit">编辑</a>
                        <a href="javascript:;" class="button red-button jq-delete" data-url="">删除</a>
                    </td>               
                </tr>
                @empty
                <tr class="no-data">
                    <td colspan="8">亲！还没有数据哦！</td>
                <tr>
            @endforelse
            </tbody>
        </table>
        <!-- /表格 -->
        <!-- 上下翻页 -->
        <ul class="pagination">
            <li class="page disabled">首页</li> 
            <li class="page disabled">上一页</li>
            <li class="page current">1</li>
            <li class="page">2</li>
            <li class="page">3</li>
            <li class="page">4</li>
            <li class="page">5</li>……
            <li class="page">下一页</li>
            <li class="page">末页</li>
            <li>共<b class="page-total">99</b>页</li>
            <li>当前<input type="text" />页</li>
            <li class="page">GO</li>
        </ul>
        <!-- /上下翻页 -->
    </div>
    <p class="copyright"><a class="link-gray">使用前必读</a>粤ICP证030173号</p>
@stop