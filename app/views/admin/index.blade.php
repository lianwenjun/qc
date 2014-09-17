<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
html{background:#f0f0f0;}
</style>
</head>

<frameset border="0" framespacing="0" rows="*" frameborder="0" >
    <frameset cols="247,*">
        <frame name="BoardLeft" id="BoardLeft" src="{{ URL::route('admin.menu') }}" frameBorder="0" scrolling="yes" noResize/>
        <frame name="BoardRight" id="BoardRight"  src="{{ URL::route('admin.welcome') }}" frameBorder="0" noResize scrolling="yes"/>
   </frameset>
</frameset>
</html>
