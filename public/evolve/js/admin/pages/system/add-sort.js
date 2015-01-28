
$(function() {
    
    // 标签展示--添加
    $(".jq-add").click(function(){
        $(".tags").append('<li>' + 
            '<input type="text" placeholder="标签输入时自动匹配" class="input jq-tags" />' + 
            '<span class="input-delete jq-del">×</span>' + 
        '</li>');

        del();
        autocomplete();
    });

    del();
    function del() {
        $(".jq-del").click(function(){
            $(this).parent().fadeOut(300, function(){$(this).remove();})
        });
    }


    // 标签展示--删除
    $(".jq-delete").click(function(){
        $(this).parent().parent().fadeOut(300, function(){ $(this).remove(); });
    });


    // 标签自动匹配
    autocomplete();
    function autocomplete() {        
        $(".jq-tags").select2({
            minimumInputLength: 1,
            ajax: {
                type: "GET",
                url: "/js/pages/system/add-sort.json",
                dataType: 'json',
                data: function(term) {
                    return {
                        term: term
                    };
                },
                results: function(data) {
                    var suggestions = data.data.suggestions;
                    return {
                        results: suggestions.value
                    };
                },
                success: function (data) {
                    if ( data.success == true ) {
                        var suggestions = data.data.suggestions;
                        for ( var i = 0; i < suggestions.length; i++ ) {
                            $(".jq-tags").val(suggestions.value);
                        }
                    } else {
                        alert(data.msg);
                    }
                },
                error: function() {
                    alert("加载数据错误！");
                }
            }
        });
    }

});
