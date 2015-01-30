
// 时间/日期（精确到秒）
// 引用页面： apps/gift-edit.html; ads/gift-edit.html; ads/edit.html

$(function() {

    // 开始时间与结束时间
    $('.jq-startime').datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH: mm: ss',
        onClose: function( selectedDate ) {
        $( ".jq-endtime" ).datepicker( "option", "minDate", selectedDate );
      }
    });

    $('.jq-endtime').datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'HH: mm: ss',
        onClose: function( selectedDate ) {
        $( ".jq-startime" ).datepicker( "option", "maxDate", selectedDate );
      }
    });

});