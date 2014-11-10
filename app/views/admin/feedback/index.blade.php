@extends('admin.layout')

@section('content')
<link href="{{ asset('css/admin/timepicker/jquery-ui-1.11.0.custom.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/admin/timepicker/jquery-ui-timepicker-addon.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/owl.theme.css') }}" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{{ asset('js/jquery-ui-1.8.23.custom.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-addon.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-zh-CN.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jurlp.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/owl.carousel.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.pager.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/common.js') }}"></script>
<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>系统管理 <span> 应用反馈</span></h1></div>
    <form action="{{ URL::route('feedback.index') }}" method="get">         
        <div class="Theme_Search">
            <ul>
                <li>
                    <span><b>查询：</b>
                        <select name="type">
                            <option value="id" {{ Input::get('type') == 'id' ? 'selected="selected"' : '' }} >反馈ID</option>
                            <option value="imei" {{ Input::get('type') == 'imei' ? 'selected="selected"' : '' }} >IMEI</option>
                            <option value="content" {{ Input::get('type') == 'content' ? 'selected="selected"' : '' }} >内容</option>
                        </select>
                    </span>
                    <span>
                        <input maxlength="16" name="keyword" type="text" class="Search_wenben" size="20" value="{{ Input::get('keyword') }}" placeholder="输入关键字" />
                    </span>
                    <span>
                        <b>日期：</b><input name="created_at[]" type="text" class="Search_wenben" value="{{ isset(Input::get('created_at')[0]) ? Input::get('created_at')[0] : '' }}"/>
                        <b>-</b><input name="created_at[]" type="text" class="Search_wenben" value="{{ isset(Input::get('created_at')[1]) ? Input::get('created_at')[1] : '' }}"/>
                    </span>
                    <input type="submit" value="搜索" class="Search_en" />
                </li>
            </ul>
        </div>
    </form>                
    <div class="Search_cunt">共 <strong>{{ $lists->getTotal() }}</strong> 条记录 </div>
                     
    <div class="Search_biao">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="Search_biao_title">
                <td width="6%">反馈ID</td>
                <td width="10%">用户机型</td>
                <td width="15%">IMEI辨识码</td>
                <td width="10%">版本号</td>
                <td width="15%">联系方式</td>
                <td width="30%">反馈内容</td>
                <td width="14%">反馈时间</td>
            </tr>
            @forelse($lists as $feedback)
                <tr class="jq-tr">
                    <td>{{ $feedback->id }}</td>
                    <td>{{ $feedback->type }}</td>
                    <td>{{ $feedback->imei }}</td>
                    <td>{{ $feedback->version }}</td>
                    <td>{{ $feedback->email }}</td>
                    <td>{{ $feedback->content }}</td>
                    <td>{{ $feedback->created_at }}</td>
                </tr>
            @empty
                <tr class="no-data">
                    <td colspan="9">没数据</td>
                <tr>
            @endforelse
        </table>
        @if($lists->getLastPage() > 1)
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
    pageInit({{ $lists->getCurrentPage() }}, {{ $lists->getLastPage() }}, {{ $lists->getTotal() }});

    // 日期控件
    $('input[name="created_at[]"]').datepicker({dateFormat: 'yy-mm-dd'});

});
</script>
@stop