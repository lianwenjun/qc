$(function(){

    $.validator.setDefaults({
        errorPlacement: function(error, element) { 
            error.appendTo(element.parent()); 
        },
        errorElement: "em"
    });

    // 验证不通过弹窗
    $('.jq-notpassForm').validate({
        ignore: "",
        rules: {
            "notpass-reason": {
                required: true
            }
        },
        messages: {
            "notpass-reason": {
                required: "请输入不通过原因！"
            }
        }
    });

    // 验证添加分类弹窗
    $('.jq-addCateForm').validate({
        rules: {
            cateName: {
                required: true
            },
            cateLocation: {
                required: true
            },
            cateSort: {
                required: true,
                min: 0,
                digits: true
            }
        },
        messages: {
            cateName: {
                required: "请输入分类名称！"
            },
            cateLocation: {
                required: "请选择分类位置！"
            },
            cateSort: {
                required: "请输入排序！",
                min: "请输入最小为0的值！",
                digits: "请输入整数！"
            }
        }
    });
    
    // 验证添加供应商弹窗
    $('.jq-addSupplierForm').validate({
        rules: {
            supplierName: {
                required: true,
                maxlength: 28
            },
            supplierAlias: {
                required: true,
                maxlength: 8
            }
        },
        messages: {
            supplierName: {
                required: "请输入供应商名称！",
                maxlength: "请输入最多28个字符！"

            },
            supplierAlias: {
                required: "请输入供应商名称简写！",
                maxlength: "请输入最多8个字符！"
            }
        }
    });


    // 验证添加渠道商弹窗
    $('.jq-addChannelForm').validate({
        rules: {
            channelName: {
                required: true,
                maxlength: 28
            },
            channelNum: {
                required: true,
                maxlength: 8
            }
        },
        messages: {
            channelName: {
                required: "请输入渠道商名称！",
                maxlength: "请输入最多28个字符！"

            },
            channelNum: {
                required: "请输入渠道号！",
                maxlength: "请输入最多8个字符！"
            }
        }
    });


    // 验证添加关键字弹窗
    $('.jq-addKeyForm').validate({
        rules: {
            keyName: {
                required: true,
                maxlength: 28
            }
        },
        messages: {
            keyName: {
                required: "请输入关键字名称！",
                maxlength: "请输入最多28个字符！"

            }
        }
    });

});