
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
            error.appendTo(element.parents('p')); 
        },
        errorElement: "em",
        onkeyup: false,
        onfocusout: false,
        onsubmit: true,
        submitHandler:function(form) {  
            
            var username = $('input[name="username"]').val();
            var password = $('input[name="password"]').val();

            $.ajax({
                type: "GET", // 此处应用POST
                url: "/evolve-ui/js/pages/others/signin.json",
                dataType: "json",
                data: { "username": username, "password": password, "_method": "PUT" },
                success: function(data)
                {   
                    if(data.success == "true"){
                        window.location.href="/evolve-ui/others/welcome.html";
                    }else{
                        $('em').remove();
                        $('input[name= "password"]').closest('p').append('<em>&#12288;用户名或密码错误!</em>');                     
                    }
                },
                error: function() {
                    alert('加载数据错误!');
                }
            });

        }
    });

});

