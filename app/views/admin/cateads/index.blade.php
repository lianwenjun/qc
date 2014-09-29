@extends('admin.layout')

@section('content')
<script src="{{ asset('js/admin/plupload/plupload.full.min.js') }}" type="text/javascript"></script>
<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>广告位管理 <span>分类页图片位推广</span></h1></div>                
    <div class="Search_cunt" style="padding-top:15px;">共 <strong>{{ $cateads->getTotal() }}</strong> 条信息 </div>
                     
    <div class="Search_biao">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="Search_biao_title">
                <td width="10%">ID</td>
                <td width="25%">图片</td>
                <td width="25%">分类名称</td>
                <td width="20%">操作</td>
            </tr>
            @foreach($cateads as $catead)
                <tr class="jq-tr">
                    <td>{{ $catead->id }}</td>
                    <td><img src="{{ $catead->image ? $catead->image : '/images/admin/u1188.png' }}" width="28" height="28" /></td>
                    <td>{{ $catead->title }}</td>
                    <td><a href="javascript:;" target=BoardRight class="Search_show jq-cateads-upload">重新上传图片</a></td>
                    <input value="{{ URL::route('cateads.edit', $catead->id) }}" name="edit-url" type="hidden">
                    <input value="" name="upload-image" type="hidden">
                </tr>
            @endforeach
        </table>
        <div id="pager">{{ $cateads->links() }}</div>
    </div>               
</div>

<script>

$(function(){
    $(".jq-tr:odd").addClass("Search_biao_two");
    $(".jq-tr:even").addClass("Search_biao_one");
    $(".jq-cateads-upload").click(function() {
        //alert("更新图片");
        var tr = $(this).parents('tr');
        $.jBox("<div id='uploader'><p>您的浏览器不支持 html5 所以无法使用上传服务。</p></div>", {  
            title: "<div class=ask_title>分类图片上传</div>",  
            width: 400,  
            height: 300,
            border: 5,
            showType: 'slide', 
            opacity: 0.3,
            showIcon: false,
            top: '20%',
            loaded:function() {
                $("body").css("overflow-y","hidden");
                $(".jbox-content").html('<div class="jbox-waraper" style=""><div class="wraper"> <div class="btn-wraper">'+
                    '<input type="button" value="选择文件并上传" id="browse" /><input class="jq-cateads-sure" type="button" value="确定" id="upload-btn" />'+
                    '</div><ul id="file-list"></ul></div></div>');
                var uploader = new plupload.Uploader({ //实例化一个plupload上传对象
                    browse_button : 'browse',
                    url : '{{ route("cateads.upload") }}',
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
                        tr.find('input[name=upload-image]').val(myData.result);
                        var img = "<img src='" + myData.result + "''>";
                        $(".jbox-content").find("#file-list").html(img);
                    }
                });
                //点击确定
                $(".jq-cateads-sure").live('click', function(){
                    var image = tr.find('input[name=upload-image]').val();
                    var url = tr.find('input[name=edit-url]').val();
                    $.post(url, {image:image}, function(res) {
                        //如果返回结果成功，关闭上传页面并替换掉原图
                        if (res.status == 'ok'){
                            uploader.destroy();
                            
                        }
                    });
                });
            },
            closed:function() {
               $("body").css("overflow-y","auto");
               uploader.destroy();
               //location.href = location.href;
            }
        });
    });
    
});
</script>
@stop