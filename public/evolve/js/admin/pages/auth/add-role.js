
$(function() {
    
    // 表单验证
    $(".jq-form").validate({
        ignore: '',
        rules: {
            user: {
                required: true,
                maxlength: 6
            }
        },
        messages: {
            user: {required: '用户名不能为空！',maxlength: '管理员角色不能大于6个字符！'}
        },
        errorPlacement: function(error, element) { 
            error.appendTo(element.closest('div').append()); 
        },
        errorElement: "em",
        onkeyup: false,
        submitHandler: function(form) {  
            form.submit();
        }
    });

});