
$(function() {
    
    // 标签展示--添加
    $(".jq-add").on('click', function(){
        $(".tags").append('<li>' + 
            '<input class="input w250 jq-tags jq-searchTag" type="text" placeholder="标签输入时自动匹配" />' + 
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

    // 标签展示--删除
    $(".jq-deleteTag").click(function(){
        $(this).parent().parent().fadeOut(300, function(){ $(this).remove(); });
    });


});
