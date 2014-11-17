@extends('admin.layout')

@section('content')
<link href="{{ asset('css/admin/timepicker/jquery-ui-timepicker-addon.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/admin/timepicker/jquery-ui-1.11.0.custom.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/admin/autocomplete/jquery-autocomplete.css') }}" rel="stylesheet" type="text/css" />

<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>广告位管理 <span>编辑精选管理</span><b>添加</b></h1></div>                
    <div class="Search_title">游戏信息</div>
    @if(Session::has('msg'))
    <div class="tips">
        <div class="fail">{{ Session::get('msg') }}</div>
    </div>
    @endif              
    <div class="Search_biao">
        <form action="{{ Request::url() }}" method="post">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="134" class="Search_lei"><span class="required">*</span>请输入游戏名称：</td>
                <td>
                    <select class="Search_select jq-select-autocate" name="autocate">
                                <option value="{{ route('searchapps').'?type=name' }}">游戏名称</option>
                                <option value="{{ route('searchapps').'?type=appid' }}">游戏ID</option>
                    </select>
                    <input maxlength="32" id="autocomplete" type="text" class="Search_text" placeholder="输入时自动匹配" style="width:25%" />
                </td>
            </tr>
            <input name="app_id" type="hidden" val="">
            <!--数据选择区开始-->
            <input name="title" type="hidden" val="">
            <tr>
                <td class="Search_lei">广告置顶：</td>
                <td>{{ Form::checkbox('is_top', 'yes', Session::get('input.is_top') ? true : false) }} 
                  是　<span style=" color:#C00">（置顶用于首页Banner的2条）</span></td>
            </tr>
            
            <tr>
                <td class="Search_lei"><span class="required">*</span>游戏截图：</td>
                <td><a id="browse" href="javascript:;" class="Search_Update">图片上传</a> <span class="jq-picTips" style="color:#C00">（置顶图229x129px，列表图452x236px）</span></td>
            </tr>
          
            <tr>
                <td class="Search_lei">截图预览：</td>
                <td class="Search_img">
                    <div class="Update_img">
                        <ul id="listdata">
                            <li>
                                <!--<a href="#">删除</a>-->
                                <img src="{{ Session::get('input.image', '') }}" />
                            </li>
                            <input name="image" type="hidden" value="{{ Session::get('input.image', '') }}" />
                        </ul>
                    </div>
                </td>
            </tr>
          
            <tr>
                <td class="Search_lei">广告词：</td>
                <td><input name="word" type="text" class="Search_text" value="{{ Session::get('input.word', '') }}" placeholder="" style="width:60%" /></td>
            </tr>
            <tr>
                <td  class="Search_lei">排序：</td>
                <td><input maxlength="6" name="sort" type="text" class="Search_input jq-edit-input" value="0" size="15" /></td>
            </tr>
            <tr>
                <td class="Search_lei"><span class="required">*</span>上线时间：</td>
                <td>
                    <h6>从 </h6> <h6><input type="text" name="stocked_at" class="Search_text jq-ui-timepicker" value="{{ Session::get('input.stocked_at', '') }}"></h6>
                    <h6> 到 </h6> <h6><input type="text" name="unstocked_at" class="Search_text jq-ui-timepicker" value="{{ Session::get('input.unstocked_at', '') }}"></h6>
                </td>
            </tr>
          
            <tr>
                <td colspan="2" align="center"  class="Search_submit">
                    <input class="jq-ads-create-submit" type="button" value="确定" />
                    <a href="{{ URL::route('editorads.index') }}" target=BoardRight>返回列表</a>
                </td>
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
<script src="{{ asset('js/admin/jquery.validate.min.js') }}" type="text/javascript"></script>
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
    $(".jq-edit-input").live('keyup', function(){    
            $(this).val(parseInt($(this).val().replace(/[^0-9.]+/g,'0').slice(0,6)));  
        }).bind("paste",function(){  //CTR+V事件处理    
            $(this).val(parseInt($(this).val().replace(/[^0-9.]+/g,'0').slice(0,6)));     
        }).css("ime-mode", "disabled");
    //自动匹配
    //切换
    AUTOURL = "{{ route('searchapps').'?type=name' }}";
    $('.jq-select-autocate').change(function(){
        $('#autocomplete').autocomplete({
            serviceUrl: $('.jq-select-autocate').val(),
            onSelect: function (suggestion) {
                getAppInfo(suggestion.data );
            }
        });
    });
    $('#autocomplete').autocomplete({
        serviceUrl: AUTOURL,
        onSelect: function (suggestion) {
            getAppInfo(suggestion.data );
        }
    });
    //返回判断
    var appId = "{{ Session::get('input.app_id', '') }}";
    if (appId !='' && appId != null && appId != undefined) {
        getAppInfo("{{ route('appsinfo', Session::get('input.app_id', '')) }}");
    }
    //时间插件
    $(".jq-ui-timepicker").datetimepicker({
            showSecond: true,
            timeFormat: 'HH:mm:ss',
            stepHour: 1,
            stepMinute: 10,
            stepSecond: 10
    });
    //图片上传
    var createUploader = function(uploadurl, pixel) {
        var uploader = new plupload.Uploader({ //实例化一个plupload上传对象
            browse_button : 'browse',
            url : uploadurl,
            runtimes: 'html5,flash',
            max_file_size : '1mb',
            
            flash_swf_url : '{{ asset("js/admin/plupload/Moxie.swf") }}',
            filters: { 
                mime_types : [ //只允许上传图片文件
                    { title : "图片文件", extensions : "jpg,gif,png" }
                ],
                file_pixel_size : pixel,
            },
            init: {
                Error: function(up, err) {
                    $('.jq-picTips').html(err.message);
                }
            }
        });

        //绑定文件添加进队列事件
        uploader.bind('FilesAdded',function(uploader,files) {
            for(var i = 0, len = files.length; i<len; i++) {
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
            if (myData.result) {
                $("#listdata li img").attr('src', myData.result.path);
                $("#listdata input[name=image]").val(myData.result.path);
            }
        });
        
        uploader.init();
        return uploader;
    }
    UPLOADURL = '{{ route("appsads.upload") }}';
    var theUploader = createUploader(UPLOADURL, '452x236');
    var destroy = function(pixel){
        if(theUploader) {
            theUploader.destroy();
        }
        theUploader = createUploader(UPLOADURL, pixel);
    }
    
    //首页选择，清空图片
    $( "input[name=is_top]" ).click(function() {
        if ($( "input[name=is_top]:checked").val()) {
            destroy('229x129');
            $('.jq-picTips').html('置顶图229x129px');
            $("#listdata li img").attr('src', '');
            $("#listdata input[name=image]").val('');
        } else {
            DEFAULT_PIXEL = '452x236';
            destroy(DEFAULT_PIXEL);
            $('.jq-picTips').html('列表图452x236px');
            $("#listdata li img").attr('src', '');
            $("#listdata input[name=image]").val('');
        }
    });
    // 图片大小限制
    plupload.addFileFilter('file_pixel_size', function(limitSize, file, cb) {
        var self = this, img = new o.Image();
        var sizes = limitSize.split('x');

        function finalize(result) {

            img.destroy();
            img = null;

            if (!result) {
                self.trigger('Error', {
                    code : plupload.IMAGE_DIMENSIONS_ERROR,
                    message : file.name + "图片规格应该为 " + limitSize  + " 像素.",
                    file : file
                });
            }
            cb(result);
        }

        img.onload = function() {
            finalize((img.width == sizes[0] && img.height == sizes[1]));
        };

        img.onerror = function() {
            finalize(false);
        };

        img.load(file.getSource());
    });

    
    // 提交表单
    $('.jq-ads-create-submit').click(function() {
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