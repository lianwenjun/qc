@extends('admin.layout')

@section('content')
    <link href="{{ asset('css/admin/plupload/jquery.plupload.queue.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('js/admin/plupload/plupload.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin/plupload/jquery.plupload.queue.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin/plupload/i18n/zh_CN.js') }}" type="text/javascript"></script>

    <div class="Content_right_top Content_height">
        <div class="Theme_title">
            {{ Breadcrumbs::render('draft') }}
            <a href="javascript:;" class="jq-upload" target=BoardRight>游戏上传</a>
        </div>
    <form action="{{ URL::route('apps.draft') }}" method="get">
        <div class="Theme_Search">
            <ul>
                <li>
                    <span><b>查询：</b>
                    <select name="">
                        <option>--全部--</option>
                        <option>1</option>
                    </select>
                    </span>
                    <span><input name="" type="text" class="Search_wenben" size="20" value="请输入关键词" /></span>
                    <span>　<b>日期：</b><img src="images/darte.jpg" width="156" height="22" /><b>-</b><img src="images/darte.jpg" width="156" height="22" /></span>
                    <input name="" type="submit" value="搜索" class="Search_en" />
                </li>
            </ul>
        </div>
    </form>
    <div class="Search_cunt">待编辑游戏：共 <strong>{{ $apps->count() }}</strong> 条记录 </div>
    <div class="Search_biao">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="Search_biao_title">
                <td width="6%">游戏ID</td>
                <td width="6%">icon</td>
                <td width="10%">游戏名称</td>
                <td width="15%">包名</td>
                <td width="8%">游戏分类</td>
                <td width="8%">大小</td>
                <td width="8%">版本号</td>
                <td width="8%">上架时间</td>
                <td width="12%">操作</td>
            </tr>
            @foreach($apps as $k => $app):
            <tr class="Search_biao_{{ $k%2 == 0 ? 'one' : 'two'}}">
                <td>10</td>
                <td><img src="images/u1188.png" width="28" height="28" /></td>
                <td>植物大战僵尸</td>
                <td>com.xxxxxxx.xxxx.xx</td>
                <td>休闲益智</td>
                <td>12.6 M</td>
                <td>3.1.124</td>
                <td>2014-7-9</td>
                <td><a href="Editor.html" target=BoardRight class="Search_show">编辑</a> <a href="#" class="Search_del">删除</a></td>
            </tr>
            @endforeach
            @if(empty($apps->count))
                <tr class="no-data"><td colspan="9">没有数据</td></tr>
            @endif
        </table>
        <div id="pager"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $(".jq-upload").click(function(){
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
                    },
                    closed:function() {
                       $("body").css("overflow-y","auto");
                    }
                });
        });
    });
</script>
@stop