$(function(){

    // 日期面板下拉选项
    $('.jq-dateRange input').focus(function(){
        $('.jq-dateList').show();
    });

    $('.jq-dateList li').click(function(){
        $('.jq-dateList').hide();
    });

    var date = new Date();
    var today = new Date().Format("YYYY-MM-DD");
    var week = new Date((+date)-7*24*3600*1000).Format("YYYY-MM-DD");
    var month = new Date((+date)-30*24*3600*1000).Format("YYYY-MM-DD");

    // 今天
    $('.jq-today').click(function(){   
        $('.jq-dateRange input').val(today);   
    });

    // 过去7天
    $('.jq-week').click(function(){
        $('.jq-dateRange input').val(today +'—'+ week);
    });

    // 过去30天
    $('.jq-month').click(function(){
        $('.jq-dateRange input').val(today +'—'+ month);
    });

});