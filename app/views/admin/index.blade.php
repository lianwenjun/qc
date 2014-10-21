<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript"  src="{{ asset('js/jquery.min.js') }}"></script>
<style type="text/css">
html{background:#f0f0f0;}
</style>
<script>

$(function() {
    $('#BoardRight').load(function(){
        var currentUrl = frames['BoardRight'].document.location.href;

        var match = false;
        $(frames['BoardLeft'].document).find('.mail_hover').find('.sub-menu > li > a').each(function() {
            if($(this).attr('href') == currentUrl) {
                match = true;
            }
        });

        $(frames['BoardLeft'].document).find('.mail_hover').find('.sub-menu > li > a').each(function() {
            if($(this).attr('href') == currentUrl) {
                $(this).parent().addClass('sub-menu_hover');
            } else if(match) {
                $(this).parent().removeClass('sub-menu_hover');
            }
        });

    });
});
</script>
</head>

<frameset border="0" framespacing="0" rows="*" frameborder="0" >
    <frameset cols="247,*">
        <frame name="BoardLeft" id="BoardLeft" src="{{ URL::route('admin.menu') }}" frameBorder="0" scrolling="yes" noResize/>
        <frame name="BoardRight" id="BoardRight"  src="{{ URL::route('admin.welcome') }}" frameBorder="0" noResize scrolling="yes"/>
   </frameset>
</frameset>
</html>
