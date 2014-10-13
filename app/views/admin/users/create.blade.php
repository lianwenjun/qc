@extends('admin.layout')

@section('content')
<script src="{{ asset('js/admin/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/admin/additional-methods.min.js') }}" type="text/javascript"></script>
<div class="Content_right_top Content_height">
    <div class="Theme_title">
        <h1>管理中心 <span> 管理员管理 </span> <b> 添加管理员 </b></h1>
        <a href="{{ URL::route('users.index') }}">返回列表</a>
    </div>
    <!-- 提示 -->
    @if(Session::has('tips'))
    <div class="tips">
        <div class="{{ Session::get('tips')['success'] ? 'success' : 'fail' }}">{{ Session::get('tips')['message'] }}</div>
    </div>
    @endif
    <!-- /提示 -->
    <form action="{{ URL::route('users.create') }}" id="form" method="POST">
    <table  border="0" cellspacing="0" cellpadding="0" class="add_Activation">
      <tr>
        <td align="right" width="120px">管理角色：</td>
        <td>
           <select id="u1884_input" tabindex="0" name="group_id">
                @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </td>
      </tr>
      <tr>
        <td align="right">用户状态：</td>
        <td>
          <span><input name="activated" type="radio" value="1" checked="checked"/>正常</span>
          <span><input name="activated" type="radio" value="0" />禁用</span>
        </td>
      </tr>
       <tr>
        <td align="right">用户名：</td>
        <td><input name="username" type="text" class="add_Activation_text" /></td>
      </tr>
      <tr>
        <td align="right">登陆密码：</td>
        <td><input name="password" type="password" id="password" class="add_Activation_text" /></td>
      </tr>
      <tr>
        <td align="right">确认密码：</td>
        <td><input name="repassword" type="password" class="add_Activation_text" /></td>
      </tr>
      <tr>
        <td align="right">使用人：</td>
        <td><input name="realname" type="text" class="add_Activation_text" /></td>
      </tr>
      <tr>
        <td align="right">邮箱：</td>
        <td><input name="email" type="text" class="add_Activation_text" /></td>
      </tr>
    </table>
    <div class="add_Activation_en"><a class="Search_en jq-submit" href="javascript:;">添加</a></div>
</form>
</div>
<script>
$(function() {
    // 提交表单
    $('.jq-submit').click(function() {
        // 验证
        $("#form").validate({
            ignore: '',
            rules: {
                username: {
                    required: true,
                    maxlength: 15
                },
                password: {
                    required: true,
                    maxlength: 15
                },
                repassword: {
                    required: true,
                    equalTo: '#password'
                },
                realname: {
                    required: true,
                    maxlength: 4
                },
                email: {
                  required: true,
                  email: true
                }
            },
            messages: {
                username: {required: '用户名不能为空',maxlength: '用户名不能大于15个字符'},
                password: {required: '密码不能为空',maxlength: '密码不能大于15个字符'},
                repassword: {required: '确认密码不能为空', equalTo: '两次密码不一致'},
                realname: {required: '使用人不能为空', maxlength: '使用人不能大于4个字符'},
                email: {required: '邮箱不能为空', email: '邮箱地址不正确'}
            }
        });

        if($("#form").valid()) {
            $("#form").submit();
        }
    });
});
</script>
@stop
