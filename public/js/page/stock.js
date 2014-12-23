
$(function(){
    var strings = "<div class='jq-unstockModal' title='信息'><p>确定要下架吗？</p></div>"


    //下架弹窗
    $('.jq-unstock').click(function(){
        if ($(this).next().html() == strings) {
            $('.jq-unstockModal').dialog({
                modal: true,
                buttons: {
                    确定: function(){
                        $( this ).closest('tr').remove();
                    },
                    取消: function(){
                        $( this ).dialog( "close" );
                    }
                }
            });
        } else {
            $(this).after(strings); 
            $('.jq-unstockModal').dialog({
                modal: true,
                buttons: {
                    确定: function(){
                        $( this ).closest('tr').remove();
                    },
                    取消: function(){
                        $( this ).dialog( "close" );
                    }
                }
            });  
        }       
        
    });
        


/*    // ajax点击按钮加载表格数据
    var markup = "<tr><td> ${title} </td><td> ${content}" + 
                        "</td><td><img src='${img}' alt='${img}'/></td></tr>";
    $.template("tableTemplate", markup);
    $('.jq-load').click(function() {
        $.ajax({
            dataType: "json",
            url: "/plugin/json/data.json",
            type: "GET",
            cache: false,
            success: function(data) { 
                for (i in data.record) {
                    $.tmpl("tableTemplate", data.record[i]).appendTo(".jq-zebra");
                }
            },
            error: function() {
                alert('加载数据错误!');
            }
        }); 
    });*/


});