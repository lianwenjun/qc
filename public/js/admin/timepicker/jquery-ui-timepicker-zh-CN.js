/* Simplified Chinese translation for the jQuery Timepicker Addon /
/ Written by Will Lu */
(function($) {
    $.timepicker.regional['zh-CN'] = {
        timeOnlyTitle: '选择时间',
        timeText: '时间',
        hourText: '小时',
        minuteText: '分',
        secondText: '秒',
        millisecText: '毫秒',
        microsecText: '微秒',
        timezoneText: '时区',
        currentText: '现在时间',
        closeText: '关闭',
        dateFormat: 'yy-mm-dd',
        timeFormat: 'hh:mm:ss',
        amNames: ['AM', 'A'],
        pmNames: ['PM', 'P'],
        dayNames: ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
        dayNamesShort: ['周日', '周一', '周二', '周三', '周四', '周五', '周六'],
        dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
        isRTL: false
    };
    $.timepicker.setDefaults($.timepicker.regional['zh-CN']);
})(jQuery);
