@extends('admin.layout')

@section('content')
<script src="{{ asset('js/admin/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/admin/additional-methods.min.js') }}" type="text/javascript"></script>
<div class="Content_right_top Content_height">
    <div class="Theme_title">
        <h1>管理中心 <span> 角色管理</span> <b> 编辑角色 </b></h1>
        <a href="{{ URL::route('roles.index') }}">返回列表</a>
    </div>
    <!-- 提示 -->
    @if(Session::has('tips'))
    <div class="tips">
        <div class="{{ Session::get('tips')['success'] ? 'success' : 'fail' }}">{{ Session::get('tips')['message'] }}</div>
    </div>
    @endif
    <!-- /提示 -->
    <form action="{{ URL::route('roles.edit', ['id' => $group->id]) }}" id="form" method="POST">
    <input type="hidden" name="_method" value="PUT">
    <div class="Search_biao">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin:20px 0px;">
            <tr class="Search_biao_text">
                <td align="left"><b>管理角色：</b><input name="name" type="text" value="{{ $group->name }}" maxsize="6" size="40"/> </td>
            </tr>
            <tr class="Search_biao_text">
                <td >
                    <b>所属部门：</b>
                    <select class="u40" id="u40" name="department">
                        @foreach($departments as $k => $department)
                        <option value="{{ $k }}" @if($k == $group->department)selected="selected"@endif>{{ $department }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="Search_biao_title">
                <td width="140"> 页面</td>
                <td>权限</td>
            </tr>
            <?php $i = 0; ?>
            <?php 
                $permissionArray = json_decode($group->permissions, true);
                $hasPermissions = !empty($permissionArray) ? array_keys($permissionArray) : [];
            ?>
            @foreach($permissions as $k => $permission)
            <?php $i ++; ?>
            <tr class="Search_user_{{ $i%2 == 0 ? 'one' : 'two'}}">
                <td><strong>{{ $k }}</strong></td>
                <td>
                    @foreach($permission as $key => $title)
                    <span><lable><input name="permissions[]" type="checkbox" value="{{$key}}" @if(!empty($hasPermissions) && in_array($key, $hasPermissions))checked="checked"@endif/>{{ $title }}</lable></span>
                    @endforeach
                </td>
            </tr>
            @endforeach
            <tr class="Search_biao_xuan">
                <td align="center">
                    <a href="{{ URL::route('roles.index') }}" class="Search_biao_button" >返回</a>
                    <a href="javascript:;" class="Search_biao_button jq-submit" > 提交 </a>
                </td>
            </tr>
        </table>
    </div>
    </form>
</div>
<script>
// 提交审核
    $('.jq-submit').click(function() {
        // 验证
        $("#form").validate({
            ignore: '',
            rules: {
                name: {
                    required: true,
                    maxlength: 6,
                }
            },
            messages: {
                name: {required: '管理角色不能为空',maxlength: '管理角色不能大于6个字符'}
            }
        });

        if($("#form").valid()) {
            $("#form").submit();
        }
    });
</script>
@stop