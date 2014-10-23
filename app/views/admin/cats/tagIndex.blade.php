@extends('admin.layout')

@section('content')       
<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>系统管理 <span> 游戏标签管理</span></h1></div>
    <div class="Theme_Search">
        <ul>
            <li>
                <span><b>标签名称：</b>
                    <input name="addTag" maxlength="16" type="text" class="Search_wenben" size="20" value="" placeholder="请输入标签名称" /></span>
                <span>
                    <b>游戏分类：</b>
                    <select name="cats1">
                        <!--option>--全部--</option!-->
                        @foreach ($cats as $index => $value )
                            <option value="{{ $index }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </span>
                @if(Sentry::getUser() ? Sentry::getUser()->hasAccess('tag.create') : '')
                <input type="submit" value="添加" class="Search_en jq-submitAdd" />
                @endif
            </li>
            <li>
                <span>
                    <b>查询：</b>
                    <select name="cats2">
                        @foreach ($cats as $index => $value)
                            <option value="{{ $index }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </span>
                <span>
                    <input maxlength="16" name="searchTag" type="text" class="Search_wenben" size="20" value="" placeholder="输入关键字" />
                </span>
                <input name="" type="submit" value="搜索" class="Search_en jq-submitSearch" />
            </li>       
        </ul>
    </div>
    <div class="Search_cunt">共 <strong>{{ $tags->getTotal() }}</strong> 条记录 </div>     
    <div class="Search_biao">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="Search_biao_title">
                <td width="5%">ID</td>
                <td width="15%">标签名称</td>
                <td width="10%">所属游戏分类</td>
                <td width="10%">搜索量</td>
                <td width="10%">排序</td>
                <td width="15%">最后更新时间</td>
                <td width="10%">操作</td>
            </tr>
            @forelse($tags as $tag)
                @if (isset($cats[$tag->parent_id]))
                    <tr class="jq-tr">
                        <td>{{ $tag->id }}</td>
                        <td>{{ $tag->title }}</td>
                        <td>{{ isset($cats[$tag->parent_id]) ? $cats[$tag->parent_id]: 0}}</td>
                        <td>{{ $tag->search_total }}</td>
                        <td>{{ $tag->sort }}</td>
                        <td>{{ $tag->updated_at }}</td>
                        <td>
                            @if(Sentry::getUser() ? Sentry::getUser()->hasAccess('tag.edit') : '')
                            <a href="javascript:;" class="Search_show jq-editTag">编辑</a>
                            @endif
                            @if(Sentry::getUser() ? Sentry::getUser()->hasAccess('tag.delete') : '')
                            <a href="{{ route('tag.delete', $tag->id) }}" class="Search_del jq-delete">删除</a>
                            @endif
                        </td>
                        <td style="display:none">
                            <input id="edit-url" value="{{ route('tag.edit', $tag->id) }}" type="hidden"/>
                            <input id="del-url" value="{{ route('tag.delete', $tag->id) }}" type="hidden"/>
                            <input id="preTag" value="{{ $tag->title }}" type="hidden"/>
                            <input id="preSort" value="{{ $tag->sort }}" type="hidden"/>
                        </td>
                    </tr>
                @endif
            @empty
                <tr class="no-data">
                    <td colspan="9">没数据</td>
                <tr>
            @endforelse
        </table>
        @if($tags->getLastPage() > 1)
            <div id="pager"></div>
        @endif
    </div>   
</div>
<script type="text/javascript" src="{{ asset('js/jquery.pager.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/common.js') }}"></script>
<script>
$(function(){
    $(".jq-tr:odd").addClass("Search_biao_two");
    $(".jq-tr:even").addClass("Search_biao_one");
    //分页
    pageInit({{ $tags->getCurrentPage() }}, {{ $tags->getLastPage() }}, {{ $tags->getTotal() }});

    $("input[name=addTag]").focus(function() {
        $(this).val("");
    });
    $("input[name=searchTag]").focus(function() {
        $(this).val("");
    });
    //提交添加
    $(".jq-submitAdd").click(function() {
        // 添加关键词
        var word = $("input[name=addTag]").val();
        if (word === "请输入标签名称" || word == "") {
            $("input[name=addTag]").val("请输入标签名称");
            return;
        }
        var parent_id = $("select[name=cats1]").val();
        if (parent_id == '--全部--' || parent_id == '' || parent_id == undefined){
            return;
        }
        var url = "{{ route('tag.create') }}";
        var data = {word:word, parent_id:parent_id};
        // 发送数据
        $.post(url, data, function(res) {
            //错误判断
            if (res.status != 'ok') {
                returnMsgBox('添加' + word + '失败');
                return;
            }
            //成功返回刷新页面
            window.location.href = window.location.pathname;
        }).fail(function() {
            returnMsgBox('亲，服务器出错啦');
        });
    });
    //提交查询
    $(".jq-submitSearch").click(function() {
        var word = $("input[name=searchTag]").val();
        if (word == "") {
            $("input[name=searchTag]").val("");
        }
        var parent_id = $("select[name=cats2]").val();
        var query = '?word=' + word;;
        if (parent_id != '' && parent_id != undefined){
            query = query + '&parent_id=' + parent_id;;
        }
        var url = window.location.pathname + query;
        window.location.href = url;
    });
    //修改
    $(".jq-editTag").live('click', function() {
        var td = $(this).parents('tr').children('td');
        var text1 = td.eq(1).html();
        var text4 = td.eq(4).html();
        var to_text1 = '<input name="textfield" type="text" id="textfield" value="" size="8" class="Classification_text" />';
        var to_text4 = '<input name="textfield" type="text" id="textfield" value="" size="8" class="Classification_text" />';
        var to_text8 = '<a href="javacript:;" class="Search_show jq-saveTag">确定</a> <a href="javacript:;" class="Search_show jq-chanceTag">取消</a>';
        td.eq(1).html(to_text1);
        td.eq(1).find('#textfield').val(text1);
        td.eq(4).html(to_text4);
        td.eq(4).find('#textfield').val(text4);
        $(this).parent().html(to_text8);
    });
    //提交
    $(".jq-saveTag").live('click', function() {
        var td = $(this).parents('tr').children('td');
        var text1 = td.eq(1).find('input').val();
        var text4 = td.eq(4).find('input').val();
        var editUrl = td.eq(7).find('#edit-url').val();
        var delUrl = td.eq(7).find('#del-url').val();
        var data = {word:text1, sort:text4};
        $.post(editUrl, data, function(res) {
            //错误判断
            if (res.status == 'ok') {
                var text6 = '<a href="javascript:;" class="Search_show jq-editTag">编辑</a> '+
                '<a href="'+delUrl+'" class="Search_del jq-delete">删除</a>';
                td.eq(6).html(text6);
                td.eq(1).html(text1);
                td.eq(4).html(text4);
                return;
            }
            returnMsgBox(res.msg);
            return;
        }).fail(function() {
            returnMsgBox('亲，服务器出错啦');
        });
    });
    //取消
    $(".jq-chanceTag").live('click', function() {
        var td = $(this).parents('tr').children('td');
        var text1 = td.eq(7).find('#preTag').val();
        var text4 = td.eq(7).find('#preSort').val();
        var delUrl = td.eq(7).find('#del-url').val();
        var text6 = '<a href="javascript:;" class="Search_show jq-editTag">编辑</a> <a href="'+delUrl+'" class="Search_del jq-delete">删除</a>';
        $(this).parent().html(text6);
        td.eq(1).html(text1);
        td.eq(4).html(text4);
    });
});
</script>
@stop
