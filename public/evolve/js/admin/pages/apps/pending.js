
$(function(){
    
    // 不通过原因文本放入隐藏域中
    function notpassReason(){
        var value = $('input[name="reason"]:checked').val();
        $('.jq-reason').attr("value", value);
        var other = $('.jq-other').prop('checked');
        if (other == true){
            var text = $('.jq-insertReason').val();
            $('.jq-reason').attr('value', text);
        }
    }

   // 不通过弹窗
    $(".jq-notpass").click(function() {
        $('.jq-notpassForm').attr("action", $(this).data("url"));
        $(".jq-notpassModal").dialog("open");
    });

    $('.jq-notpassModal').dialog({
        autoOpen: false,
        modal: true,
        width: 400,
        height: 250,
        buttons: {
            确认: function() {   
                notpassReason();
                $('.jq-notpassForm').submit();
            },
            取消: function() {
                $(this).dialog("close");
            }
        }
    });   

});