
$(function(){
 
    // 左侧菜单标题点击事件
    $('.jq-menu h3').click(function(){       
        $(this).toggleClass('current').parent().siblings().children("h3").removeClass('current');
        $(this).next('ul').slideToggle().parent().siblings().children("ul").slideUp();
    });

    $('.jq-menu h3').hover(function(){ 
        $(this).animate({paddingRight: '+=10px'}, 200);
    }, function(){
        $(this).animate({paddingRight: '-=10px'}, 200);
    });


    // 左侧菜单列表点击事件
    $('.jq-menu li').click(function(){
        $('.jq-menu li').css('color','#fff');
        $(this).css('color','#dfdf0b');
    });


    // 排序图标切换状态
    $('.jq-sort').click(function(){
        $('.jq-sort i').addClass('icon-menu2');
        $(this).children('i').removeClass('icon-menu2').toggleClass('icon-arrow-up');
        var i = $(this).children('i').attr("class");
        if (i == "icon-arrow-down"){
            window.location.href = $(this).data("desc-url");
        }else if (i == "icon-arrow-down icon-arrow-up"){
            window.location.href = $(this).data("asc-url");
        }
    });
    
    // 刷新页面后图标排序
    $(".jq-sort[data-sort='desc']").children('i').removeClass('icon-menu2 icon-arrow-up');
    $(".jq-sort[data-sort='asc']").children('i').removeClass('icon-menu2');


    // 信息类弹窗通用函数
    function alertDialog(selector, msg, width, height) {
        var w = width || 300;
        var h = height || 150;
        var alertdiv = $("<div title='信息'></div>").appendTo($("BODY"));
        var content = alertdiv.html(msg);
        alertdiv.dialog({
            autoOpen: true,
            height: h,
            width: w,
            modal: true,
            close: function (evt, ui) {
                alertdiv.dialog("destroy");
                alertdiv.html("").remove();
            },
            buttons:
            {
                "确定": function() {   
                    window.location.href = selector.data('url');             
                    alertdiv.dialog("close");
                },
                "取消": function() {
                    alertdiv.dialog( "close" );
                }
            }
        });
    }

    // 下载弹窗
    $('.jq-download').click(function() {         
        alertDialog($(this), "确定要下载此应用？");             
    });

    // 下架弹窗
    $('.jq-unstock').click(function() {         
        alertDialog($(this), "确定要下架吗？");               
    });

    // 删除弹窗
    $('.jq-delete').click(function() {         
        alertDialog($(this), "确定要删除吗？");               
    });

    // 通过弹窗
    $('.jq-pass').click(function() {         
        alertDialog($(this), "确定要通过吗？");               
    });
   

    // 编辑类弹窗通用函数
    function editDialog(selector, form, height, width) {
        var w = width || 430;
        var h = height || 250;
        var content = selector;
        selector.dialog({
            autoOpen: true,
            height: h,
            width: w,
            modal: true,
            buttons:
            {
                "确定": function() {
                    form.submit();
                },
                "取消": function() {
                    selector.dialog( "close" );
                }
            }
        });
    }

    // 分类页图片管理编辑弹窗
    $('.jq-sort').click(function(){
        editDialog($('.jq-sortModal'), $('.jq-sortForm'), 220);
    });

    // 新增启动页弹窗
    $('.jq-addLaunch').click(function(){
        $('.jq-launchName').val('');
        editDialog($('.jq-launchModal'), $('.jq-launchForm'), 650, 470);
    });

    // 新增分类弹窗
    $('.jq-addCate').click(function(){ 
        editDialog($('.jq-addCateModal'), $('.jq-addCateForm'), 310);             
    });

    // 添加供应商弹窗
    $('.jq-addSupplier').click(function(){  
        editDialog($('.jq-addSupplierModal'), $('.jq-addSupplierForm'));             
    });

    // 添加渠道商弹窗
    $('.jq-addChannel').click(function(){  
        editDialog($('.jq-addChannelModal'), $('.jq-addChannelForm'));             
    });

    // 添加关键字弹窗
    $('.jq-addKey').click(function(){  
        editDialog($('.jq-addKeyModal'), $('.jq-addKeyForm'), 190);             
    });


    // 点击按钮组中按钮，显示下拉面板
    $('.jq-btnGroup').click(function(){
        $(this).next('ul').show();
    });

    // 点击下拉面板中确定按钮，隐藏面板
    $('.jq-panelBtn').click(function(){
        $(this).parent('ul').hide();
        var val = $(this).siblings().find(':checked').val();
        $(this).parent('ul').prev('span').text(val);
    });

    
    // 格式化日期
    Date.prototype.Format = function (fmt) {
        var o = {
            "M+": this.getMonth() + 1, //月份 
            "D+": this.getDate(), //日 
            "h+": this.getHours(), //小时 
            "m+": this.getMinutes(), //分 
            "s+": this.getSeconds() //秒
        };
        if (/(Y+)/.test(fmt)) {
            fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
        }
        for (var k in o) {
            if (new RegExp("(" + k + ")").test(fmt)) {
                fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) 
                    ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
            }
        }
        return fmt;
    }

});