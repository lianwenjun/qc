
$(function(){

    // validate表单验证
    $( '.jq-changePwd' ).validate({    
        rules: {
            "old-password": {
                required: true
            },
            "new-password": {
                required: true
            },
            "check-password": {
                required: true,
                equalTo: "#new-password"
            }
        },
        messages: {
            "old-password": {
                required: "请输入当前密码！"
            },
            "new-password": {
                required: "请输入新密码！"
            },
            "check-password": {
                required: "请再次输入新密码！",
                equalTo: "两次密码输入不一致！"
            }
        },
        errorPlacement: function(error, element) { 
            error.appendTo(element.parent('td').append()); 
        },
        errorElement: "em",
        onkeyup: false,
        submitHandler:function(form) {  
            form.submit();
        }
    });

});

