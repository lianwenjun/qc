<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="{{ asset('css/admin/main.css') }}" rel="stylesheet" type="text/css" />
    <script type="text/javascript"  src="{{ asset('js/jquery.min.js') }}"></script>
    <!--弹窗菜单-->
    <link href="{{ asset('css/admin/jBox/Skins/Default/jbox.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('js/jBox/jquery.jBox-2.3.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jBox/i18n/jquery.jBox-zh-CN.js') }}" type="text/javascript"></script>
    <!--弹窗菜单-->
</head>
<body>
    @yield('content')
    <div class="Content_foot">
        <div class="Content_bottom"><a href="#">使用前必读</a> 粤ICP证030173号</div>
    </div>
</body>
</html>
