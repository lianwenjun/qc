
$(function() {
    
    // 表单验证
    $(".jq-form").validate({
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
                maxlength: 6
            },
            email: {
              required: true,
              email: true
            }
        },
        messages: {
            username: {required: '用户名不能为空！',maxlength: '用户名不能大于15个字符！'},
            password: {required: '密码不能为空！',maxlength: '密码不能大于15个字符！'},
            repassword: {required: '确认密码不能为空！', equalTo: '两次密码不一致！'},
            realname: {required: '使用人不能为空！', maxlength: '使用人不能大于6个字符！'},
            email: {required: '邮箱不能为空！', email: '邮箱地址不正确！'}
        },
        errorPlacement: function(error, element) { 
            error.appendTo(element.closest('td').append()); 
        },
        errorElement: "em",
        onkeyup: false,
        submitHandler: function(form) {  
            form.submit();
        }
    });

});