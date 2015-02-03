/**
 * Select2 Traditional Chinese translation
 */
(function ($) {
    "use strict";
    $.fn.select2.locales['zh-CN'] = {
        formatNoMatches: function () { return "沒有找到相符的项目"; },
        formatInputTooShort: function (input, min) { var n = min - input.length; return "请再輸入" + n + "个字符";},
        formatInputTooLong: function (input, max) { var n = input.length - max; return "請刪掉" + n + "个字符";},
        formatSelectionTooBig: function (limit) { return "你只能选择最多" + limit + "项"; },
        formatLoadMore: function (pageNumber) { return "载入中…"; },
        formatSearching: function () { return "搜索中…"; },
        formatAjaxError: function () { return "加载失败"; }
    };

    $.extend($.fn.select2.defaults, $.fn.select2.locales['zh-CN']);
})(jQuery);
