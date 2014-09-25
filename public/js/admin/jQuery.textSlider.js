/**
 * @author feiwen
 */
(function ($) {
    $.fn.textSlider = function (settings) {
        settings = jQuery.extend({
            speed: "normal",
            line: 0,
            timer: 1000
        }, settings);
        return this.each(function () {
            $.fn.textSlider.scllor($(this), settings);
        });
    };
    $.fn.textSlider.scllor = function ($this, settings) {
        var ul = $("ul:eq(0)", $this);
        var count = ul.find("li").length;
        /*添加空白li，用于区分最后页*/
        var currentCount = parseInt(count / 11);
        var eachCount = ((currentCount + 1) * 11) - count;
        var timerID;
        var li = ul.children();
        for (var i = 0; i < eachCount; i++) {
            $(".scrollText>ul").append("<li class='scrollText_White'></li>");
        }
        /*添加空白li*/
        var _btnUp = $(".up:eq(0)", $this);
        var _btnDown = $(".down:eq(0)", $this);
        var liHight = $(li[0]).height();
        var upHeight = 0 - (settings.line * liHight); //滚动的高度；
        var scrollUp = function () {
            _btnUp.unbind("click", scrollUp);
            if (ul.find("li").length > 10) {
                ul.animate({ marginTop: upHeight }, settings.speed, function () {
                    for (i = 0; i < settings.line; i++) {
                        //$(li[i]).appendTo(ul);
                        ul.find("li:first").appendTo(ul);
                    }
                    ul.css({ marginTop: 0 });
                    _btnUp.bind("click", scrollUp); //Shawphy:绑定向上按钮的点击事件
                });
            }
        };
        var scrollDown = function () {
            _btnDown.unbind("click", scrollDown);
            if (ul.find("li").length > 10) {
                ul.css({ marginTop: upHeight });
                for (i = 0; i < settings.line; i++) {
                    ul.find("li:last").prependTo(ul);
                }
                ul.animate({ marginTop: 0 }, settings.speed, function () {
                    _btnDown.bind("click", scrollDown); //Shawphy:绑定向上按钮的点击事件
                });
            }
        };
        var autoPlay = function () {
            //timerID = window.setInterval(scrollUp,settings.timer);
            //alert(settings.timer);
        };
        var autoStop = function () {
            window.clearInterval(timerID);
        };
        //事件绑定
        ul.hover(autoStop, autoPlay).mouseout();
        _btnUp.css("cursor", "pointer").click(scrollUp);
        _btnUp.hover(autoStop, autoPlay);
        _btnDown.css("cursor", "pointer").click(scrollDown);
        _btnDown.hover(autoStop, autoPlay)
    };
})(jQuery);