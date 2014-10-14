
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--link href="{{ asset('css/admin/welcome.css') }}" rel="stylesheet" type="text/css" /-->
</head>
<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%"  style="margin-top:15%;">
  <tr>
    <td align="center"><img src="{{ asset('images/admin/logo.jpg') }}" width="352" height="102" /><br /></td>
  </tr>
  <tr>
    @if( Sentry::check() )
    <td align="center" style="height:70px; line-height:70px; padding-top:20px; font-size:28px;">管理员：<span style="color:#C00">{{ Sentry::getUser()->username }}</span></td>
    @endif
  </tr>
  <tr>
    <td align="center" style="height:80px; line-height:80px; font-size:40px;">欢迎使用游戏商店后台系统</td>
  </tr>
</table>


</body>
</html>