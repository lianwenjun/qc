
$(function(){

    //下架弹窗
    $('.jq-unstock').click(function(){         
        $('.jq-unstockModal').dialog( "open" );               
    });

    $('.jq-unstockModal').dialog({
        autoOpen: false,
        modal: true,
        buttons: {
            确定: function(){
                $( this ).dialog( "close" );
            },
            取消: function(){
                $( this ).dialog( "close" );
            }
        }
    }); 

    $('.jq-preview').click(function(){
       $('.jq-previewModal').show();
    });


});