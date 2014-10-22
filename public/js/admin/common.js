$(function() {

    /**
     * 通用删除记录
     *
     * 使用例子 <a href="{{ URL::route('apps.delete', $app['id']) }}" class="Search_del jq-delete">删除</a>
     *
     */
    $('.jq-delete').live('click', function() {
        var $this = $(this);
        var link = $(this).attr('href');
        $.jBox("<p style='margin: 10px'>您要删除吗？</p>", {
            title: "<div class='ask_title'>是否删除？</div>",
            showIcon: false,
            draggable: false,
            buttons: {'确定':true, "算了": false},
            submit: function(v, h, f) {
                if(v) {
                    var f = document.createElement('form');
                    $this.after($(f).attr({
                        method: 'post',
                        action: link
                    }).append('<input type="hidden" name="_method" value="DELETE" />'));
                    $(f).submit();
                }
            }
        });

        return false;
    });

    // 游戏预览
    $(".jq-preview").click(function () {

        var id = $(this).attr('data-id');
        var url = PREVIEW_URL.replace('%7Bid%7D', id);

        var type = $(this).attr('data-type');

        console.log(type);

        $.ajax({
            url: url,
            type: 'get',
            dataType: 'json',
            data:{type:type},
            success: function(data) {
                if(data.success) {
                    renderPreview('preview', data.data);
                    $(".jq-previewWindow, .Browse").show();
                    $(".Browse_centent").animate({
                      scrollTop: 0
                    }, 300);
                } else {
                    alert('拉取游戏信息失败');
                }
            },
            error: function() {
                alert('获取预览数据失败');
            }
        });
    });

});

/**
 * 初始化分页
 *
 * @param page     int 当前页数
 * @param pagesize int 总页数
 * @param total    int 记录数
 *
 * return void
 */
function pageInit(page, pagesize, total)
{
    $("#pager").pager({
        pagenumber: page,
        pagecount:pagesize,
        totalcount:total,
        buttonClickCallback: goPage
    });
}

/**
 * 跳转页面
 * @param page
 *
 * return void
 */
function goPage(page)
{
    var url = $(location).attr('href');
    var sp = '?';
    if(/\?/.test(url)) sp = '&';
    var jumpUrl = url.replace(/&page=\d+/, "") + sp +'page=' + page;

    location.href = jumpUrl;
}

// 初始化预览的图片切换
function initCarousel()
{

    if(! initOwl ) {
        $('.owl-carousel').owlCarousel({
            items:2,
            loop:false,
            margin:10,
            lazyLoad : false,
        });

        initOwl = true;

    } else {
        initOwl = false;
        $('.owl-carousel').data('owlCarousel').reinit({
            items: 2
        });

        initOwl = true;
    }
}

// 关闭预览
function closePreview()
{
    $(".jq-previewWindow, .Browse").hide();
}

/**
 * 渲染ajax返回数据
 *
 * PS: 这个渲染可以重写成一个类库备用
 *
 * @param prefix class前缀
 * @param data   ajax返回数据
 *
 * @return void
 */
function renderPreview(prefix, data)
{
    for(i in data) {
        // 匹配以prefix-field开头的dom
        var $this = $('[class^="'+prefix+'-' + i + '"]');

        // 如果dom存在开始渲染
        if(typeof($this.attr('class')) != 'undefined') {
            var className = $this.attr('class');
            var regexp = new RegExp(prefix+"-\\w+-\\w+", "gi");

            var matches = className.match(regexp);
            var dom = matches[0].replace(prefix+'-'+i+'-', '');

            if(dom == 'html') {
                $this.html('');
                $this.html(data[i]);
            } else if(dom == 'src') {
                var template = $this.attr('data-template');
                if(typeof template !== typeof undefined && template !== false) {
                    $this.attr('src', $this.attr('data-template').replace('{val}', data[i]));
                } else {
                    $this.attr('src', data[i]);
                }
            } else if(dom == 'loop') {
                var template = $this.attr('data-template');
                $this.html('');
                if(typeof template !== typeof undefined && template !== false) {
                    var fieldStr = $this.attr('data-fields');
                    if(typeof fieldStr !== typeof undefined && fieldStr !== false) {

                        var fields = eval(fieldStr);

                        for(idx in data[i]) {
                            html = $this.attr('data-template');
                            for(fi in fields) {
                                html = html.replace('{'+fields[fi]+'}', data[i][idx][fields[fi]]);
                            }
                            
                            $this.append(html);
                        }

                    } else {
                        for(idx in data[i]) {
                            $this.append($this.attr('data-template').replace('{val}', data[i][idx]));
                        }
                    }
                }
            }
        }
    }

    initCarousel();

}
//返回消息弹窗,
// @params text
function returnMsgBox(text) {
    $.jBox("<p style='margin: 10px'>"+text+"</p>", {
            title: "<div class='ask_title'>返回结果</div>",
            showIcon: false,
            draggable: false,
    });
};