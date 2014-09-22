@extends('admin.layout')

@section('content') 
        
<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>系统管理 <span> 关键字管理</span></h1></div>

    <div class="Theme_Search">
        <ul>
            <li>
               <span><b>关键词添加：</b>
               <input id="addWord" name="word" type="text" class="Search_wenben" size="30" value="添加关键词" />
               </span>
               <input id="submitWord" name="" type="submit" value="添加" class="Search_en" />
            </li>
            <li>
               <span><b>查询：</b>
               <input id="searchWord" name="word" type="text" class="Search_wenben" size="30" value="输入关键字" />
               </span>
               <input id="submitSearch" name="" type="submit" value="搜索" class="Search_en" />
            </li>
        </ul>
    </div>
                    
    <div class="Search_cunt">共 <strong>{{ $total }}</strong> 条记录 </div>

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
                <tr class="Search_biao_one">
                    <td>{{ $keyword->id }}</td>
                    <td>{{ $keyword->word }}</td>
                    <td>{{ $keyword->search_total }}</td>
                    <td>{{ $keyword->creator }}</td>
                    <td>{{ $keyword->created_at }}</td>
                    <td>{{ $keyword->operator }}</td>
                    <td>{{ $keyword->updated_at }}</td>
                    <td>
                        @if ($keyword->is_slide == 'yes')
                          <img src="images/xia_yes.png" width="18" height="18" />
                        @else
                          <img src="images/xia_none.png" width="18" height="18" />
                        @endif
                    </td>
                    <td><a href="javacript:;" class="Search_show editWord">修改</a> <a href="{{ route('keyword.delete', $keyword->id) }}" class="Search_del">删除</a></td>
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
    CREATEURL = '/admin/keyword/create';
    
    $("#addWord").focus(function() {
        $(this).val("");
    });
    $("#searchWord").focus(function() {
        $(this).val("");
    });
    //提交添加
    $("#submitWord").click(function() {
        var word = $("#addWord").val();
        if (word === "添加关键词" || word == "") {
            $("#addWord").val("添加关键词");
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
    $("#submitSearch").click(function() ß{
        var word = $("#searchWord").val();
        if (word === "输入关键字" || word == "") {
            $("#searchWord").val("输入关键字");
            return;
        }
        // 查询
        var url = window.location.pathname + '?word=' + word;
        window.location.href = url;
    });
    //修改
    $(".editWord").click(function() {
        //alert('点击修改');
        var td = $(this).parents('tr').children('td');
        //console.log(td);
        var text1 = td.eq(1).html();
        var text7 = td.eq(7).html();
        var text8 = $(this).parent().html();
        var to_text1 = '<input name="textfield2" type="text" id="textfield2" value="" size="8" class="Classification_text" />';
        to_text1 = to_text1 + '<input id="preWord" value="" type="hidden"/>';
        to_text1 = to_text1 + '<input id="preWord" value="" type="hidden"/>';
        var to_text7 = '';
        var to_text8 = '<a href="javacript:;" class="Search_show saveWord">确定</a> <a href="javacript:;" class="Search_show chanceWord">取消</a>';
        
        console.log(text1);
        console.log(text7);
        td.eq(1).html(to_text1);
        td.eq(1).find('#textfield2').val(text1);
        td.eq(1).find('#preWord').val(text1);
        $(this).parent().html(to_text8);
    });
    //提交
    $(".saveWord").live('click', function() {
        alert('点击保存');
        var td = $(this).parents('tr').children('td');
        var text1 = td.eq(1).find('input').val();
        console.log();
    });
    //取消
    $(".chanceWord").live('click', function() {
        alert('点击保存');
        var td = $(this).parents('tr').children('td');
        var text1 = td.eq(1).find('input').val();
        console.log(td);
    });
});
</script>
@stop