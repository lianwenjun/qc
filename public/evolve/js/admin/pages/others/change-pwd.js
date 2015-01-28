
$(function(){

    // validate表单验证
    $( '.jq-changePwd' ).validate({    
        rules: {
            "old-password": {
                required: true
            },
            "new-password": {
                required: true,
                rangelength: [6, 16]
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
                required: "请输入新密码！",
                rangelength: "请输入6-16个字符!"
            },
            "check-password": {
                required: "请再次输入新密码！",
                equalTo: "两次密码输入不一致！"
            }
        },
        errorPlacement: function(error, element) { 
            error.appendTo(element.parent('td')); 
        },
        errorElement: "em",
        onkeyup: false,
        onfocusout: false,
        onsubmit: true,
        submitHandler:function(form) {  
            
            var oldPwd = $('input[name="old-password"]').val();
            var newPwd = $('input[name="new-password"]').val();

            $.ajax({
                type: "GET", // 此处应用POST
                url: "/evolve-ui/js/pages/others/signin.json",
                dataType: "json",
                data: { "old-password": oldPwd, "new-password": newPwd, "_method": "PUT" },
                success: function(data)
                {   
                    if(data.success == "true"){
                        window.location.href="/evolve-ui/signin.html";
                    }else{
                        $('.jq-alert').children('p').remove();
                        $('<p class="alert alert-danger"></p>').insertBefore('form').text(data.msg);                    
                    }
                },
                error: function() {
                    alert('加载数据错误!');
                }
            });

        }
    });

});

