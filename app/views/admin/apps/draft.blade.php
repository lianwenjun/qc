@extends('admin.layout')

@section('content')
<link href="{{ asset('css/admin/plupload/jquery.plupload.queue.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('css/admin/timepicker/jquery-ui-timepicker-addon.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/admin/timepicker/jquery-ui-1.11.0.custom.css') }}" rel="stylesheet" type="text/css" />

<script src="{{ asset('js/admin/plupload/plupload.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/admin/plupload/jquery.plupload.queue.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/admin/plupload/i18n/zh_CN.js') }}" type="text/javascript"></script>

<script type="text/javascript" src="{{ asset('js/jquery-ui-1.8.23.custom.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-addon.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-zh-CN.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.pager.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/common.js') }}"></script>

<div class="Content_right_top Content_height">
    <div class="Theme_title">
        {{ Breadcrumbs::render('apps.draft') }}
        <a href="javascript:;" class="jq-appUpload" target="BoardRight">游戏上传</a>
    </div>
    <form action="{{ URL::route('apps.draft') }}" method="get">
        <div class="Theme_Search">
            <ul>
                <li>
                    <span><b>查询：</b>
                    <select name="cate_id">
                        <option value="">--全部--</option>
                        @foreach($cates as $cate)
                        <option value="{{ $cate->id }}" @if(Input::get('cate_id') == $cate->id)selected="selected"@endif>{{ $cate->title }}</option>
                        @endforeach
                    </select>
                    </span>
                    <span><input name="title" type="text" class="Search_wenben" size="20" placeholder="请输入关键词" value="{{ Input::get('title') }}"/></span>
                    <span>　<b>日期：</b><input name="created_at[]" type="text" class="Search_wenben" value="{{ isset(Input::get('created_at')[0]) ? Input::get('created_at')[0] : '' }}"/><b>-</b><input name="created_at[]" type="text" class="Search_wenben" value="{{ isset(Input::get('created_at')[1]) ? Input::get('created_at')[1] : '' }}"/></span>
                    <input type="submit" value="搜索" class="Search_en" />
                </li>
            </ul>
        </div>
    </form>
    <div class="Search_cunt">待编辑游戏：共 <strong>{{ $apps['total'] }}</strong> 条记录 </div>
    <!-- 提示 -->
    @if(Session::has('tips'))
    <div class="tips">
        <div class="{{ Session::get('tips')['success'] ? 'success' : 'fail' }}">{{ Session::get('tips')['message'] }}</div>
    </div>
    @endif
    <!-- /提示 -->
    <div class="Search_biao">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="Search_biao_title">
                <td width="6%">游戏ID</td>
                <td width="6%">图标</td>
                <td width="10%">游戏名称</td>
                <td width="15%">包名</td>
                <td width="8%">游戏分类</td>
                <td width="8%">大小</td>
                <td width="8%">版本号</td>
                <td width="8%">上传时间</td>
                <td width="12%">操作</td>
            </tr>
            @foreach($apps['data'] as $k => $app)
            <tr class="Search_biao_{{ $k%2 == 0 ? 'one' : 'two'}}">
                <td>{{ $app['id'] }}</td>
                <td><img src="{{ asset($app['icon']) }}" width="28" height="28" /></td>
                <td>{{ $app['title'] }}</td>
                <td>{{ $app['pack'] }}</td>
                <td>{{ !empty($app['cate_name']) ? $app['cate_name'] : '/' }}</td>
                <td>{{ $app['size'] }}</td>
                <td>{{ $app['version'] }}</td>
                <td>{{ date('Y-m-d H:i', strtotime($app['created_at'])) }}</td>
                <td>
                    @if($app['status'] == 'new')
                        @if(Sentry::getUser()->hasAccess('apps.edit'))
                    <a href="{{ URL::route('apps.draft.edit', ['id' => $app['id'] ]) }}" target="BoardRight" class="Search_show">编辑</a>
                        @endif
                    @else 
                    <a href="{{ URL::route('apps.draft.edit', ['id' => $app['id'] ]) }}" target="BoardRight" class="Search_show">草稿</a>
                    @endif
                    <a href="{{ URL::route('apps.delete', $app['id']) }}" class="Search_del jq-delete">删除</a></td>
            </tr>
            @endforeach
            @if(empty($apps['total']))
                <tr class="no-data"><td colspan="9">没有数据</td></tr>
            @endif
        </table>
        @if($apps['last_page'] > 1)
        <div id="pager"></div>
        @endif
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        // 时间输入框
        $('input[name="created_at[]"]').datepicker({dateFormat: 'yy-mm-dd'});

        // 上传游戏
        $(".jq-appUpload").click(function(){
            $.jBox("<div id='uploader'><p>您的浏览器不支持 html5 所以无法使用上传服务。</p></div>", {  
                title: "<div class=ask_title>游戏上传</div>",  
                width: 650,  
                height: 310,
                border: 5,
                showType: 'slide', 
                opacity: 0.3,
                showIcon: false,
                top: '20%',
                loaded:function() {
                  $("body").css("overflow-y","hidden");
                    var apkUploader = $("#uploader").pluploadQueue({
                        runtimes : 'html5',
                        url : '{{ URL::route('apps.appupload') }}',
                        chunk_size: '1mb',
                        dragdrop: true,
                        filters : {
                            max_file_size : '2048mb',
                            mime_types: [
                                {title : "apk文件", extensions : "apk"}
                            ]
                        },
                        flash_swf_url : '{{ asset('js/admin/plupload/Moxie.swf') }}',
                    });
                    apkUploader.bind('UploadProgress', function(up, file) {
                        if(file.percent == 100) file.percent = 99;
                        document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
                    });
                },
                closed:function() {
                   $("body").css("overflow-y","auto");
                   location.href = location.href;
                }
            });
        });

        // 分页
        pageInit({{ $apps['current_page'] }}, {{ $apps['last_page'] }}, {{ $apps['total'] }});

    });
</script>
@stop
