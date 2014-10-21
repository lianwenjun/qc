@extends('admin.layout')

@section('content') 
<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>系统管理 <span> 游戏评分列表</span></h1></div>
    <form action="{{ URL::route('rating.index') }}" method="get">        
        <div class="Theme_Search">
            <ul>
                <li>
                    <span><b>查询：</b>
                        <select name="cate">
                            <option value="title">游戏名称</option>
                            <option value="pack">包名</option>
                        </select>
                    </span>
                    <span>
                        <input name="word" type="text" class="Search_wenben" size="20" maxlength="10" value="" placeholder="输入关键字"/>
                    </span>
                    <input type="submit" value="搜索" class="Search_en" />
                </li>
                   
              </ul>
        </div>
    </form>             
    <div class="Search_cunt">共 <strong>{{ $ratings->getTotal() }}</strong> 条记录 </div>
                     
    <div class="Search_biao">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="Search_biao_title">
                <td width="4%">ID</td>
                <td width="8%">游戏名称</td>
                <td width="12%">包名</td>
                <td width="8%">游戏总分</td>
                <td width="8%">评分次数</td>
                <td width="10%">游戏平均分</td>
                <td width="10%">干扰后分值</td>
                <td width="10%">操作</td>
            </tr>
            @forelse($ratings as $rating)
                <tr class="jq-tr">
                    <td>{{ $rating->id }}</td>
                    <td>{{ $rating->title }}</td>
                    <td>{{ $rating->pack }}</td>
                    <td>{{ $rating->total }}</td>
                    <td>{{ $rating->counts }}</td>
                    <td>{{ $rating->avg }}</td>
                    <td>{{ $rating->manual }}</td>
                    <td><a href="javascript:;" class="Search_show jq-editWord">修改</a></td>
                    <td style="display:none">
                        <input id="edit-url" value="{{ route('rating.edit', $rating->id) }}" type="hidden"/>
                        <input id="preWord" value="{{ $rating->manual }}" type="hidden"/>
                    </td>
                </tr>
            @empty
                <tr class="no-data">
                    <td colspan="9">没数据</td>
                <tr>
            @endforelse
        </table>
        @if($ratings->getLastPage() > 1)
            <div id="pager"></div>
        @endif
    </div>                               
</div>
<script type="text/javascript" src="{{ asset('js/jquery.pager.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/common.js') }}"></script>

<script>
$(function(){
    CREATEURL = "{{ route('stopword.create') }}";
    $(".jq-tr:odd").addClass("Search_biao_two");
    $(".jq-tr:even").addClass("Search_biao_one");
    //分页
    pageInit({{ $ratings->getCurrentPage() }}, {{ $ratings->getLastPage() }}, {{ $ratings->getTotal() }});

    $("input[name=word]").focus(function() {
        $(this).val("");
    });
    //修改
    $(".jq-editWord").live('click', function() {
        var td = $(this).parents('tr').children('td');
        var text6 = td.eq(6).html();
        var to_text1 = '<input name="textfield" type="text" id="textfield" value="" size="8" class="Classification_text jq-edit-input" />';
        var to_text7 = '<a href="javacript:;" class="Search_show jq-saveWord">确定</a> <a href="javacript:;" class="Search_show jq-chanceWord">取消</a>';
        td.eq(6).html(to_text1);
        td.eq(6).find('#textfield').val(text6);
        $(this).parent().html(to_text7);
    });
    //输入强制
    $(".jq-edit-input").live('keyup', function(){    
            $(this).val($(this).val().replace(/[^0-9.]/g,''));    
        }).bind("paste",function(){  //CTR+V事件处理    
            $(this).val($(this).val().replace(/[^0-9.]/g,''));     
        }).css("ime-mode", "disabled"); //CSS设置输入法不可用    
    //提交
    $(".jq-saveWord").live('click', function() {
        //alert('点击保存');
        var td = $(this).parents('tr').children('td');
        var text6 = td.eq(6).find('input').val();
        if (isNaN(text6) || parseInt(text6) < 1 || parseInt(text6) > 5){
            alert("请输入大于1小于5的数字");
            return;
        }
        var editUrl = td.find('#edit-url').val();
        var data = {manual:text6};
        $.post(editUrl, data, function(res) {
            //错误判断
            if (res.status == 'ok') {
                var text8 = '<a href="javacript:;" class="Search_show jq-editWord">修改</a>'
                td.eq(7).html(text8);
                td.eq(6).html(text6);
                return;
            }
            return;
        }).fail(function() {
            alert('亲，服务器出错啦');
        });
    });
    //取消
    $(".jq-chanceWord").live('click', function() {
        var td = $(this).parents('tr').children('td');
        var text1 = td.find('#preWord').val();
        var text8 = '<a href="javacript:;" class="Search_show jq-editWord">修改</a> '
        $(this).parent().html(text8);
        td.eq(6).html(text1);
    });
});
</script>
@stop