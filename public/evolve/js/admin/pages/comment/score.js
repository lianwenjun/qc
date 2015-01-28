
$(function(){

    // 限制编辑输入框宽度
    $(".jq-text").css("min-width", "200px");


    // 评论管理--游戏评分列表--编辑按钮效果
    editMethod();
    function editMethod() {
        
        var buttons = '<a href="javascript:;" class="button jq-edit">编辑</a>';
        var changeButtons = '<a href="javascript:;" class="button jq-confirm">确认</a>';

        // 编辑按钮
        $('.jq-edit').click(function(){
            var text = $(this).parent().siblings(".jq-text").html();
            $(this).parent().siblings(".jq-text").html('<input type="text" class="input text jq-checkNum" maxlength="4em" value="' + text + '"/>');
            $(this).parent().html(changeButtons);


            // 限制输入数字
            $(".jq-checkNum").keypress(function(event) {
                var keyCode = event.which;
                if (keyCode == 46 || (keyCode >= 48 && keyCode <=57)) {
                    return true;
                } else {
                    return false;
                }
            }).focus(function() {
                this.style.imeMode = 'disabled';
            });


            // 确认按钮
            $(".jq-confirm").click(function(){
                $(this).parent().siblings(".jq-text").html($(".text").val());
                $(this).parent().html(buttons);
                editMethod();
            });


            // 取消按钮
            $(".jq-cancel").click(function(){
                $(this).parent().siblings(".jq-text").html(text);
                $(this).parent().html(buttons);
                editMethod();
            });
        });
    }

});