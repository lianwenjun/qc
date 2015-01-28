
$(function(){

    // 用户中心-用户查询-tab切换
    $('.jq-tabs li').click(function(){
        $(this).addClass('current').siblings().removeClass('current');
        $(".jq-tabs table").hide().eq($('.jq-tabs li').index(this)).show();
    }); 

});