
$(function(){

    // 图表
    var barOptions = {
        responsive: true,
        barValueSpacing: 50,
        scaleOverride: true,
        scaleSteps: 8,
        scaleStepWidth: 5000
    }
    var barData = {
        labels : ["1-2","3-5","6-9","10-29","30-99","100+"],
        datasets : [
            {
                fillColor : "rgba(151,187,205,0.5)",
                strokeColor : "rgba(151,187,205,1)",
                data : [5000,20000,8000,25000,18000,10000,20000]
            }
        ]
    }
    var ctx = $(".jq-barChart").get(0).getContext("2d");
    var barChart = new Chart(ctx);
    barChart.Bar(barData, barOptions);

    var width = $('.jq-barChart').attr('width');
    $('.jq-barChart').css('width', width-40);
});
