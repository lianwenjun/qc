
$(function(){

    var giftTitle = '<h4 class="lh150 mb5">游戏礼包<i class="icon-arrow-right fr green2"></i></h4>';
    var gifts =  '<li><span class="elimit12em" title="${name}">${name}</span><button class="phone-button fr">领取</button></li>';
    var same  =  '<li><img class="icon50" src="${icon}" alt="图标" /><a href="javascript:;" title="${name}" class="elimit6em">${name}</a></li>';
    $.template("giftsTemplate", gifts);
    $.template("sameTemplate", same);

    // 手机预览弹窗
    $('.jq-preview').click(function(){

        var id = $(this).parent('tr').children('td:first').text();            
        $.ajax({
            type: "GET", 
            url: "/evolve-ui/js/pages/apps/phone-preview.json",
            dataType: "json",
            data: { "id": id },
            success: function(data)
            {   
                if(data.success == "true"){
                    $('.jq-previewModal').show();
                    var datas = data.data;
                    $('.jq-ptitle').text(datas.name);
                    $('.jq-picon').attr("src", datas.icon);
                    $('.jq-pcat').text("分类：" + datas.cat); 
                    $('.jq-psize').text("大小：" + datas.size); 
                    $('.jq-pversion').text("版本：" + datas.version); 
                    $('.jq-pdate').text("更新时间：" + datas["updated_at"]); 
                    $('.jq-pcomment').text("小编点评：" + datas["editor_comment"]);              
                    $('.jq-pgifts').append(giftTitle);
                    $('.jq-pscore').css('width', datas.score*20 + "%");
                    for (i in datas.gifts) {
                        $.tmpl("giftsTemplate", datas.gifts[i]).appendTo(".jq-pgifts");
                    }
                    for (i in datas.imgs) {
                        $('.jq-carousel img').eq(i).attr("src", datas.imgs[i]);
                    }
                    for (i in datas["same_author_games"]) {
                        $.tmpl("sameTemplate", datas["same_author_games"][i]).appendTo(".jq-psameAuthor");
                    }
                    for (i in datas["same_cat_games"]) {
                        $.tmpl("sameTemplate", datas["same_cat_games"][i]).appendTo(".jq-psameCat");
                    }
                }else{
                    alert(data.msg);                    
                }
            },
            error: function() {
                alert('加载数据错误!');
            }
        });

    });

    $('.jq-exit').click(function(){
        $('.jq-previewModal').hide();
        $('.jq-psameAuthor, .jq-psameCat, .jq-pgifts').html('');
    });

    // 手机预览弹窗--旋转木马效果
    $('.jq-carousel').owlCarousel({
        items : 2  
    });

});