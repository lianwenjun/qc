@extends('admin.layout')

@section('content')
<link href="{{ asset('css/admin/timepicker/jquery-ui-1.11.0.custom.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/admin/timepicker/jquery-ui-timepicker-addon.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/admin/autocomplete/jquery-autocomplete.css') }}" rel="stylesheet" type="text/css" />

<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>广告位管理 <span>首页游戏位管理</span><b>添加游戏</b></h1></div>
    
    <div class="Search_title">游戏信息</div>
    <!-- 提示 -->
    @if(Session::has('msg'))
    <div class="tips">
        <div class="fail">{{ Session::get('msg') }}</div>
    </div>
    @endif
    <!-- /提示 -->
    <div class="Search_biao">
            <form action="{{ Request::url('appsads.create') }}" method="post">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="134" class="Search_lei">
                            <span class="required">*</span>
                            请输入游戏名称：
                        </td>
                        <td><select class="Search_select jq-select-autocate" name="autocate">
                                <option value="{{ route('searchapps').'?type=name' }}">游戏名称</option>
                                <option value="{{ route('searchapps').'?type=appid' }}">游戏ID</option>
                            </select>
                            <input id="autocomplete" maxlength="32" type="text" class="Search_text jq-searchapps" placeholder="输入时自动匹配" style="width:25%" />
                        </td>
                    </tr>
                    <input name="app_id" type="hidden" val="">
                    <!--数据选择区开始-->
                    <input name="title" type="hidden" val="">
                    <tr>
                        <td class="Search_lei"><span class="required">*</span>广告区域：</td>
                        <td>
                        <span style="float:left">
                            {{ Form::select('location', $location, Session::get('input.location', ''), ['class'=>'Search_select']); }}
                         </span>
                       </td>
                    </tr>

                    <tr>
                        <td class="Search_lei">广告置顶：</td>
                        <td>
                            {{ Form::checkbox('is_top', 'yes', Session::get('input.is_top') ? true : false) }} 
                          是　<span style=" color:#C00">（选中后无论上架广告数量，该广告均会在轮播中出现）</span></td>
                    </tr>

                    <tr>

                        <td class="Search_lei"><span class="required">*</span>上线时间：</td>
                        <td>
                            <h6>从 </h6> <h6><input type="text" name="stocked_at" class="Search_text jq-ui-timepicker" value="{{ Session::get('input.stocked_at', '') }}"></h6>
                            <h6> 到 </h6> <h6><input type="text" name="unstocked_at" class="Search_text jq-ui-timepicker" value="{{ Session::get('input.unstocked_at', '')}}"></h6></td>
                    </tr>

                    <tr>
                        <td colspan="2" align="center"  class="Search_submit"><input class="jq-ads-create-submit" type="button" value="提 交" /> <a href="{{ URL::route('appsads.index') }}" target=BoardRight>返回列表</a></td>
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
    //自动匹配
    AUTOURL = "{{ route('searchapps').'?type=name' }}";
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

    // 提交表单
    $('.jq-ads-create-submit').click(function() {
        // 验证
        $("form").validate({
            ignore: '',
            rules: {
                app_id: "required",
                location: "required",
                stocked_at: "required",
                unstocked_at: "required",
            },
            messages: {
                app_id: {required: '游戏为必填'},
                location: {required: '分类为必填'},
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