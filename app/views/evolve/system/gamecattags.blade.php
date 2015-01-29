@extends('evolve.layout')
@section('custom')
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/common.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugins/jquery-ui/jquery-ui.min.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugin.css') }}">
<script type="text/javascript" src="{{ asset('/evolve/js/admin/jquery-1.9.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/common.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/pages/editable.js') }}"></script>
@stop
@section('content')

    <div class="breadcrumb"><a href="javascript: ;">系统管理</a><span>&gt;</span>分类标签管理</div>  
        <div class="content"> 
                
                <!-- 查询-->
                <div class="search">
                    {{ Form::open(['url' => URL::route('gamecattags.index'), 'method' => 'get']) }}
                    <div>
                        <p>查询：
                        {{ Form::select('searchsort', $cats, '', ['class' => 'select']) }}
                        </p>
                        <p><input class="input" type="text" placeholder="标签输入时自动匹配" /></p>
                        <p><span class="red">（匹配标签库内容）</span></p>
                        <input type="submit" class="button" value="查询" />
                    </div>
                    {{ Form::close() }}
                    {{ Form::open(['url' => URL::route('gamecattags.index'), 'method' => 'post']) }}
                    <p>添加：
                    {{ Form::select('catid', $cats, '', ['class' => 'select']) }}
                        <!--
                            <select class="select" name="searchsort">
                                <option value="">所属游戏分类</option>
                                <option value="">体育竞技</option>
                                <option value="">策略卡牌</option>
                                <option value="">格斗游戏</option>
                                <option value="">动作游戏</option>
                            </select>
                        -->
                    </p>
                    <p>
                        <input class="input" type="text" placeholder="标签输入时自动匹配" name="title" />
                        <input class="input" type="hidden" name="tagid" />
                    </p>
                    <p><span class="red">（匹配标签库内容）</span></p>
                    <input type="submit" class="button" value="添加" />
                    {{ Form::close() }}
                </div>
                <!-- /查询 -->
            <!-- 表格 -->
            <p class="record-title">分类标签数量：共<b class="red">{{ $catTags->getTotal() }}</b>条记录</p>
            <!--临时提示窗口-->
            <p class="record-title">@if(Session::has('success')) 成功:{{ Session::get('success') }} @endif</p>
            <p class="record-title">{{ $errors->first() }} </p>
            <!--/临时提示窗口-->
            <table cellpadding="0" cellspacing="0" class="zebra-table tc">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th>标签名称</th>
                        <th>ID</th>
                        <th>分类名称</th>
                        <th>操作人</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($catTags as $catTag)
                    <tr>
                        <td></td>
                        <td><span class="elimit6em cursor" title="{{ $tags[$catTag->tag_id] }}">{{ $tags[$catTag->tag_id] }}</span></td>
                        <td>{{ $catTag->id}}</td>
                        <td><span class="elimit6em cursor" title="{{ $cats[$catTag->cat_id] }}">{{ $cats[$catTag->cat_id] }}</span></td>
                        @if($catTag->operator_id == 0)
                        <td>管理员</td>
                        @else
                        <td>{{ $catTag->operator }}</td>
                        @endif
                        <td>
                            <a href="javascript:;" class="button red-button jq-delete" data-url="">删除</a>
                        </td>              
                    </tr>
                    @empty
                    <tr class="no-data">
                        <td colspan="6">亲！还没有数据哦！</td>
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