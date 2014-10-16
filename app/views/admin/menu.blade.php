<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="{{ asset('css/admin/menu.css') }}" rel="stylesheet" type="text/css" />
<script type="text/javascript"  src="{{ asset('js/jquery.min.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $(".accordion>li>ul>li>a").click(function(){
            $(".sub-menu_hover").parent().find("li").removeAttr("class");
            $(".mail_hover").attr("class","mail");
            $(this).parent().parent().parent().attr("class","mail_hover");
            $(this).parent().attr("class","sub-menu_hover");
        }); 
    });
</script>
</head>
<body>
<div class="Content_left">
      <ul>
            <li class="Content_left_logo">游戏商店系统</li>
            @if( Sentry::check() )
            <li class="Content_left_title">Hi，{{ Sentry::getUser()->username }}<br><a href="<?php echo URL::route('users.changePwd'); ?>" target=BoardRight>修改密码</a>　<a href="<?php echo URL::route('users.signout') ?>" target="perent">退出系统</a></li>
            @endif
      </ul>
</div>


<div id="wrapper-250">
      <ul class="accordion">
      
            <li id="one" class="mail_hover"> <a href="#one">游戏管理</a>
                 <ul class="sub-menu">
                       <li><a href="{{ URL::route('apps.onshelf') }}" target=BoardRight>上架游戏列表</a></li>
                       <li><a href="{{ URL::route('apps.draft') }}" target=BoardRight>添加编辑游戏</a></li>
                       <li><a href="{{ URL::route('apps.pending') }}" target=BoardRight>待审核列表</a></li>
                       <li><a href="{{ URL::route('apps.nopass') }}" target=BoardRight>审核不通过列表</a></li>
                       <li><a href="{{ URL::route('apps.offshelf') }}" target=BoardRight>下架游戏列表</a></li>
                 </ul>
            </li>
            
            <li id="two" class="mail"> <a href="#two">广告位管理</a>
                 <ul class="sub-menu">
                       <li><a href="{{ URL::route('appsads.index') }}" target=BoardRight>首页游戏位管理</a></li>
                       <li><a href="{{ URL::route('rankads.index') }}" target=BoardRight>排行游戏位管理</a></li>
                       <li><a href="{{ URL::route('indexads.index') }}" target=BoardRight>首页图片位管理</a></li>
                       <li><a href="{{ URL::route('editorads.index') }}" target=BoardRight>编辑精选管理</a></li>
                       <li><a href="{{ URL::route('cateads.index') }}" target=BoardRight>分类页图片位推广</a></li>

                 </ul>
            </li>
            
            <li id="three" class="mail"> <a href="#three">系统管理</a>
                 <ul class="sub-menu">
                       <li><a href="{{ URL::route('cate.index') }}" target=BoardRight>游戏分类管理</a></li>
                       <li><a href="{{ URL::route('tag.index') }}" target=BoardRight>游戏标签管理</a></li>
                       <li><a href="{{ URL::route('rating.index') }}" target=BoardRight>游戏评分列表</a></li>
                       <li><a href="{{ URL::route('comment.index') }}" target=BoardRight>游戏评论列表</a></li>
                       <li><a href="{{ URL::route('stopword.index') }}" target=BoardRight>屏蔽词管理</a></li>
                       <li><a href="{{ URL::route('keyword.index') }}" target=BoardRight>关键字管理</a></li>
                 </ul>
            </li>
            <li id="three" class="mail"><a href="#three">管理中心</a>
                 <ul class="sub-menu">
                       <li><a href="{{ URL::route('users.index') }}" target=BoardRight>管理员管理</a></li>
                       <li><a href="{{ URL::route('roles.index') }}" target=BoardRight>角色管理</a></li></li>
                 </ul>
            </li>

      </ul>
</div>
<script type="text/javascript">
        $(document).ready(function() {
            // Store variables
            var accordion_head = $('.accordion > li > a'),
                accordion_body = $('.accordion li > .sub-menu');
            // Open the first tab on load
            accordion_head.first().addClass('active').next().slideDown('normal');
            // Click function
            accordion_head.on('click', function(event) {
                // Disable header links
                event.preventDefault();
                // Show and hide the tabs on click
                if ($(this).attr('class') != 'active'){
                    accordion_body.slideUp('normal');
                    $(this).next().stop(true,true).slideToggle('normal');
                    accordion_head.removeClass('active');
                    $(this).addClass('active');
                }
            });
            $(".accordion>li>a").hover(
                function () {
                    $(this).stop().animate({ paddingRight: "25px" }, 200);
                },
                function () {
                    $(this).stop().animate({ paddingRight: "15px" });
                }
            );

        });
        
    </script>
    

</body>
</html>