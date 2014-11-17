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
    <div class="Theme_title" style="text-align:left;">
        数据中心 > 游戏下载统计
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
                            <option value="app_title" @if(Input::get('type') == 'app_title')selected="selected"@endif>游戏名称</option>
                        </select>
                    </span>
                    <span>
                        <input name="keyword" type="text" class="Search_wenben" size="20" placeholder="请输入关键词" value="{{ Input::get('keyword') }}"/>
                    </span>
                    <span>
                        <b>选择游戏分类:</b>
                        <select name="cat_id">
                            <option value="">全部</option>
                            @foreach ($cats as $id => $title)
                            <option value="{{ $id }}" @if(Input::get('cat_id') == $id)selected="selected"@endif>{{ $title }}</option>
                            @endforeach
                        </select>
                    </span>
                    <span>
                        <b>统计日期:</b>
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
                <td style="cursor:pointer" class="jq-sort" data-field='request' data-order='' data-title="请求量">请求量↑↓</td>
                <td style="cursor:pointer" class="jq-sort" data-field='download' data-order='' data-title="下载量">下载量↑↓</td>
                <td style="cursor:pointer" class="jq-sort" data-field='install' data-order='' data-title="安装量">安装量↑↓</td>
                <td style="cursor:pointer" class="jq-sort" data-field='download_percent' data-order='' data-title="下载占比">下载占比↑↓</td>
            </tr>
            @foreach ($list['data'] as $key => $row)
            <tr class="Search_biao_{{ $key%2 == 0 ? 'one' : 'two'}}">
                <td>{{ $row['app_id'] }}</td>
                <td>{{ $row['title'] }}</td>
                <td>{{ $row['cat'] }}</td>
                <td>{{ $row['request'] }}</td>
                <td>{{ $row['download'] }}</td>
                <td>{{ $row['install'] }}</td>
                <td>{{ $row['download_percent'] }}</td>
            </tr>
            @endforeach
            @if(empty($list['total']))
                <tr class="no-data"><td colspan="11">没有数据</td></tr>
            @endif
        </table>
        @if($list['last_page'] > 1)
            <div id="pager"></div>
        @endif
    </div>
</div>
<script type="text/javascript">
    $(function(){
        // 日期控件初始化
        $('input[name="count_at[]"]').datepicker({dateFormat: 'yy-mm-dd'});

        // 分页初始化
        pageInit({{ $list['current_page'] }}, {{ $list['last_page'] }}, {{ $list['total'] }});

        // 排序
        $('.jq-sort').click(function() {
            // initSort();
            var order = '';
            if($(this).attr('data-order') == '') {
              order = 'desc';
            } else {
              order = $(this).attr('data-order');
            }

            var field = $(this).attr('data-field');
            var sp = '&';

            if (/\?orderby/.test($(location).attr('href')) || !/\?/.test($(location).attr('href'))) {
              var sp = '?';
            }

            var url = $.jurlp($(location).attr('href'));
            var orderStr = url.query().orderby;
            var newurl = $(location).attr('href');

            if(typeof(orderStr) != 'undefined') {
               newurl = $(location).attr('href').replace(sp+'orderby='+orderStr, '');
            }

            location.href = newurl + sp + 'orderby=' + field + '.' + order;
        });
    });
</script>
@stop