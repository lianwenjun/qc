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
                        <td>{{ $app->pack }}</td>
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

    // 提交表单
    $('.jq-ads-edit-submit').click(function() {
        // 验证
        $("form").validate({
            ignore: '',
            rules: {
                app_id: "required",
                stocked_at: "required",
                unstocked_at: "required",
            },
            messages: {
                app_id: {required: '游戏为必填'},
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