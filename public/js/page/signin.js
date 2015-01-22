
$(function(){

    // validate表单验证
    $( '.jq-signin' ).validate({    
        rules: {
            username: {
                required: true
            },
            password: {
                required: true
            }
        },
        messages: {
            username: {
                required: "请输入用户名！"
            },
            password: {
                required: "请输入密码！"
            }
        },
        errorPlacement: function(error, element) { 
            error.appendTo(element.parents('p').append()); 
        },
        errorElement: "em",
        onkeyup: false,
        submitHandler:function(form) {  
            form.submit();
        }
    });

});

