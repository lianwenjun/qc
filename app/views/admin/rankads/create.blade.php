@extends('admin.layout')

@section('content')
<link href="{{ asset('css/admin/timepicker/jquery-ui-1.11.0.custom.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/admin/timepicker/jquery-ui-timepicker-addon.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/admin/autocomplete/jquery-autocomplete.css') }}" rel="stylesheet" type="text/css" />

<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>广告位管理 <span>排行游戏位管理</span><b>添加游戏</b></h1></div>
                     
    <div class="Search_title">游戏信息</div>
                     
    <div class="Search_biao">
        <form action="{{ Request::url('appsads.create') }}" method="post">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="134" class="Search_lei">请输入游戏名称：</td>
                <td>
                    <select class="Search_select jq-select-autocate" name="autocate">
                                <option value="{{ route('searchapps').'?type=name' }}">游戏名称</option>
                                <option value="{{ route('searchapps').'?type=appid' }}">游戏ID</option>
                    </select>
                    <input id="autocomplete" type="text" class="Search_text" style="width:25%" />　
                </td>
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
                <td  class="Search_lei">排序：</td>
                <td><input name="sort" type="text" class="Search_input" value="0" size="15" /></td>
            </tr>

            <tr>
                <td  class="Search_lei"><span class="required">*</span>上线时间：</td>
                <td>
                    <h6>从 </h6> <h6><input type="text" name="onshelfed_at" class="Search_text jq-ui-timepicker" value=""></h6>
                    <h6> 到 </h6> <h6><input type="text" name="offshelfed_at" class="Search_text jq-ui-timepicker" value=""></h6>
                </td>
            </tr>

            <tr>
            <td colspan="2" align="center"  class="Search_submit"><input name="" type="submit" value="提 交" /> <a href="{{ URL::route('rankads.index') }}" target=BoardRight>返回列表</a></td>
            </tr>

        </table>
        </form>
    </div>            
</div>
<script type="text/javascript" src="{{ asset('js/jquery-ui-1.8.23.custom.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-addon.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-zh-CN.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/jquery.autocomplete.js') }}"></script>
<script type="text/javascript">
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
    $(".jq-ui-timepicker").datetimepicker({
        showSecond: true,
        timeFormat: 'HH:mm:ss',
        stepHour: 1,
        stepMinute: 10,
        stepSecond: 10
    });
    $("tr:odd").addClass("Search_biao_two");
    $("tr:even").addClass("Search_biao_one");
    //自动匹配
    //切换
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
});
</script>
@stop