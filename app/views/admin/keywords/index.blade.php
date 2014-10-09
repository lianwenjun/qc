@extends('admin.layout')

@section('content') 
        
<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>系统管理 <span> 关键字管理</span></h1></div>

    <div class="Theme_Search">
        <ul>
            <li>
               <span><b>关键词添加：</b>
               <input name="word" type="text" class="Search_wenben" size="30" value="添加关键词" />
               </span>
               <input name="" type="submit" value="添加" class="Search_en jq-submitWord" />
            </li>
            <li>
               <span><b>查询：</b>
               <input name="searchWord" type="text" class="Search_wenben" size="30" value="输入关键字" />
               </span>
               <input name="" type="submit" value="搜索" class="Search_en jq-submitSearch" />
            </li>
        </ul>
    </div>
                    
    <div class="Search_cunt">共 <strong>{{ $keywords->getTotal() }}</strong> 条记录 </div>

    <div class="Search_biao">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="Search_biao_title">
                <td width="4%">ID</td>
                <td width="20%">关键字</td>
                <td width="9%">自然搜索量</td>
                <td width="8%">添加人</td>
                <td width="12%">添加时间</td>
                <td width="9%">最后编辑人</td>
                <td width="12%">最后更新时间</td>
                <td width="8%">是否轮播</td>
                <td width="12%">操作</td>
            </tr>
            @foreach ($keywords as $keyword)
                <tr class="jq-tr">
                    <td>{{ $keyword->id }}</td>
                    <td>{{ $keyword->word }}</td>
                    <td>{{ $keyword->search_total }}</td>
                    <td>{{ $keyword->creator }}</td>
                    <td>{{ $keyword->created_at }}</td>
                    <td>{{ $keyword->operator }}</td>
                    <td>{{ $keyword->updated_at }}</td>
                    <td>
                        @if ($keyword->is_slide == 'yes')
                          <img src="/css/images/xia_yes.png" width="18" height="18" />
                        @else
                          <img src="/css/images/xia_none.png" width="18" height="18" />
                        @endif           
                    </td>
                    <td><a href="javacript:;" class="Search_show jq-editWord">修改</a> <a href="javascript:;" class="Search_del jq-delWord">删除</a></td>
                    <td style="display:none">
                        <input id="edit-url" value="{{ route('keyword.update', $keyword->id) }}" type="hidden"/>
                        <input id="del-url" value="{{ route('keyword.delete', $keyword->id) }}" type="hidden"/>
                        <input id="preWord" value="{{ $keyword->word }}" type="hidden"/>
                        <input id="preSlide" value="{{ $keyword->is_slide }}" type="hidden"/>
                    </td>
                    <!--
                        <td><a href="#" class="Search_show">确定</a> <a href="#" class="Search_show">取消</a></td>
                    !-->
                </tr>
            @endforeach
       </table>
       <div id="pager">{{ $keywords->links() }}</div>
      </div>                   
</div>
<script>
$(function(){
    CREATEURL = "{{ route('keyword.store') }}";
    $("input[name=word]").focus(function() {
        $(this).val("");
    });
    $("input[name=searchWord]").focus(function() {
        $(this).val("");
    });
    //提交添加
    $(".jq-submitWord").click(function() {
        var word = $("input[name=word]").val();
        if (word === "添加关键词" || word == "") {
            $("input[name=word]").val("添加关键词");
            return;
        }
        // 添加关键词
        var url = CREATEURL;
        var data = {word:word};
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
    //删除
    $('.jq-delWord').live('click', function() {
        var td = $(this).parents('tr').children('td');
        var delUrl = td.eq(9).find('#del-url').val();
        window.location.href = delUrl;
    });
    //修改
    $(".jq-editWord").live('click', function() {
        var td = $(this).parents('tr').children('td');
        var text1 = td.eq(1).html();
        var text7 = td.eq(7).html();
        var text8 = $(this).parent().html();
        var to_text1 = '<input name="textfield2" type="text" id="textfield2" value="" size="8" class="Classification_text" />';
        var to_text7 = '';
        var to_text8 = '<a href="javacript:;" class="Search_show jq-saveWord">确定</a> <a href="javacript:;" class="Search_show jq-chanceWord">取消</a>';
        td.eq(1).html(to_text1);
        td.eq(1).find('#textfield2').val(text1);
        $(this).parent().html(to_text8);
    });
    //提交
    $(".jq-saveWord").live('click', function() {
        //alert('点击保存');
        var td = $(this).parents('tr').children('td');
        var text1 = td.eq(1).find('input').val();
        var editUrl = td.eq(9).find('#edit-url').val();
        //var is_slide = td.eq().
        var data = {word:text1, is_slide:'yes'};
        $.post(editUrl, data, function(res) {
            //错误判断
            if (res.status == 'ok') {
                var text8 = '<a href="javacript:;" class="Search_show jq-editWord">修改</a> <a href="javascript:;" class="Search_del jq-delWord">删除</a>';
                td.eq(8).html(text8);
                td.eq(1).html(text1);
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
        var text1 = td.eq(9).find('#preWord').val();
        var text8 = '<a href="javacript:;" class="Search_show jq-editWord">修改</a> <a href="javascript:;" class="Search_del jq-delWord">删除</a>';
        $(this).parent().html(text8);
        td.eq(1).html(text1);
        //td.eq(9).find('input').val(text1);
    });
});
</script>
@stop