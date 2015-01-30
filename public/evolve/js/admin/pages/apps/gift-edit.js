
$(function(){

    // 表单验证
    jQuery.validator.addMethod("codeList", function(value, element) {
        var regx = /^([0-9a-zA-Z]+[,])*([0-9a-zA-Z]+)$/;
        return this.optional(element) || regx.test(value);       
    });
    $(".jq-form").validate({
        ignore: '',
        rules: {
            giftname: 'required',
            giftcontent: 'required',
            giftchange: 'required',
            getway: 'required',
            startime: 'required',
            endtime: 'required',
            giftnumber: {
                required: true,
                codeList: true
            }
        },
        messages: {
            giftname: { required: '礼包名称为必填！' },
            giftcontent: { required: '礼包内容为必填！' },
            giftchange: { required: '兑换方式为必填！' },
            getway: { required: '领取资格为必选！' },
            startime: { required: '开始时间为必填！' },
            endtime: { required: '结束时间为必填！' },
            giftnumber: {
                required: '礼包序号为必填！',
                codeList: '请填写正确的礼包序号，并以逗号隔开！'
            }
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

