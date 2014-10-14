<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>游戏商店后台</title>
        <link href="<?php echo asset('/css/admin/signin.css') ?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript"  src="<?php echo asset('/js/jquery.min.js') ?>"></script>
        <script type="text/javascript" src="<?php echo asset('/js/admin/signin.js') ?>"></script>
        <script type="text/javascript"  src="<?php echo asset('/js/admin/modernizr.custom.js') ?>"></script>
        <!--/ 弹窗 -->
        <script type="text/javascript">
            $(document).ready(function () {
                function target(){
                    window.location.href = '/nohtml5.html';
                }
                if (!Modernizr.canvas) {
                    //alert('对不起，您的浏览器不支持HTML5，推荐使用CHROME、火狐浏览器或者IE10以上版本的浏览器');
                    target()
                }
                else if (!Modernizr.localstorage) {
                    //alert('对不起，您的浏览器不支持HTML5，推荐使用CHROME、火狐浏览器或者IE10以上版本的浏览器');
                    target()
                }
            });
        </script>
    </head>
    <body>
        <form action="<?php echo URL::route('users.signin'); ?>" method="post">
            <div class="login">
                <ul>
                    <li class="login_title">游戏商店后台</li>
                    <li class="login_li"><span>用户名：</span><input name="username" type="text" size="27" /></li>
                    <li class="login_li"><span>密码：</span><input name="password" type="password" size="27" /></li>
                    <!--li class="login_li">
                        <div class="login_validation"><span>验证码：</span><input name="" type="text" size="8" /></div>
                        <h1><img src="images/yanzheng.jpg" width="99" height="30" /></h1>
                    </li-->
                    <?php
                    if(Session::has('tips')) {
                    ?>
                    <li style="text-align: center;"><span class="<?php echo Session::get('tips')['success'] ? 'success' : 'fail' ?>"><?php echo  Session::get('tips')['message']; ?></span></li>
                    <?php 
                    }
                    ?>
                    <li class="login_li"><input type="submit" class="login_submit" value="　" /></li>
                </ul>
            </div>
            <input name="_method" type="hidden" value="PUT"/>
        </form>
    </body>
</html>