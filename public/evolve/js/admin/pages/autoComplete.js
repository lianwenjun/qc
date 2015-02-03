

$(function(){


// 自动匹配
    $.fn.select2Remote = function(options) {  
        var opts = $.extend({},$.fn.select2Remote.defaults, options);  
        this.select2({ 
            allowClear: true,
            minimumInputLength:opts.minLength, 
            ajax: {  
                url: opts.url,  
                dataType: 'json',  
                quietMillis: opts.delay ,  
                data: function (term, page) {
                    return {q: term};
                },  
                results: function (data, page) { 
                    if (data.success == "true"){
                        return { results: data.data.suggestions };
                    } else {
                        alert('加载失败！');
                    }   
                },
                cache: true  
            }, 
            formatResult: function(medata){
                return medata.value;
            },  
            formatSelection:function(medata){
                $('.jq-searchTagId').val(medata.key);
                return medata.value;
            },
            escapeMarkup: function (m) { 
                return m; 
            }  
        });  
    }  
           
    $.fn.select2Remote.defaults = {  
        minLength: 1,  
        url: '',   
        delay: 250
    }  

    $('.jq-searchTag').select2Remote({  
        url: '/evolve-ui/js/pages/autoComplete.json'
    });

    $('.jq-searchGameName').select2Remote({  
        url: '/evolve-ui/js/pages/autoComplete.json'
    });

    // 游戏关键字（select2）
    $('.jq-keyword').select2({
        tags: ["我叫MT online"],
        minimumInputLength: 1,
        maximumInputLength: 10,
        tokenSeparators: [",", " "],
        ajax: {  
            url: '/evolve-ui/js/pages/autoComplete.json',  
            dataType: 'json',  
            quietMillis: 250,  
            data: function (term, page) {
                return {q: term};
            },  
            results: function (data, page) { 
                if (data.success == "true"){
                    return { results: data.data.suggestions };
                } else {
                    alert('加载失败！');
                }   
            },
            cache: true  
        }, 
        formatResult: function(medata){
            return medata.value;
        },  
        formatSelection:function(medata){
            $('.jq-searchTagId').val(medata.key);
            return medata.value;
        },
        escapeMarkup: function (m) { 
            return m; 
        }
    });


});