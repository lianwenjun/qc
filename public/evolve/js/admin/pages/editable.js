
//
// 点击编辑按钮，文本为可编辑的输入框形式
// 广告位管理-精选必玩管理， 系统管理-供应商管理， 系统管理-关键字管理， 系统管理-渠道商管理， 系统管理-标签库管理， 系统管理-屏蔽词管理, 评论管理-游戏评论列表， 评论管理-游戏评分列表
//

$(function() {

    var hasEmpty = false;
    var valueEqual = true;
    var isOpen = false;

    // 点击编辑按钮出现输入框，值为原文本
    $('.jq-edit').on('click', function() {    
        if(isOpen == true) {
            return;
        }  
        $(this).closest('tr').find('.jq-editable').children().toggleClass('none');
        $(this).parent().children().toggleClass('none');
        var tr = $(this).closest('tr');
        $('.jq-tableForm input').each(function() {
            var defaultValue = tr.find("." + $(this).data('ref')).prev('span').text();
            tr.find("." + $(this).data('ref')).val(defaultValue);
            $(this).val(defaultValue);
        });
        isOpen = true;  
    });
    
    // 点击确定按钮提交隐藏表单
    $('.jq-confirm').on('click', function() {
        var tr = $(this).closest('tr');
        $('.jq-tableForm input').each(function() {
            var value = $(this).val();
            var refValue = tr.find("." + $(this).data('ref')).val();
            refValue = $.trim(refValue);
            if (refValue == '') {
                hasEmpty = true;
            }
            if (value != refValue) {
                valueEqual = false;
                $(this).val(refValue);
            }
        });
        if (hasEmpty == true || valueEqual == true) {
            $(this).closest('tr').find('.jq-editable').children().toggleClass('none');          
            $(this).parent().children().toggleClass('none');
            isOpen = false;
        } else {
            $('.jq-tableForm').attr('action', $(this).data('url'));
            $('.jq-tableForm').submit();
        }
    });

    // 点击取消按钮还原文本
    $('.jq-cancel').on('click', function() {
        $(this).closest('tr').find('.jq-editable').children().toggleClass('none');
        $(this).parent().children().toggleClass('none');
        isOpen = false;
    });

});
