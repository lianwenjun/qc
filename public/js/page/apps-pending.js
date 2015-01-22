
$(function(){

    // 全选
    $('.jq-choiceAll').click(function(){
        $('input:checkbox[name="pending[]"]').prop('checked', $(this).prop('checked') );
    });

});
