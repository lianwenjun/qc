
$(function(){

    // 限制编辑输入框宽度
    $(".jq-text").css("min-width", "200px");


    // 评论管理--游戏评论列表--编辑按钮效果
    editMethod();
    function editMethod() {
        
        var buttons = '<a href="javascript:;" class="button jq-edit">编辑</a>';
        var changeButtons = '<a href="javascript:;" class="button jq-confirm">确认</a>';


        // 编辑按钮
        $('.jq-edit').click(function(){
            var text = $(this).parent().siblings(".jq-text").children("span").html();
            $(this).parent().siblings(".jq-text").html('<input type="text" class="input text" value="' + text + '"/>');
            $(this).parent().html(changeButtons);


            // 确认按钮
            $(".jq-confirm").click(function(){
                $(this).parent().siblings(".jq-text").html('<span class="elimit12em cursor" title="' + $(".text").val() + '">' + $(".text").val() + '</span>');
                $(this).parent().html(buttons);
                editMethod();
            });

        });
    }

});