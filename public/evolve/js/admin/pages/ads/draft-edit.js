
$(function() {
    
    // 上传图片
    $(".jq-addImg").mouseenter(function() {
        $(".add-img").css("display", "block");
    });
    $(".jq-addImg").mouseleave(function() {
        $(".add-img").css("display", "none");
    });


    // 添加游戏内容
    $(".jq-add").click(function(){
        $(".game-content").append('<li>' + 
            '<input type="text" placeholder="标签输入时自动匹配" class="input" />' + 
            '<span class="input-delete jq-del">×</span>' + 
        '</li>');

        del();
    });

    del();
    function del() {
        $(".jq-del").click(function(){
            $(this).parent().fadeOut(300, function(){$(this).remove();})
        });
    }

    $(".jq-delete").click(function(){
        $(this).parent().parent().fadeOut(300, function(){$(this).remove();})
    });


    // 表单验证
    $(".jq-form").validate({
        ingore: '',
        rules: {
            keywords: 'required',
            draftposition: 'required'
        },
        messages: {
            keywords: { required: '游戏名称为必填！' },
            draftposition: { required: '广告区域为必选！' }
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