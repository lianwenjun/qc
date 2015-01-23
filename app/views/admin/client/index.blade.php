@extends('admin.layout')

@section('content')

<script type="text/javascript" src="{{ asset('js/jquery-ui-1.8.23.custom.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.pager.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/common.js') }}"></script>

<div class="Content_right_top Content_height">
    <div class="Theme_title">
        <h1>系统管理 <span>游戏中心APP版本管理</span></h1>
        @if(Sentry::getUser()->hasAccess('client.create'))
            <a href="{{ URL::route('client.create') }}" target="BoardRight">添加新版本</a>
        @endif
    </div>
    <div class="Theme_Search">
        <ul>
            <li>
               <span><b>渠道名</b>
               <input name="name" type="text" class="Search_wenben" size="10" value="" placeholder="渠道名" />
               </span>
               <span><b>渠道代号</b>
               <input name="code" type="text" class="Search_wenben" size="10" value="" placeholder="渠道代号" />
               </span>
               @if(Sentry::getUser()->hasAccess('channels.store'))
                    <input type="submit" value="添加" class="Search_en jq-submitWord" />
               @endif
            </li>
        </ul>
        
    </div>
        
    
    <div class="Search_cunt">共 <strong>{{ $apps->getTotal() }}</strong> 条记录 </div>
    <!-- 提示 -->
    @if(Session::has('msg'))
    <div class="tips">
        <div class="fail">{{ Session::get('msg') }}</div>
    </div>
    @endif
    <!-- /提示 -->
    <div class="Search_biao">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="Search_biao_title">
                <td width="2%">ID</td>
                <td width="6%">游戏名称</td>
                <td width="3%">MD5</td>
                <td width="3%">大小</td>
                <td width="6%">新特性</td>
                <td width="3%">版本</td>
                <td width="6%">版本代号</td>
                <td width="8%">上传时间</td>
                <td width="8%">渠道名</td>
                <td width="8%">release</td>
                <td width="6%">操作</td>
            </tr>
            @forelse($apps as $k => $app)
            <tr class="jq-tr">
                <td>{{ $app->id }}</td>
                <td><a href="{{ $app->download_link }}">{{ $app->title }}</a></td>
                <td>{{ $app->md5 }}</td>
                <td>{{ $app->size_int }}KB</td>
                <td>{{ $app->changes }}</td>
                <td>{{ $app->version }}</td>
                <td>{{ $app->version_code }}</td>
                <td>{{ date('Y-m-d H:i', strtotime($app['updated_at'])) }}</td>
                <td>{{ $channels[$app->release !='' ? $app->release : 0] }}</td>
                <td>{{ $app->release }}</td>
                <td>
                    @if(Sentry::getUser()->hasAccess('client.edit'))
                        <a href="{{ URL::route('client.edit', $app->id) }}" class="Search_show">编辑</a>
                    @endif
                </td>
            </tr>
            @empty
                <tr class="no-data"><td colspan="9">没有数据</td></tr>
            @endforelse
        </table>
        @if($apps->getLastPage() > 1)
            <div id="pager"></div>
        @endif
    </div>
</div>

<script type="text/javascript">
$(function(){
    $(".jq-tr:odd").addClass("Search_biao_two");
    $(".jq-tr:even").addClass("Search_biao_one");
    $("input[name=word]").focus(function() {
        $(this).val("");
    });
    //分页
    pageInit({{ $apps->getCurrentPage() }}, {{ $apps->getLastPage() }}, {{ $apps->getTotal() }});

    //提交添加
    $(".jq-submitWord").click(function() {
        var name = $("input[name=name]").val();
        var code = $("input[name=code]").val();
        if (name == "" || code == "") {
            return;
        }
        // 添加
        var url = '{{ route("channels.store") }}';
        var data = {name:name, code:code};
        // 发送数据
        $.post(url, data, function(res) {
            //错误判断
            if (res.status != 'ok') {
                returnMsgBox('添加失败');
                return;
            }
            returnMsgBox('添加渠道成功');
            //成功返回刷新页面
            setTimeout("window.location.reload()", 5000);
            //window.location.href = window.location.pathname;
        }).fail(function() {
            returnMsgBox('亲，服务器出错啦');
        });
    });
});
</script>
@stop
