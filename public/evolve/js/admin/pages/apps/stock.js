
$(function(){

    // 安装包验证(范围都填或都不填)
   /* $('.jq-search').validate({
        rules: {
            "size[]": { 
                required: function(){
                    var sizeStart = $('.jq-sizeStart').val();
                    var sizeEnd = $('.jq-sizeEnd').val();
                    if((sizeStart == '') && (sizeEnd == '')){
                        return true;
                    }
                    if((sizeStart != '') && (sizeEnd != '')){
                        return true;
                    }
                }
            }
        },
        messages: {
            "size[]": {
                required: "请将安装包范围填写完整！"
            }
        },
        errorPlacement: function(error, element) { 
            error.appendTo(element.closest('div').append()); 
        },
        onkeyup: false,
        onfocusout: false,
        onsubmit: true,
        errorElement: "em",
        submitHandler:function(form) { 
            form.submit();       
        }
    });*/

});