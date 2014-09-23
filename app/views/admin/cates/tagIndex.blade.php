@extends('admin.layout')

@section('content')       
<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>系统管理 <span> 游戏标签管理</span></h1></div>
    <div class="Theme_Search">
        <ul>
            <li>
                <span><b>标签名称：</b>
                    <input id="addTag" name="" type="text" class="Search_wenben" size="20" value="请输入标签名称" /></span>
                <span>
                    <b>游戏分类：</b>
                    <select id="cates1" name="cates1">
                        <!--option>--全部--</option!-->
                        @foreach ($cates as $index => $value )
                            <option value="{{ $index }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </span>
                <input id="submitAdd" name="" type="submit" value="添加" class="Search_en" />
            </li>
            <li>
                <span>
                    <b>查询：</b>
                    <select id="cates2" name="cates2">
                        <option>--全部--</option>
                        @foreach ($cates as $index => $value)
                            <option value="{{ $index }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </span>
                <span>
                    <input id="searchTag" name="" type="text" class="Search_wenben" size="20" value="输入关键字" />
                </span>
                <input id="submitSearch" name="" type="submit" value="搜索" class="Search_en" />
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
            @foreach($tags as $tag)
                @if (!isset($cates[$tag->parent_id]))
                    conntinue;
                @endif
                    <tr class="Search_biao_one">
                        <td>{{ $tag->id }}</td>
                        <td>{{ $tag->title }}</td>
                        <td>{{ isset($cates[$tag->parent_id]) ? $cates[$tag->parent_id]: 0}}</td>
                        <td>{{ $tag->search_total }}</td>
                        <td>{{ $tag->sort }}</td>
                        <td>{{ $tag->updated_at }}</td>
                        <td><a href="javascript:;" class="Search_show editTag">编辑</a> <a href="javascript:;" class="Search_del delTag">删除</a></td>
                        <td style="display:none">
                            <input id="edit-url" value="{{ route('tag.update', $tag->id) }}" type="hidden"/>
                            <input id="del-url" value="{{ route('tag.delete', $tag->id) }}" type="hidden"/>
                            <input id="preTag" value="{{ $tag->title }}" type="hidden"/>
                            <input id="preSort" value="{{ $tag->sort }}" type="hidden"/>
                        </td>
                    </tr>
                
            @endforeach
            </table>
        <div id="pager">{{ $tags->links() }}</div>
    </div>   
</div>
<script>
$(function(){
    $("#addTag").focus(function() {
        $(this).val("");
    });
    $("#searchTag").focus(function() {
        $(this).val("");
    });
    //提交添加
    $("#submitAdd").click(function() {
        // 添加关键词
        var word = $("#addTag").val();
        if (word === "请输入标签名称" || word == "") {
            $("#addWord").val("请输入标签名称");
            return;
        }
        var parent_id = $("#cates1").val();
        if (parent_id == '--全部--' || parent_id == '' || parent_id == undefined){
            return;
        }
        var url = "{{ route('tag.store') }}";
        var data = {word:word, parent_id:parent_id};
        // 发送数据
        $.post(url, data, function(res) {
            //错误判断
            if (res.status != 'ok') {
                alert('添加' + word + '失败');
                return;
            }
            //成功返回刷新页面
            window.location.href = window.location.pathname;
        }).fail(function() {
            alert('亲，服务器出错啦');
        });
    });
    //提交查询
    $("#submitSearch").click(function() {
        var word = $("#searchTag").val();
        if (word === "输入关键字" || word == "") {
            $("#searchWord").val("输入关键字");
            return;
        }
        var parent_id = $("#cates2").val();
        var query = '?word=' + word;;
        if ( parent_id != '--全部--' && parent_id != '' && parent_id != undefined){
            query = query + '&parent_id=' + parent_id;;
        }
        var url = window.location.pathname + query;
        window.location.href = url;
    });
    //删除
    $('.delTag').live('click', function() {
        var td = $(this).parents('tr').children('td');
        var delUrl = td.eq(7).find('#del-url').val();
        $.get(delUrl, function(res) {
            //错误判断
            if (res.status == 'ok') {
                window.location.href = window.location.pathname;
            }
            return;
        }).fail(function() {
            alert('亲，服务器出错啦');
        });   
    });
    //修改
    $(".editTag").live('click', function() {
        var td = $(this).parents('tr').children('td');
        var text1 = td.eq(1).html();
        var text4 = td.eq(4).html();
        var text8 = $(this).parent().html();
        var to_text1 = '<input name="textfield" type="text" id="textfield" value="" size="8" class="Classification_text" />';
        var to_text4 = '<input name="textfield" type="text" id="textfield" value="" size="8" class="Classification_text" />';
        var to_text8 = '<a href="javacript:;" class="Search_show saveTag">确定</a> <a href="javacript:;" class="Search_show chanceTag">取消</a>';
        td.eq(1).html(to_text1);
        td.eq(1).find('#textfield').val(text1);
        td.eq(4).html(to_text4);
        td.eq(4).find('#textfield').val(text4);
        $(this).parent().html(to_text8);
    });
    //提交
    $(".saveTag").live('click', function() {
        var td = $(this).parents('tr').children('td');
        var text1 = td.eq(1).find('input').val();
        var text4 = td.eq(4).find('input').val();
        var editUrl = td.eq(7).find('#edit-url').val();
        var data = {word:text1, sort:text4};
        $.post(editUrl, data, function(res) {
            //错误判断
            if (res.status == 'ok') {
                var text6 = '<a href="javascript:;" class="Search_show editTag">编辑</a> <a href="javascript:;" class="Search_del delTag">删除</a>';
                td.eq(6).html(text6);
                td.eq(1).html(text1);
                td.eq(4).html(text4);
                return;
            }
            return;
        }).fail(function() {
            alert('亲，服务器出错啦');
        });
    });
    //取消
    $(".chanceTag").live('click', function() {
        var td = $(this).parents('tr').children('td');
        var text1 = td.eq(7).find('#preTag').val();
        console.log(text1);
        var text4 = td.eq(7).find('#preSort').val();
        var text6 = '<a href="javascript:;" class="Search_show editTag">编辑</a> <a href="javascript:;" class="Search_del delTag">删除</a>';
        $(this).parent().html(text6);
        td.eq(1).html(text1);
        td.eq(4).html(text4);
    });
});
</script>
@stop