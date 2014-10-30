$(function(){

    //左侧菜单标题点击事件
    $('.jq-menu p').click(function(){
        $('.jq-menu ul').css('display','none');
        $(this).next('ul').css('display','block');
        $('.jq-menu p').css('background-color','#dfdf0b');
        $(this).css('background-color','#f6f6f6');
    });

    //左侧菜单列表点击事件
    $('.jq-menu li').click(function(){
        $('.jq-menu li').css('color','#fff');
        $(this).css('color','#dfdf0b');
    });
    
    //上架游戏列表页面斑马纹表格样式
    $('.jq-zebra tbody tr:even,.jq-zebra li:even').css('background-color','#e2e2e2');

});