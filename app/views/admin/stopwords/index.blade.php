@extends('admin.layout')

@section('content') 
<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>系统管理 <span> 屏蔽词管理</span></h1></div>
             
    <div class="Theme_Search">
        <ul>
            <li>
                 <span><b>屏蔽添加：</b>
                 <input name="word" maxlength="16" type="text" class="Search_wenben" size="60" value="" placeholder="添加屏蔽词" />
                 </span>
                 <input type="submit" value="添加" class="jq-submitWord Search_en" />
            </li>
               
        </ul>
    </div>
                    
    <div class="Search_cunt">共 <strong>{{ $stopwords->getTotal() }}</strong> 条记录 </div>
                     
    <div class="Search_biao">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="Search_biao_title">
                <td width="4%">ID</td>
                <td width="20%">屏蔽词</td>
                <td width="20%">替换成</td>
                <td width="8%">添加人</td>
                <td width="12%">添加时间</td>
                <td width="9%">最后编辑人</td>
                <td width="12%">最后更新时间</td>
                <td width="12%">操作</td>
            </tr>
            @forelse($stopwords as $stopword)
                <tr class="jq-tr">
                    <td>{{ $stopword->id }}</td>
                    <td>{{ $stopword->word }}</td>
                    <td>{{ $stopword->to_word }}</td>
                    <td>{{ isset($userDatas[$stopword->creator]) ? $userDatas[$stopword->creator] : '' }}</td>
                    <td>{{ $stopword->created_at }}</td>
                    <td>{{ isset($userDatas[$stopword->operator]) ? $userDatas[$stopword->operator] : '' }}</td>
                    <td>{{ $stopword->updated_at }}</td>
                    <td><a href="javascript:;" class="Search_show jq-editWord">修改</a>
                        <a href="{{ URL::route('stopword.delete', $stopword->id) }}" class="Search_del jq-delete">删除</a>
                    </td>
                    <td style="display:none">
                        <input id="edit-url" value="{{ route('stopword.edit', $stopword->id) }}" type="hidden"/>
                        <input id="del-url" value="{{ route('stopword.delete', $stopword->id) }}" type="hidden"/>
                        <input id="preWord" value="{{ $stopword->word }}" type="hidden"/>
                        <input id="preToword" value="{{ $stopword->to_word }}" type="hidden"/>
                    </td>
                </tr>
            @empty
                <tr class="no-data">
                    <td colspan="9">没数据</td>
                <tr>
            @endforelse                  
        </table>
        @if($stopwords->getLastPage() > 1)
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
    pageInit({{ $stopwords->getCurrentPage() }}, {{ $stopwords->getLastPage() }}, {{ $stopwords->getTotal() }});

    $("input[name=word]").focus(function() {
        $(this).val("");
    });

    //提交添加
    $(".jq-submitWord").click(function() {
        var word = $("input[name=word]").val();
        if (word == "" || word == undefined) {
            return;
        }
        // 添加关键词
        var url = CREATEURL;
        var data = {word:word};
        // 发送数据
        $.post(url, data, function(res) {
            //错误判断
            if (res.status != 'ok') {
                returnMsgBox(res.msg);
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
        var word = $("input[name=searchWord]").val();
        if (word === "输入关键字" || word == "") {
            $("input[name=searchWord]").val("输入关键字");
            return;
        }
        // 查询
        var url = window.location.pathname + '?word=' + word;
        window.location.href = url;
    });
    //修改
    $(".jq-editWord").live('click', function() {
        var td = $(this).parents('tr').children('td');
        var text1 = td.eq(1).html();
        var text2 = td.eq(2).html();
        var to_text1 = '<input name="textfield2" type="text" id="textfield2" value="" size="8" class="Classification_text" />';
        var to_text2 = '<input name="textfield2" type="text" id="textfield2" value="" size="8" class="Classification_text" />';
        var to_text8 = '<a href="javacript:;" class="Search_show jq-saveWord">确定</a> <a href="javacript:;" class="Search_show jq-chanceWord">取消</a>';
        td.eq(1).html(to_text1);
        td.eq(1).find('#textfield2').val(text1);
        td.eq(2).html(to_text1);
        td.eq(2).find('#textfield2').val(text2);
        $(this).parent().html(to_text8);
    });
    //提交
    $(".jq-saveWord").live('click', function() {
        //alert('点击保存');
        var td = $(this).parents('tr').children('td');
        var text1 = td.eq(1).find('input').val();
        var text2 = td.eq(2).find('input').val();
        var editUrl = td.find('#edit-url').val();
        var delUrl = td.find('#del-url').val();
        //var is_slide = td.eq().
        var data = {word:text1, to_word:text2};
        $.post(editUrl, data, function(res) {
            //错误判断
            if (res.status == 'ok') {
                var text8 = '<a href="javacript:;" class="Search_show jq-editWord">修改</a>'+
                            '<a href="'+delUrl+'" class="Search_del jq-delWord jq-delete">删除</a>';
                td.eq(7).html(text8);
                td.eq(1).html(text1);
                td.eq(2).html(text2);
                return;
            }
            returnMsgBox(res.msg);
            return;
        }).fail(function() {
            returnMsgBox('亲，服务器出错啦');
        });
    });
    //取消
    $(".jq-chanceWord").live('click', function() {
        var td = $(this).parents('tr').children('td');
        var text1 = td.find('#preWord').val();
        var text2 = td.find('#preToword').val();
        var delUrl = td.find('#del-url').val();
        var text8 = '<a href="javacript:;" class="Search_show jq-editWord">修改</a> ' + 
                    '<a href="'+delUrl+'" class="Search_del jq-delete">删除</a>';
        $(this).parent().html(text8);
        td.eq(1).html(text1);
        td.eq(2).html(text2);
    });
});
</script>
@stop