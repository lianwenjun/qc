@extends('admin.layout')

@section('content')
    <link href="{{ asset('css/admin/plupload/jquery.plupload.queue.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('js/admin/plupload/plupload.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin/plupload/jquery.plupload.queue.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/admin/plupload/i18n/zh_CN.js') }}" type="text/javascript"></script>

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
                <td width="6%">icon</td>
                <td width="10%">游戏名称</td>
                <td width="15%">包名</td>
                <td width="8%">游戏分类</td>
                <td width="8%">大小</td>
                <td width="8%">版本号</td>
                <td width="8%">上架时间</td>
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
                <td><a href="{{ URL::route('apps.edit', ['id' => $app->id ]) }}" target="BoardRight" class="Search_show">编辑</a> <a href="javascript:;" class="Search_del jq-appDelete" data-url="{{ URL::route('apps.delete', $app->id) }}">删除</a></td>
            </tr>
            @endforeach
            @if(empty($apps->count()))
                <tr class="no-data"><td colspan="9">没有数据</td></tr>
            @endif
        </table>
        <div id="pager"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        // 删除游戏
        $(".jq-appDelete").click(function() {
            var url = $(this).attr('data-url');
            $.jBox("<p style='margin: 10px'>您要删除此游戏吗？</p>", {
                title: "<div class='ask_title'>是否删除？</div>",
                showIcon: false,
                draggable: false,
                buttons: {'确定':true, "算了": false},
                submit: function(v, h, f) {
                    if(v == true) {
                        location.href = url;
                    }
                }

            });
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
