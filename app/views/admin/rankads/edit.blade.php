@extends('admin.layout')

@section('content')
<link href="{{ asset('css/admin/timepicker/jquery-ui-1.11.0.custom.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/admin/timepicker/jquery-ui-timepicker-addon.css') }}" rel="stylesheet" type="text/css" />
<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>广告位管理 <span>排行游戏位管理</span><b>添加游戏</b></h1></div>
                     
    <div class="Search_title">游戏信息</div>
    @if(Session::has('msg'))
    <div class="tips">
        <div class="fail">{{ Session::get('msg') }}</div>
    </div>
    @endif                
    <div class="Search_biao">
        <form action="{{ Request::url() }}" method="post">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <!--数据选择区开始-->
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
                <td>{{ $app->package }}</td>
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
            <!--数据选择区结束-->
            <tr>
                <td  class="Search_lei">广告区域：</td>
                <td>
                    <span style="float:left">
                          {{ Form::select('location', $location, $ad->location, ['class'=>'Search_select']); }}
                     </span>
                </td>
            </tr>

            <tr>
                <td  class="Search_lei">排序：</td>
                <td><input maxlength="6" name="sort" type="text" class="Search_input jq-edit-input" value="{{ $ad->sort }}" size="15" /></td>
            </tr>

            <tr>
                <td  class="Search_lei"><span class="required">*</span>上线时间：</td>
                <td>
                    <h6>从 </h6> <h6><input size="20" type="text" name="stocked_at" class="Search_text jq-ui-timepicker" value="{{ $ad->stocked_at }}"></h6>
                    <h6> 到 </h6> <h6><input size="20" type="text" name="unstocked_at" class="Search_text jq-ui-timepicker" value="{{ $ad->unstocked_at }}"></h6>
                </td>
            </tr>

            <tr>
                <td colspan="2" align="center"  class="Search_submit">
                    <input name="" type="submit" value="提 交" />
                    <a href="{{ URL::route('rankads.index') }}" target=BoardRight>返回列表</a>
                </td>
            </tr>

        </table>
        </form>
    </div>            
</div>
<script type="text/javascript" src="{{ asset('js/jquery-ui-1.8.23.custom.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-addon.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-zh-CN.js') }}"></script>
<script src="{{ asset('js/admin/common.js') }}" type="text/javascript"></script>

<script type="text/javascript">
$(function(){
    $("tr:odd").addClass("Search_biao_two");
    $("tr:even").addClass("Search_biao_one");
    
    $(".jq-ui-timepicker").datetimepicker({
        showSecond: true,
        timeFormat: 'HH:mm:ss',
        stepHour: 1,
        stepMinute: 10,
        stepSecond: 10
    });
});
</script>
@stop