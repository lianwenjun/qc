@extends('admin.layout')

@section('content')
<script type="text/javascript" src="{{ asset('js/jquery.pager.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/common.js') }}"></script>
<div class="Content_right_top Content_height">
    <div class="Theme_title">
        <h1>管理中心 <span> 管理员管理</span></h1>
        @if(Sentry::getUser()->hasAccess('roles.create'))
        <a href="{{ URL::route('users.create') }}" class="Theme_Excel">添加管理员</a>
        @endif
    </div>
    <form action="{{ URL::route('users.index') }}" method="get">
    <div class="Theme_Search">
        <ul>
            <li>
                <span>
                    <b>查询：</b>
                    <select name="group_id">
                        <option value="">--全部--</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}" @if(Input::get('group_id') == $role->id)selected="selected"@endif>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </span>
                <span>
                    <select name="activated">
                        <option value="">--状态--</option>
                        <option value="1" @if(Input::get('activated') === '1')selected="selected"@endif>正常</option>
                        <option value="0" @if(Input::get('activated') === '0')selected="selected"@endif>禁止</option>
                    </select>
                </span>
                <span>
                <input name="username" type="text" class="Search_wenben" size="20" placeholder="请输入关键词" value="{{ Input::get('username') }}" />
                </span>
                <input type="submit" value="搜索" class="Search_en" />
            </li>
        </ul>
    </div>
    </form>
    <div class="Search_cunt">共 <strong>{{ $users['total'] }}</strong> 条记录 </div>
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
                <td width="6%">用户ID</td>
                <td width="10%">用户名</td>
                <td width="10%">角色</td>
                <td width="10%">使用人</td>
                <td width="12%">邮箱</td>
                <td width="12%">添加时间</td>
                <td width="6%">状态</td>
                <td width="10%">操作</td>
            </tr>
            @foreach($users['data'] as $k => $user)
            <tr class="Search_biao_{{ $k%2 == 0 ? 'one' : 'two'}}">
                <td>{{ $user['id'] }}</td>
                <td>{{ $user['username'] }}</td>
                <td>{{ $user['role'] }}</td>
                <td>{{ $user['realname'] }}</td>
                <td>{{ $user['email'] }}</td>
                <td>{{ $user['created_at'] }}</td>
                <td><img src="@if($user['activated']) {{ asset('images/xia_yes.png') }} @else {{ asset('images/xia_none.png') }} @endif" width="18" height="18" /></td>
                <td>
                    @if(Sentry::getUser()->hasAccess('roles.edit'))
                    <a href="{{ URL::route('users.edit', ['id' => $user['id']]) }}" class="Search_show">编辑</a>
                    @endif
                    @if(Sentry::getUser()->hasAccess('roles.delete'))
                    <a href="{{ URL::route('users.delete', ['id' => $user['id']]) }}" class="Search_del jq-delete">删除</a>
                    @endif
                </td>
            </tr>
            @endforeach
            @if(empty($users['total']))
            <tr class="no-data"><td colspan="8">没有数据</td></tr>
            @endif
        </table>
        @if($users['last_page'] > 1)
        <div id="pager"></div>
        @endif
    </div>
</div>
<script type="text/javascript">
   $(document).ready(function() {
      // 分页
      pageInit({{ $users['current_page'] }}, {{ $users['last_page'] }}, {{ $users['total'] }});
   });
</script>
@stop