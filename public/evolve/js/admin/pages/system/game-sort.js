
$(function(){

   var cat = '<li class="list">' +
                '<div class="sort-left"><img class="icon25" src="${icon}" alt="分类图标" /><div>${name}</div></div>' +
                '<ul class="sort-right jq-ptags">' +
                '</ul>' +
             '</li>';
    var tags = '<li class="elimit5em" title="${name}">${name}</li>';
    $.template("catTemplate", cat);
    $.template("tagsTemplate", tags);

    // 手机预览弹窗
    $('.jq-preview').click(function(){

        $.ajax({
            type: "GET",
            url: "/evolve-ui/js/pages/system/game-sort.json",
            dataType: "json",
            success: function(data){
                if(data.success == "true"){
                    $('.jq-previewModal').show(); 
                    var datas = data.data;
                    for (i in datas){
                        $.tmpl("catTemplate", datas[i]).appendTo('.jq-pcat');
                        for (j in datas[i].tags){
                            if (j > 3){
                                break;
                            }
                            var index = $('.jq-ptags').eq(i);
                            $.tmpl("tagsTemplate", datas[i].tags[j]).appendTo(index);
                        }
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
       $('.jq-pcat').html('');
    });

});