@extends('admin.layout')

@section('content')
<script src="{{ asset('js/admin/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/admin/additional-methods.min.js') }}" type="text/javascript"></script>
<div class="Content_right_top Content_height">
    <div class="Theme_title">
        <h1>管理中心 <b> 修改密码 </b></h1>
    </div>
    <!-- 提示 -->
    @if(Session::has('tips'))
    <div class="tips">
        <div class="{{ Session::get('tips')['success'] ? 'success' : 'fail' }}">{{ Session::get('tips')['message'] }}</div>
    </div>
    @endif
    <!-- /提示 -->
    <form action="{{ URL::route('users.changePwd') }}" id="form" method="POST">
    <input type="hidden" name="_method" value="PUT">
    <table  border="0" cellspacing="0" cellpadding="0" class="add_Activation">
      <tr>
        <td align="right">登陆密码：</td>
        <td><input name="password" type="password" id="password" class="add_Activation_text"/></td>
      </tr>
      <tr>
        <td align="right">确认密码：</td>
        <td><input name="repassword" type="password" class="add_Activation_text" /></td>
      </tr>
    </table>
    <div class="add_Activation_en"><a class="Search_en jq-submit" href="javascript:;">修改</a></div>
</form>
</div>
<script>
$(function() {
    // 提交表单
    $('.jq-submit').click(function() {
        // 验证
        $("#form").validate({
            rules: {
                password: {
                   required: true,
                    maxlength: 15
                },
                repassword: {
                    required: true,
                    equalTo: '#password'
                }
            },
            messages: {
                password: {required: '登陆密码不能为空',maxlength: '密码不能大于15个字符'},
                repassword: {required: '确认密码不能为空',equalTo: '两次密码不一致'},
            }
        });

        if($("#form").valid()) {
            $("#form").submit();
        }
    });
});
</script>
@stop