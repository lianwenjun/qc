$(function() {

    /**
     * 通用删除记录
     *
     * 使用例子 <a href="{{ URL::route('apps.delete', $app['id']) }}" class="Search_del jq-delete">删除</a>
     *
     */
    $('.jq-delete').click(function() {

        var link = $(this).attr('href');
        $.jBox("<p style='margin: 10px'>您要删除吗？</p>", {
            title: "<div class='ask_title'>是否删除？</div>",
            showIcon: false,
            draggable: false,
            buttons: {'确定':true, "算了": false},
            submit: function(v, h, f) {
                if(v) {
                    var f = document.createElement('form');
                    $(this).after($(f).attr({
                        method: 'post',
                        action: link
                    }).append('<input type="hidden" name="_method" value="DELETE" />'));
                    $(f).submit();
                }
            }
        });

        return false;
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
function pageInit(page, pagesize, total){
    $("#pager").pager({ pagenumber: page, pagecount:pagesize,totalcount:total, buttonClickCallback: goPage});
}

/**
 * 跳转页面
 * @param page
 *
 * return void
 */
function goPage(page) {
    var url = $(location).attr('href');
    var sp = '?';
    if(/\?/.test(url)) sp = '&';
    var jumpUrl = url.replace(/&page=\d+/, "") + sp +'page=' + page;

    location.href = jumpUrl;
}