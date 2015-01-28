
$(function(){

    // 详情弹窗
    $('.jq-detail').click(function(){         
        $('.jq-detailModal').dialog( "open" );               
    });

    $('.jq-detailModal').dialog({
        autoOpen: false,
        modal: true,
        minWidth: 720,
        buttons: {
            返回列表: function(){
                $( this ).dialog( "close" );
            },
            结束反馈单: function(){
                $( this ).dialog( "close" );
            }
        }
    }); 

    // 详情弹窗（发送）
    $(".jq-send").click( function() {
        var msg = $(".reply-content");
        var message = $('.message'); 
        if (msg.val() == "") {
            return false;
        } else {
            var date = new Date().Format("YYYY-MM-DD hh:mm"); //调用日期
            var name = $(".own-message span").html();
            message.append('<li>' + 
                '<h6 class="message-time tc">' + date + '</h6>' +
                '<p class="own-message">' + 
                '<span>' + name + '</span>' + '：' + msg.val() + 
                '</p>' +
                '</li>'
            );
            msg.val("");
            message.scrollTop(message.height());
        }
    });

});

 
