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
            <a href="javascript:;">系统管理</a><span>&gt;</span>游戏分类管理
        </div>  
        <div class="content"> 
            <!-- 表格 -->
            <p class="record-title">
                游戏分类：共<b class="red">{{ $cats->getTotal() }}</b>条记录
                <a href="javascript:;" class="button fr jq-preview">预览</a>
                @if(Sentry::getUser()->hasAccess('cat.create'))
                <a href="javascript:;" class="button fr mr10 jq-addCate">新增分类</a>
                @endif
            </p>
            <table cellpadding="0" cellspacing="0" class="zebra-table tc">
                <thead>
                    <tr>
                        <th>分类位ID</th>
                        <th>分类位置</th>
                        <th>分类名称</th>
                        <th>排序</th>
                        <th>分类标签展示</th>
                        <th>操作人</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cats as $cat)
                    <tr>
                        <td>{{ $cat->id }}</td>
                        <td>{{ $position[$cat->position] }}</td>
                        <td><span class="elimit6em cursor" title="{{ $cat->title }}">{{ $cat->title }}</span></td>
                        <td>{{ $cat->sort }}</td>
                        @if(!$cat->tags)
                        <td><span class="elimit12em cursor" title="/">/</span></td>
                        @else
                        <td><span class="elimit12em cursor" title="{{ $cat->tags }}">{{ $cat->tags }}</span></td>
                        @endif
                        @if($cat->operator_id == 0)
                        <td>管理员</td>
                        @else
                        <td>{{ $cat->operator }}</td>
                        @endif
                        <td>
                            @if(Sentry::getUser()->hasAccess('cat.edit'))
                            <a href="{{ URL::route('cat.edit', $cat->id) }}" class="button">编辑</a>
                            @endif
                            @if(Sentry::getUser()->hasAccess('cat.delete'))
                            <a href="javascript:;" class="button red-button jq-delete" data-url="{{ URL::route('cat.delete', $cat->id) }}">删除</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr class="no-data">
                        <td colspan="7">亲！还没有数据哦！</td>
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
        <p class="copyright"><a class="link-gray">使用前必读</a><span>粤ICP证030173号</span></p>

         <!-- 新增分类弹窗 -->
    <div class="jq-addCateModal none" title="新增分类">
    	{{ Form::open(['url' => '/admin/cat/index', 'method' => 'post', 'class' => 'jq-addCateForm validate validate-em' ]) }}
        
            <table class="edit-table">
                <tr>
                    <td class="label">分类名称：</td>
                    <td>
                        <input class="input label-content" name="title" type="text" value="" placeholder="输入文本....">
                    </td>
                </tr>
                <tr>
                    <td class="label">分类位置：</td>
                    <td>
                        <select class="select" name="position">
                            <option value="">分类位置</option>
                            @foreach($position as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">排序：</td>
                    <td>
                        <input class="input label-content" name="sort" type="text" value="0" >
                    </td>
                </tr>
            </table>
        {{ Form::close() }}
    </div>
    <!-- /新增分类弹窗 -->
    <!-- 手机预览弹窗内容 -->
    <div class="phone-wrap jq-previewModal">
        <h1 class="phone-title"><i class="icon-list fl f18"></i><input type="text" class="w200" /><i class="icon-search fr f18"></i></h1>
        <div class="phone-content">
            <h3>热门分类</h3>
            <ul class="division-wrap2 division"> 
                <li class="red2-bg"><i class="icon-thumb-up mr5"></i>精选推荐</li>
                <li class="orange-bg"><i class="icon-gamepad mr5"></i>经典单机</li>
                <li class="blue2-bg"><i class="icon-bookmark mr5"></i>最新上线</li>
                <li class="green2-bg"><i class="icon-flame mr5"></i>热门网游</li>
            </ul>
            <h3>游戏分类</h3>
            <ul class="jq-pcat">
            </ul>
        </div>
        <span class="phone-exit jq-exit">退出预览</span>
    </div>
    <!-- /手机预览弹窗内容 -->
@stop