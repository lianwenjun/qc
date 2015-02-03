
$(function(){

    // 线性图表
    var lineOptions = {
        responsive: true,
        bezierCurve : false,
        datasetFill : false,
        scaleOverride: true,
        scaleSteps: 5,
        scaleStepWidth: 20000
    }
    var lineData = {
        labels : ["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],
        datasets : [
            {
                fillColor : "rgba(151,187,205,0.5)",
                strokeColor : "rgba(151,187,205,1)",
                pointColor : "rgba(151,187,205,1)",
                pointStrokeColor : "#fff",
                data : [25000,18000,35000,42000,39000,17000,50000,40000,35000,27000,40000,15000]
            }
        ]
    }
    var ctx = $(".jq-lineChart").get(0).getContext("2d");
    var lineChart = new Chart(ctx);
    lineChart.Line(lineData, lineOptions);
    
    var width = $('.jq-lineChart').attr('width');
    $('.jq-lineChart').css('width', width-40);

});