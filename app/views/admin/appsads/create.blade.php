@extends('admin.layout')

@section('content')
<link href="{{ asset('css/admin/timepicker/jquery-ui-1.11.0.custom.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/admin/timepicker/jquery-ui-timepicker-addon.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/admin/autocomplete/jquery-autocomplete.css') }}" rel="stylesheet" type="text/css" />

<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>广告位管理 <span>首页游戏位管理</span><b>添加游戏</b></h1></div>                 
    <div class="Search_title">游戏信息</div>
        <div class="Search_biao">
            <form action="{{ Request::url('appsads.create') }}" method="post">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="134" class="Search_lei">请输入游戏名称：</td>
                        <td><input id="autocomplete" type="text" class="Search_text jq-searchapps" value="" placeholder="应用名称输入时自动匹配" style="width:25%" /></td>
                    </tr>
                    <input name="app_id" type="hidden" val="">
                    <!--数据选择区开始-->
                    <input name="title" type="hidden" val="">
                    <tr>
                        <td  class="Search_lei">广告区域：</td>
                        <td>
                        <span style="float:left">
                            <select class="Search_select" name="location">
                                @foreach($location as $k => $v)
                                    <option value="{{ $k }}"> {{ $v }} </option>
                                @endforeach
                            </select>
                         </span>
                       </td>
                    </tr>

                    <tr>
                        <td  class="Search_lei">游戏截图：</td>
                        <td><a id="browse" href="javascrip:;" class="Search_Update">图片上传</a> <span style="color:#C00">（焦点图480*200，专题图230*120）</span></td>
                    </tr>

                    <tr>
                        <td  class="Search_lei">截图预览：</td>
                        <td class="Search_img">
                        <div class="Update_img">
                            <ul id="listdata">
                                <li>
                                    <!--a href="javascript">删除</a-->
                                </li>
                                <input name="image" type="hidden" value="" />
                            </ul>
                        </div>

                        </td>
                    </tr>

                    <tr>
                        <td  class="Search_lei">广告置顶：</td>
                        <td><input name="is_top" type="checkbox" value="yes"/>
                          是　<span style=" color:#C00">（选中后无论上架广告数量，该广告均会在轮播中出现）</span></td>
                    </tr>

                    <tr>
                        <td  class="Search_lei">上线时间：</td>
                        <td>    
                            <h6>从 </h6> <h6><input type="text" name="onshelfed_at" class="Search_text jq-ui-timepicker" value=""></h6>
                            <h6> 到 </h6> <h6><input type="text" name="offshelfed_at" class="Search_text jq-ui-timepicker" value=""></h6></td>
                    </tr>

                    <tr>
                        <td colspan="2" align="center"  class="Search_submit"><input name="" type="submit" value="提 交" /> <a href="{{ URL::route('appsads.index') }}" target=BoardRight>返回列表</a></td>
                    </tr>
                </table>
            </form>
        </div>                 
    </div>
</div>


<script type="text/javascript" src="{{ asset('js/jquery-ui-1.8.23.custom.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-addon.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-zh-CN.js') }}"></script>
<script src="{{ asset('js/admin/plupload/plupload.full.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('js/admin/jquery.autocomplete.js') }}"></script>
<script type="text/javascript">
function uploadToHtml(img){
    $("#listdata li img").src(img);
}
function getAppInfo(url){
    $.get(url, function(res){
        if (res.status == 'ok' ){
            var data1 = ['游戏ID：', '游戏名称：', '包名：', '大小：', '版本号：', '上传时间：', 'ICON：'];
            var data2 = [res.data.id, res.data.title, res.data.pack, res.data.size, res.data.version,
                res.data.created_at, '<span class="Search_apk"><img src="'+res.data.icon+'" width="90" height="90" /></span>'];
            var text = '';

            for(var i=0; i<data1.length; i++){
                    text += '<tr class="jq-appinfo-tr">'+
                            '<td  class="Search_lei">'+data1[i]+'</td>'+
                            '<td>'+data2[i]+'</td>'+'</tr>';
            }
            $(".jq-appinfo-tr").remove();
            $("input[name=app_id]").after(text);
            $("input[name=app_id]").val(res.data.id);
            $("input[name=title]").val(res.data.title);

            $("tr").removeClass("Search_biao_two");
            $("tr").removeClass("Search_biao_one");
            $("tr:odd").addClass("Search_biao_two");
            $("tr:even").addClass("Search_biao_one");
        }
    });
}
$(function(){
    $("tr:odd").addClass("Search_biao_two");
    $("tr:even").addClass("Search_biao_one");
    //自动匹配
    $('#autocomplete').autocomplete({
        serviceUrl: '{{ route("searchapps") }}',
        onSelect: function (suggestion) {
            getAppInfo(suggestion.data );
        }
    });
    //时间插件
    $(".jq-ui-timepicker").datetimepicker({
            showSecond: true,
            timeFormat: 'HH:mm:ss',
            stepHour: 1,
            stepMinute: 10,
            stepSecond: 10
    });
    //图片上传
    UPLOADURL = '{{ route("appsads.upload") }}';
    
    var uploader = new plupload.Uploader({ //实例化一个plupload上传对象
        browse_button : 'browse',
        url : UPLOADURL,
        runtimes: 'html5,flash',
        max_file_size : '1mb',
        flash_swf_url : '{{ asset("js/admin/plupload/Moxie.swf") }}',
        filters: { 
            mime_types : [ //只允许上传图片文件
                { title : "图片文件", extensions : "jpg,gif,png" }
            ]
        }
    });
    uploader.init(); //初始化

    //绑定文件添加进队列事件
    uploader.bind('FilesAdded',function(uploader,files){
        for(var i = 0, len = files.length; i<len; i++){
            uploader.start();
        }
    });
    //文件上传完后
    uploader.bind('FileUploaded', function(up, file, object) {
        var myData;
        try {
            myData = eval(object.response);
        } catch(err) {
            myData = eval('(' + object.response + ')');
        }
        if (myData.result){
            console.log( $("#listdata li img"));
            $("#listdata li").html('<img src="'+myData.result+'" />');
            $("#listdata input[name=image]").val(myData.result);
        }
    });
});
</script>
@stop