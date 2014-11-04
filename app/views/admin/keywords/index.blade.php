@extends('admin.layout')

@section('content') 
        
<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>系统管理 <span> 关键字管理</span></h1></div>

    <div class="Theme_Search">
        <ul>
            <li>
               <span><b>关键词添加：</b>
               <input name="word" type="text" class="Search_wenben" size="30" value="" placeholder="添加关键词" />
               </span>
               @if(Sentry::getUser()->hasAccess('keyword.store'))
               <input type="submit" value="添加" class="Search_en jq-submitWord" />
               @endif
            </li>
            <li>
               <span><b>查询：</b>
               <input maxlength="16" name="searchWord" type="text" class="Search_wenben" size="30" value="" placeholder="输入关键字"/>
               </span>
               <input type="submit" value="搜索" class="Search_en jq-submitSearch" />
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
            @forelse ($keywords as $keyword)
                <tr class="jq-tr">
                    <td>{{ $keyword->id }}</td>
                    <td>{{ $keyword->word }}</td>
                    <td>{{ $keyword->search_total }}</td>
                    <td>{{ isset($userDatas[$keyword->creator]) ? $userDatas[$keyword->creator] : '' }}</td>
                    <td>{{ $keyword->created_at }}</td>
                    <td>{{ isset($userDatas[$keyword->operator]) ? $userDatas[$keyword->operator] : '' }}</td>
                    <td>{{ $keyword->updated_at }}</td>
                    <td>
                        <a href='javascript:;' class="jq-changeSlide" data-slide="{{ $keyword->is_slide }}">
                        @if ($keyword->is_slide == 'yes')
                           <img src="/images/yes.jpg" width="18" height="18" />
                        @else
                          <img src="/images/no.jpg" width="18" height="18" />
                        @endif 
                    </td>
                    
                    <td>
                        @if(Sentry::getUser()->hasAccess('keyword.update'))
                        <a href="javascript:;" class="Search_show jq-editWord">修改</a>
                        @endif
                        @if(Sentry::getUser()->hasAccess('keyword.delete'))
                        <a href="{{ route('keyword.delete', $keyword->id) }}" class="Search_del jq-delete">删除</a>
                        @endif
                    </td>
                    <td style="display:none">
                        <input id="edit-url" value="{{ route('keyword.update', $keyword->id) }}" type="hidden"/>
                        <input id="del-url" value="{{ route('keyword.delete', $keyword->id) }}" type="hidden"/>
                        <input id="preWord" value="{{ $keyword->word }}" type="hidden"/>
                        <input id="preSlide" value="{{ $keyword->is_slide }}" type="hidden"/>
                        <input id="Slide" value="{{ $keyword->is_slide }}" type="hidden"/>
                    </td>
                    <!--
                        <td><a href="#" class="Search_show">确定</a> <a href="#" class="Search_show">取消</a></td>
                    !-->
                </tr>
            @empty
                <tr class="no-data">
                    <td colspan="9">没数据</td>
                <tr>
            @endforelse
        </table>
        @if($keywords->getLastPage() > 1)
            <div id="pager"></div>
        @endif
      </div>                   
</div>
<script type="text/javascript" src="{{ asset('js/jquery.pager.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/common.js') }}"></script>
<script>
$(function(){
    CREATEURL = "{{ route('keyword.store') }}";
    $(".jq-tr:odd").addClass("Search_biao_two");
    $(".jq-tr:even").addClass("Search_biao_one");
    //分页
    pageInit({{ $keywords->getCurrentPage() }}, {{ $keywords->getLastPage() }}, {{ $keywords->getTotal() }});

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
            return;
        }
        // 添加关键词
        var url = CREATEURL;
        var data = {word:word};
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
        var word = $("input[name=searchWord]").val();
        if (word === "输入关键字") {
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
        var to_text1 = '<input name="textfield2" type="text" id="textfield2" value="" size="8" class="Classification_text" />';
        var to_text8 = '<a href="javascript:;" class="Search_show jq-saveWord">确定</a> <a href="javascript:;" class="Search_show jq-chanceWord">取消</a>';
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
        var delUrl = td.find('#del-url').val();
        var data = {word:text1};
        $.post(editUrl, data, function(res) {
            //错误判断
            if (res.status == 'ok') {
                var text8 = '<a href="javascript:;" class="Search_show jq-editWord">修改</a>' + 
                            ' <a href="'+delUrl+'" class="Search_del jq-delete">删除</a>';
                td.eq(8).html(text8);
                td.eq(1).html(text1);
                td.eq(5).html(res.data.operator);
                td.eq(6).html(res.data.updated_at);
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
        var text1 = td.eq(9).find('#preWord').val();
        var delUrl = td.find('#del-url').val();
        var text8 = '<a href="javascript:;" class="Search_show jq-editWord">修改</a>'+
                    ' <a href="'+delUrl+'" class="Search_del jq-delete">删除</a>';
        $(this).parent().html(text8);
        td.eq(1).html(text1);
    });
    //修改轮播
    $(".jq-changeSlide").click(function(){
        var changeSlide = $(this);
        var td = changeSlide.parents('tr').children('td');
        var editUrl = td.eq(9).find('#edit-url').val();
        var slide = changeSlide.attr("data-slide");
        if (slide == 'yes'){
            var is_slide = 'no';
        }else{
            var is_slide = 'yes';
        }
        var data = {is_slide : is_slide};
        $.post(editUrl, data, function(res) {
            //错误判断
            if (res.status == 'ok') {
                if (slide == 'yes'){
                    var text = '<img src="/images/no.jpg" width="18" height="18" />';
                }else{
                    var text = '<img src="/images/yes.jpg" width="18" height="18" />';
                }
                changeSlide.attr("data-slide", is_slide);
                changeSlide.html(text);
                return;
            }
            return;
        }).fail(function() {
            returnMsgBox('亲，服务器出错啦');
        });
    });
});
</script>
@stop