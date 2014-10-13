@extends('admin.layout')

@section('content')
<script type="text/javascript" src="{{ asset('js/jquery.pager.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/common.js') }}"></script>
<div class="Content_right_top Content_height">
    <div class="Theme_title">
        <h1>管理中心 <span> 角色管理</span></h1>
        <a href="{{ URL::route('roles.create') }}" target="BoardRight">添加角色</a>
    </div>
    <form action="{{ URL::route('roles.index') }}" method="get">
    <div class="Theme_Search">
        <ul>
            <li>
                <span>
                    <b>查询：</b>
                    <select name="department">
                        <option value="">--全部--</option>
                        @foreach($departments as $k => $department)
                        <option value="{{ $k }}" @if(Input::get('department') == $k)selected="selected"@endif>{{ $department }}</option>
                        @endforeach
                    </select>
                </span>
                <span>
                <input name="name" type="text" class="Search_wenben" size="20" placeholder="请输入关键词" value="{{ Input::get('name') }}" />
                </span>
                <input type="submit" value="搜索" class="Search_en" />
            </li>
        </ul>
    </div>
    </form>
    <div class="Search_cunt">共 <strong>{{ $groups['total'] }}</strong> 条记录 </div>
    <!-- 提示 -->
    @if(Session::has('tips'))
    <div class="tips">
        <div class="{{ Session::get('tips')['success'] ? 'success' : 'fail' }}">{{ Session::get('tips')['message'] }}</div>
    </div>
    @endif
   <!-- /提示 -->
    <div class="Search_biao">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="Search_biao_title">
                <td width="6%">角色ID</td>
                <td width="10%">角色</td>
                <td width="10%">所属部门</td>
                <td width="10%">操作</td>
            </tr>
            @foreach($groups['data'] as $k => $group)
            <tr class="Search_biao_{{ $k%2 == 0 ? 'one' : 'two'}}">
                <td>{{ $group['id'] }}</td>
                <td>{{ $group['name'] }}</td>
                <td>{{ $departments[$group['department']] }}</td>
                <td><a href="{{ URL::route('roles.edit', ['id' => $group['id'] ]) }}" class="Search_show">编辑</a><a href="{{ URL::route('roles.delete', ['id' => $group['id'] ]) }}" class="Search_del jq-delete">删除</a></td>
            </tr>
            @endforeach
            @if(empty($groups['total']))
            <tr class="no-data"><td colspan="5">没有数据</td></tr>
            @endif
        </table>
        @if($groups['last_page'] > 1)
        <div id="pager"></div>
        @endif
    </div>
</div>
@stop