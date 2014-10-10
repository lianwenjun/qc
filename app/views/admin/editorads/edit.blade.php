@extends('admin.layout')

@section('content')
<link href="{{ asset('css/admin/timepicker/jquery-ui-1.11.0.custom.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/admin/timepicker/jquery-ui-timepicker-addon.css') }}" rel="stylesheet" type="text/css" />
<style>
.autocomplete-suggestions { border: 1px solid #999; background: #FFF; cursor: default; overflow: auto; -webkit-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); -moz-box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); box-shadow: 1px 4px 3px rgba(50, 50, 50, 0.64); }
.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
.autocomplete-no-suggestion { padding: 2px 5px;}
.autocomplete-selected { background: #F0F0F0; }
.autocomplete-suggestions strong { font-weight: bold; color: #000; }
.autocomplete-group { padding: 2px 5px; }
.autocomplete-group strong { font-weight: bold; font-size: 16px; color: #000; display: block; border-bottom: 1px solid #000; }
</style>
<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>广告位管理 <span>编辑精选管理</span><b>编辑</b></h1></div>                
    <div class="Search_title">游戏信息</div>
                     
    <div class="Search_biao">
        <form action="{{ Request::url() }}" method="post">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              
                <tr>
                    <td  class="Search_lei">游戏ID：</td>
                    <td>{{ $ad->app_id }}</td>
                </tr>
              
                <tr>
                    <td  class="Search_lei">游戏名称：</td>
                    <td>{{ $app->title }}</td>
                </tr>
              
                <tr>
                    <td  class="Search_lei">包名：</td>
                    <td>{{ $app->pack }}</td>
                </tr>
              
                <tr>
                    <td  class="Search_lei">大小：</td>
                    <td>{{ $app->size }}</td>
                </tr>
              
                <tr>
                    <td  class="Search_lei">版本号：</td>
                    <td>{{ $app->version }}</td>
                </tr>
              
                <tr>
                    <td  class="Search_lei">上传时间：</td>
                    <td class="Search_apk">{{ $app->created_at }}</td>
                </tr>
              
                <tr>
                    <td  class="Search_lei">ICON：</td>
                    <td><span class="Search_apk"><img src="{{ $app->icon }}" width="90" height="90" /></span></td>
                </tr>
              
                <tr>
                    <td  class="Search_lei">广告区域：</td>
                    <td>
                    <span style="float:left">
                            {{ Form::select('location', $location, $ad->location, ['class'=>'Search_select']) }}
                     </span>
                   </td>
                </tr>
              
                <tr>
                    <td  class="Search_lei">游戏截图：</td>
                    <td><a id="browse" href="javacript:;" class="Search_Update">图片上传</a> <span style="color:#C00">（焦点图480*200，专题图230*120）</span></td>
                </tr>
              
                <tr>
                    <td  class="Search_lei">截图预览：</td>
                    <td class="Search_img">
                    <div class="Update_img">
                        <ul id="listdata">
                            <li>
                                <img src="{{ $ad->image }}" />
                                <!--<a href="#">删除</a> -->
                            </li>
                        </ul>
                    </div>

                    </td>
                </tr>
              
                <tr>
                    <td  class="Search_lei">广告词：</td>
                    <td><input name="word" type="text" class="Search_text" value="{{ $ad->word }}" style="width:60%"/></td>
                </tr>
              
                <tr>
                    <td  class="Search_lei">广告置顶：</td>
                    <td>{{ Form::checkbox('is_top', 'yes', $ad->is_top == 'yes') }}
                      是　<span style=" color:#C00">（选中后无论上架广告数量，该广告均会在轮播中出现）</span></td>
                </tr>
              
                <tr>
                    <td  class="Search_lei">上线时间：</td>
                    <td>
                        <h6>从 </h6> <h6><input type="text" name="onshelfed_at" class="jq-ui-timepicker" value="{{ $ad->onshelfed_at }}"></h6>
                        <h6> 到 </h6> <h6><input type="text" name="offshelfed_at" class="jq-ui-timepicker" value="{{ $ad->offshelfed_at }}"></h6>
                    </td>
                </tr>
              
                <tr>
                    <td colspan="2" align="center"  class="Search_submit">
                        <input name="" type="submit" value="确定修改" />
                        <a href="{{ URL::route('editorads.index') }}" target=BoardRight>返回列表</a></td>
                </tr>
            </table>
        </form>
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

$(function(){
    $("tr:odd").addClass("Search_biao_two");
    $("tr:even").addClass("Search_biao_one");
    //时间插件
    $(".jq-ui-timepicker").datetimepicker({
            showSecond: true,
            timeFormat: 'hh:mm:ss',
            stepHour: 1,
            stepMinute: 1,
            stepSecond: 1
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
            $("#listdata li img").attr('src', myData.result);
            $("#listdata input[name=image]").val(myData.result);
        }
    });
});
</script>
@stop