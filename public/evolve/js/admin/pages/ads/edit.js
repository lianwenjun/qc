
$(function() {
    
    // 上传图片
    $(".jq-addPic").mouseenter(function() {
        $(".add-pic").css("display", "block");
    });
    $(".jq-addPic").mouseleave(function() {
        $(".add-pic").css("display", "none");
    });


    // 表单验证
    $(".jq-form").validate({
        ingore: '',
        rules: {
            keywords: 'required',
            ads: 'required',
            startime: 'required'
        },
        messages: {
            keywords: { required: '游戏名称为必填！' },
            ads: { required: '广告区域为必选！' },
            startime: { required: '上线开始时间为必填！' }
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