@extends('admin.layout')

@section('content')
<link href="{{ asset('css/admin/plupload/jquery.plupload.queue.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('js/admin/plupload/plupload.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/admin/plupload/jquery.plupload.queue.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/admin/plupload/i18n/zh_CN.js') }}" type="text/javascript"></script>

<link href="{{ asset('css/admin/timepicker/jquery-ui-1.11.0.custom.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/admin/timepicker/jquery-ui-timepicker-addon.css') }}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{ asset('js/jquery-ui-1.8.23.custom.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-addon.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-zh-CN.js') }}"></script>

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
                    <span>　<b>日期：</b><input name="start-created_at" type="text" class="Search_wenben" value="{{ Input::get('start-created_at') }}"/><b>-</b><input name="end-created_at" type="text" class="Search_wenben" value="{{ Input::get('end-created_at') }}"/></span>
                    <input type="submit" value="搜索" class="Search_en" />
                </li>
            </ul>
        </div>
    </form>
    <div class="Search_cunt">待编辑游戏：共 <strong>{{ $apps->getTotal() }}</strong> 条记录 </div>
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
            @foreach($apps as $k => $app)
            <tr class="Search_biao_{{ $k%2 == 0 ? 'one' : 'two'}}">
                <td>{{ $app->id }}</td>
                <td><img src="{{ asset($app->icon) }}" width="28" height="28" /></td>
                <td>{{ $app->title }}</td>
                <td>{{ $app->pack }}</td>
                <td> / </td>
                <td>{{ $app->size }}</td>
                <td>{{ $app->version }}</td>
                <td>{{ date('Y-m-d H:i', strtotime($app->created_at)) }}</td>
                <td><a href="{{ URL::route('apps.edit', ['id' => $app->id ]) }}" target="BoardRight" class="Search_show">编辑</a> <a href="{{ URL::route('apps.delete', $app->id) }}" class="Search_del jq-delete">删除</a></td>
            </tr>
            @endforeach
            @if(empty($apps->count()))
                <tr class="no-data"><td colspan="9">没有数据</td></tr>
            @endif
        </table>
        <div id="pager">{{ $apps->appends(Input::all())->links() }} 共: {{ $apps->getLastPage() }} 页 当前<input name="page" value="{{ $apps->getCurrentPage() }}" /><span class="jq-jump">GO</span></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        $('input[name="start-created_at"], input[name="end-created_at"]').datepicker({dateFormat: 'yy-mm-dd'});

        // 跳转页码
        $('.jq-jump').click(function() {
            var url = $(location).attr('href');;
            var pageNum = $('input[name="page"]').val();

            var sp = '?';
            if(/\?/.test(url)) {
                sp = '&';
            }

            var jumpUrl = url.replace(/&page=\d+/, "") + sp +'page=' + pageNum;

            location.href = jumpUrl;
        });

        $('.jq-delete').click(function() {

            var link = $(this).attr('href');
            $.jBox("<p style='margin: 10px'>您要删除吗？</p>", {
                title: "<div class='ask_title'>是否删除？</div>",
                showIcon: false,
                draggable: false,
                buttons: {'确定':true, "算了": false},
                submit: function(v, h, f) {
                    if(v) {
                        var f = document.createElement('form');
                        $(this).after($(f).attr({
                            method: 'post',
                            action: link
                        }).append('<input type="hidden" name="_method" value="DELETE" />'));
                        $(f).submit();
                    }
                }
            });

            return false;
        });

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
                    var uploader = $("#uploader").pluploadQueue({
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
    });
</script>
@stop
