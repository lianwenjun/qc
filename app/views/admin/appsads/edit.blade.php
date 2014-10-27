@extends('admin.layout')

@section('content')
<link href="{{ asset('css/admin/timepicker/jquery-ui-1.11.0.custom.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/admin/timepicker/jquery-ui-timepicker-addon.css') }}" rel="stylesheet" type="text/css" />
<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>广告位管理 <span>首页游戏位管理</span><b>添加游戏</b></h1></div>                 
    <div class="Search_title">游戏信息</div>
        <div class="Search_biao">
            <form action="{{ Request::url() }}" method="post">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <!--数据选择区开始-->
                    <tr class="Search_biao_two">
                        <td  class="Search_lei">游戏ID：</td>
                        <td>{{ $ad->app_id }}</td>
                    </tr>

                    <tr class="Search_biao_one">
                        <td  class="Search_lei">游戏名称：</td>
                        <td>{{ $app->title }}</td>
                    </tr>

                    <tr class="Search_biao_two">
                        <td  class="Search_lei">包名：</td>
                        <td>{{ $app->package }}</td>
                    </tr>

                    <tr class="Search_biao_one">
                        <td  class="Search_lei">大小：</td>
                        <td>{{ $app->size }}</td>
                    </tr>

                    <tr class="Search_biao_two">
                        <td  class="Search_lei">版本号：</td>
                        <td>{{ $app->version }}</td>
                    </tr>

                    <tr class="Search_biao_one">
                        <td  class="Search_lei">上传时间：</td>
                        <td class="Search_apk">{{ $app->created_at }}</td>
                    </tr>

                    <tr class="Search_biao_two">
                        <td  class="Search_lei">ICON：</td>
                        <td><span class="Search_apk"><img src="{{ $app->icon }}" width="90" height="90" /></span></td>
                    </tr>
                    <!--数据选择区结束-->
                    <tr class="Search_biao_one">
                        <td  class="Search_lei">广告区域：</td>
                        <td>
                        <span style="float:left">
                            {{ Form::select('location', $location, $ad->location, ['class'=>'Search_select']); }}
                         </span>
                       </td>
                    </tr>

                    <tr class="Search_biao_two">
                        <td  class="Search_lei"><span class="required">*</span>游戏截图：</td>
                        <td><a id="browse" href="javascript:;" class="Search_Update">图片上传</a> <span style="color:#C00">（焦点图480*200，专题图230*120）</span></td>
                    </tr>

                    <tr class="Search_biao_one">
                        <td  class="Search_lei">截图预览：</td>
                        <td class="Search_img">
                            <div class="Update_img">
                                <ul id="listdata">
                                    <li><img src="{{ $ad->image }}" /></li>
                                    <input name="image" type="hidden" value="{{ $ad->image }}" />
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr class="Search_biao_two">
                        <td  class="Search_lei">广告置顶：</td>
                        <td>{{ Form::checkbox('is_top', 'yes', $ad->is_top == 'yes') }}
                          是　<span style=" color:#C00">（选中后无论上架广告数量，该广告均会在轮播中出现）</span></td>
                    </tr>

                    <tr class="Search_biao_one">
                        <td class="Search_lei"><span class="required">*</span>上线时间：</td>
                        <td>
                            <h6>从 </h6> <h6><input type="text" name="stocked_at" class="Search_text jq-ui-timepicker" value="{{ $ad->stocked_at }}"></h6>
                             <h6> 到 </h6> <h6><input type="text" name="unstocked_at" class="Search_text jq-ui-timepicker" value="{{ $ad->unstocked_at }}"></h6>
                         </td>
                    </tr>

                    <tr class="Search_biao_two">
                        <td colspan="2" align="center"  class="Search_submit">
                            <input class="jq-ads-edit-submit" type="button" value="提 交" /> 
                            <a href="{{ URL::route('appsads.index') }}" target=BoardRight>返回列表</a>
                        </td>
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
<script src="{{ asset('js/admin/jquery.validate.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">
$(function(){
    //时间选择
    $(".jq-ui-timepicker").datetimepicker({
        showSecond: true,
        timeFormat: 'HH:mm:ss',
        stepHour: 1,
        stepMinute: 10,
        stepSecond: 10
    });

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
            $("#listdata li img").attr('src', myData.result.path);
            $("#listdata input[name=image]").val(myData.result.path);
        }
    });

    // 提交表单
    $('.jq-ads-edit-submit').click(function() {
        // 验证
        $("form").validate({
            ignore: '',
            rules: {
                app_id: "required",
                image: "required",
                stocked_at: "required",
                unstocked_at: "required",
            },
            messages: {
                app_id: {required: '游戏为必填'},
                image: {required: '图片为必填'},
                stocked_at: {required: '上线时间为必填'},
                unstocked_at: {required: '下架时间为必填'},
            }
        });

        if($("form").valid()) {
            $('form').submit();
        } else {
          $.jBox("<center style='margin: 10px'>带<span class='required'>*</span>号为必填项</center>", {
              title: "<div class=ask_title>温馨提示</div>",
              height: 30,
              border: 5,
              showType: 'slide',
              opacity: 0.3,
              showIcon:false,
              top: '20%',
              loaded:function(){
                  $("body").css("overflow-y","hidden");
              },
              closed:function(){
                  $("body").css("overflow-y","auto");
              }
          });
        }
    });
});
</script>
@stop