
$(function(){
 
    //左侧菜单标题点击事件
    $('.jq-menu p').click(function(){       
        $(this).toggleClass('current').parent().siblings().children("p").removeClass('current');
        $(this).next('ul').slideToggle().parent().siblings().children("ul").slideUp();
    });

    $('.jq-menu p').hover(function(){ 
        $(this).animate({paddingRight: '+=10px'}, 200);
    }, function(){
        $(this).animate({paddingRight: '-=10px'}, 200);
    });


    //左侧菜单列表点击事件
    $('.jq-menu li').click(function(){
        $('.jq-menu li').css('color','#fff');
        $(this).css('color','#dfdf0b');
    });


});