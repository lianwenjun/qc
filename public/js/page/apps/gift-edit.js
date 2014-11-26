
$(function(){

    alert('111');
    //开始时间与结束时间
    $('.jq-startime').datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'hh: mm: ss',
        onClose: function( selectedDate ) {
        $( ".jq-endtime" ).datepicker( "option", "minDate", selectedDate );
      }
    });

    $('.jq-endtime').datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'hh: mm: ss',
        onClose: function( selectedDate ) {
        $( ".jq-startime" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
    

});