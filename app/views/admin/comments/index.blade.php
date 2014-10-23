@extends('admin.layout')

@section('content')
<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>系统管理 <span> 游戏评论列表</span></h1></div>
    <form action="{{ URL::route('comment.index') }}" method="get">         
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
                        <input maxlength="16" name="word" type="text" class="Search_wenben" size="20" value="" placeholder="输入关键字" />
                    </span>
                    <input type="submit" value="搜索" class="Search_en" />
                </li>
            </ul>
        </div>
    </form>                
    <div class="Search_cunt">共 <strong>{{ $comments->getTotal() }}</strong> 条记录 </div>
                     
    <div class="Search_biao">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="Search_biao_title">
                <td width="4%">ID</td>
                <td width="7%">游戏名称</td>
                <td width="10%">包名</td>
                <td width="13%">iMEI辨识码</td>
                <td width="7%">用户机型</td>
                <td width="7%">用户IP</td>
                <td width="15%">评论内容</td>
                <td width="8%">评论时间</td>
                <td width="5%">评分</td>
                <td width="10%">操作</td>
            </tr>
            @forelse($comments as $comment)
                <tr class="jq-tr">
                    <td>{{ $comment->id }}</td>
                    <td>{{ $comment->title }}</td>
                    <td>{{ $comment->pack }}</td>
                    <td>{{ $comment->imei }}</td>
                    <td>{{ $comment->type }}</td>
                    <td>{{ $comment->ip }}</td>
                    <td>{{ $comment->content }}</td>
                    <td>{{ $comment->created_at }}</td>
                    <td>{{ $comment->rating }}</td>
                    <td>
                        @if(Sentry::getUser()->hasAccess('comment.edit'))
                        <a href="javascript:;" class="Search_show jq-editWord">修改</a>
                        @endif
                        @if(Sentry::getUser()->hasAccess('comment.delete'))
                        <a href="{{ route('comment.delete', $comment->id) }}" class="Search_del jq-delete">删除</a>
                        @endif
                    </td>
                    <td style="display:none">
                        <input id="edit-url" value="{{ route('comment.edit', $comment->id) }}" type="hidden"/>
                        <input id="del-url" value="{{ route('comment.delete', $comment->id) }}" type="hidden"/>
                        <input id="preWord" value="{{ $comment->content }}" type="hidden"/>
                    </td>
                </tr>
            @empty
                <tr class="no-data">
                    <td colspan="9">没数据</td>
                <tr>
            @endforelse
        </table>
        @if($comments->getLastPage() > 1)
            <div id="pager"></div>
        @endif
    </div>            
</div>
<script type="text/javascript" src="{{ asset('js/jquery.pager.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/common.js') }}"></script>
<script>
$(function(){
    $("input[name=word]").focus(function() {
        $(this).val("");
    });
    $(".jq-tr:odd").addClass("Search_biao_two");
    $(".jq-tr:even").addClass("Search_biao_one");
    //分页
    pageInit({{ $comments->getCurrentPage() }}, {{ $comments->getLastPage() }}, {{ $comments->getTotal() }});
    //修改
    $(".jq-editWord").live('click', function() {
        var td = $(this).parents('tr').children('td');
        var text6 = td.eq(6).html();
        var to_text6 = '<input name="textfield2" type="text" id="textfield2" value="" size="8" class="Classification_text" />';
        var to_text9 = '<a href="javacript:;" class="Search_show jq-saveWord">确定</a> <a href="javacript:;" class="Search_show jq-chanceWord">取消</a>';
        td.eq(6).html(to_text6);
        td.eq(6).find('#textfield2').val(text6);
        $(this).parent().html(to_text9);
    });
    //提交
    $(".jq-saveWord").live('click', function() {
        //alert('点击保存');
        var td = $(this).parents('tr').children('td');
        var content = td.eq(6).find('input').val();
        var editUrl = td.find('#edit-url').val();
        var delUrl = td.find('#del-url').val();
        var data = {content:content};
        $.post(editUrl, data, function(res) {
            //错误判断
            if (res.status == 'ok') {
                var text8 = '<a href="javacript:;" class="Search_show jq-editWord">修改</a>'+
                            '<a href="'+delUrl+'" class="Search_del jq-delete">删除</a>';
                td.eq(9).html(text8);
                td.eq(6).html(content);
                return;
            }
            return;
        }).fail(function() {
            returnMsgBox('亲，服务器出错啦');
        });
    });
    //取消
    $(".jq-chanceWord").live('click', function() {
        var td = $(this).parents('tr').children('td');
        var text1 = td.find('#preWord').val();
        var delUrl = td.find('#del-url').val();
        var text8 = '<a href="javacript:;" class="Search_show jq-editWord">修改</a> ' + 
                    '<a href="'+delUrl+'" class="Search_del jq-delete">删除</a>';
        $(this).parent().html(text8);
        td.eq(6).html(text1);
    });
});
</script>
@stop