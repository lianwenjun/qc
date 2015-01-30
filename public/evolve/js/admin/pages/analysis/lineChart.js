
$(function(){

    // 线性图表
    var lineOptions = {
        responsive: true,
        bezierCurve : false,
        datasetFill : false
    }
    var lineData = {
        labels : ["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],
        datasets : [
            {
                fillColor : "rgba(220,220,220,0.5)",
                strokeColor : "rgba(220,220,220,1)",
                pointColor : "rgba(220,220,220,1)",
                pointStrokeColor : "#fff",
                data : [65,59,90,81,56,55,40,57,64,41,35,66]
            },
            {
                fillColor : "rgba(151,187,205,0.5)",
                strokeColor : "rgba(151,187,205,1)",
                pointColor : "rgba(151,187,205,1)",
                pointStrokeColor : "#fff",
                data : [28,48,40,19,96,27,100,68,49,35,27,87]
            },
            {
                fillColor : "rgba(237,112,84,0.5)",
                strokeColor : "rgba(237,112,84,1)",
                pointColor : "rgba(237,112,84,1)",
                pointStrokeColor : "#fff",
                data : [58,28,60,39,26,47,30,48,79,85,107,57]
            }
        ]
    }
    var ctx = $(".jq-lineChart").get(0).getContext("2d");
    var lineChart = new Chart(ctx);
    lineChart.Line(lineData, lineOptions);
    
    var width = $('.jq-lineChart').attr('width');
    $('.jq-lineChart').css('width', width-40);

});