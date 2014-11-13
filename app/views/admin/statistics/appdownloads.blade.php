@extends('admin.layout')
@section('content')

<link href="{{ asset('css/admin/timepicker/jquery-ui-1.11.0.custom.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/admin/timepicker/jquery-ui-timepicker-addon.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/owl.theme.css') }}" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{{ asset('js/jquery-ui-1.8.23.custom.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-addon.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-zh-CN.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/owl.carousel.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.pager.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/common.js') }}"></script>

<div class="Content_right_top Content_height">
    <div class="Theme_title">
        xxxx
    </div>
    <form action="{{ URL::route('statistics.appdownloads') }}" method="get">
        <div class="Theme_Search">
            <ul>
                <li>
                    <span>
                        <b>查询:</b>
                        <select name="type">
                            <option value="">全部</option>
                            <option value="app_id" @if(Input::get('type') == 'app_id')selected="selected"@endif>游戏id</option>
                            <option value="cat_id" @if(Input::get('type') == 'cat_id')selected="selected"@endif>游戏分类</option>
                            <option value="app_title" @if(Input::get('type') == 'app_title')selected="selected"@endif>游戏名称</option>
                        </select>
                    </span>
                    <span>
                        <input name="handwrite" type="text" class="Search_wenben" size="20" placeholder="请输入关键词" value="{{ Input::get('handwrite') }}"/>
                    </span>
                    <span>
                        <b>选择游戏分类:</b>
                        <select name="choose">
                            @foreach ($cats as $each)
                            <option value="{{ $each->id }}" @if(Input::get('choose') == $each->id)selected="selected"@endif>{{ $each->title }}</option>
                            @endforeach
                        </select>
                    </span>
                    <span>
                        <b>日期:</b>
                        <input name="count_at[]" type="text" class="Search_wenben" value="{{ isset(Input::get('count_at')[0]) ? Input::get('count_at')[0] : '' }}"/>
                        <b>-</b>
                        <input name="count_at[]" type="text" class="Search_wenben" value="{{ isset(Input::get('count_at')[1]) ? Input::get('count_at')[1] : '' }}"/>
                    </span>
                    <input type="submit" value="搜索" class="Search_en" />
                </li>
            </ul>
        </div> 
    </form>
    <div class="Search_cunt">游戏下载统计:共 <strong>{{ $list['total'] }}</strong>条记录</div>
    <div class="Search_biao">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="Search_biao_title">
                <td>游戏id</td>
                <td>游戏名称</td>
                <td>游戏分类</td>
                <td>请求量</td>
                <td>下载量</td>
                <td>安装量</td>
                <td>激活量</td>
                <td>下载占比</td>
            </tr>
        </table>
    </div>
    <div style="padding:20px;">
        <pre>{{ print_r($list, 1) }}</pre>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        // 日期控件初始化
        $('input[name="count_at[]"]').datepicker({dateFormat: 'yy-mm-dd'});

        // 分页初始化
        pageInit({{ $list['current_page'] }}, {{ $list['last_page'] }}, {{ $list['total'] }});
    });
</script>
@stop