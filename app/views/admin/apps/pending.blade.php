@extends('admin.layout')

@section('content')
<link href="{{ asset('css/admin/timepicker/jquery-ui-1.11.0.custom.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/admin/timepicker/jquery-ui-timepicker-addon.css') }}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{ asset('js/jquery-ui-1.8.23.custom.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-addon.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-zh-CN.js') }}"></script>

<div class="Content_right_top Content_height">
   <div class="Theme_title">
      {{ Breadcrumbs::render('apps.pending') }}
   </div>
   <form action="{{ URL::route('apps.pending') }}" method="get">
        <div class="Theme_Search">
            <ul>
                <li>
                    <span><b>查询：</b>
                    <select name="cate_id">
                        <option value="">--全部--</option>
                        @foreach($cates as $cate)
                        <option value="{{ $cate->id }}" @if(Input::get('cate_id') == $cate->id)selected="selected"@endif>{{ $cate->title }}</option>
                        @endforeach
                    </select>
                    </span>
                    <span><input name="title" type="text" class="Search_wenben" size="20" placeholder="请输入关键词" value="{{ Input::get('title') }}"/></span>
                    <span>　<b>日期：</b><input name="start-updated_at" type="text" class="Search_wenben" value="{{ Input::get('start-updated_at') }}"/><b>-</b><input name="end-updated_at" type="text" class="Search_wenben" value="{{ Input::get('end-updated_at') }}"/></span>
                    <input type="submit" value="搜索" class="Search_en" />
                </li>
            </ul>
        </div>
    </form>
   <div class="Search_cunt">待审核游戏：共 <strong>{{ $apps->getTotal() }}</strong> 条记录 </div>
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
            <td width="4%">选择</td>
            <td width="6%">游戏ID</td>
            <td width="5%">图标</td>
            <td width="10%">游戏名称</td>
            <td width="12%">包名</td>
            <td width="7%">游戏分类</td>
            <td width="6%">大小</td>
            <td width="7%">版本号</td>
            <td width="7%">预览</td>
            <td width="7%">最后编辑时间</td>
            <td width="10%">操作</td>
         </tr>
         @foreach($apps as $k => $app)
         <tr class="Search_biao_{{ $k%2 == 0 ? 'one' : 'two'}}">
            <td><input name="id" type="checkbox" value="{{ $app->id }}" /></td>
            <td>{{ $app->id }}</td>
            <td><img src="{{ asset($app->icon) }}" width="28" height="28" /></td>
            <td>{{ $app->title }}</td>
            <td>{{ $app->pack }}</td>
            <td>/</td>
            <td>{{ $app->size }}</td>
            <td>{{ $app->version }}</td>
            <td><a href="javascript:;" data-id="{{ $app->id }}" class="Search_Look jq-preview">点击预览</a></td>
            <td>{{ date('Y-m-d H:i', strtotime($app->updated_at)) }}</td>
            <td><a href="{{ URL::route('apps.dopass', ['id' => $app->id]) }}" class="Search_show jq-dopass">通过</a> <a href="{{ URL::route('apps.donopass', ['id' => $app->id]) }}" class="Search_Notthrough jq-nopass">不通过</a></td>
         </tr>
         @endforeach
        @if(empty($apps->count()))
            <tr class="no-data"><td colspan="11">没有数据</td></tr>
        @endif
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
            <td class="DataCount_xuanze"><span><input name="" type="checkbox" value="" />全选</span><input name="" type="button" value="已选择全部通过" class="DataCount_button" /><input name="" type="button" value="已选择全部不通过" class="DataCount_button" /></td>
         </tr>
      </table>
      <div id="pager">
        @if($apps->getLastPage() > 1)
        {{ $apps->appends(Input::all())->links() }} 共: {{ $apps->getLastPage() }} 页 当前<input name="page" value="{{ $apps->getCurrentPage() }}" /><span class="jq-jump">GO</span>
        @endif
      </div>
   </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){

        // 日期选择器
        $('input[name="start-updated_at"], input[name="end-updated_at"]').datepicker({dateFormat: 'yy-mm-dd'});

        // 跳转页码
        $('.jq-jump').click(function() {
            var url = $(location).attr('href');;
            var pageNum = $('input[name="page"]').val();

            var sp = '?';
            if(/\?/.test(url)) {
                sp = '&';
            }

            var jumpUrl = url.replace(/&page=\d+/, "") + sp +'page=' + pageNum;

            location.href = jumpUrl;
        });

        // 审核通过
        $('.jq-dopass').click(function() {

            var link = $(this).attr('href');

            var f = document.createElement('form');
            $(this).after($(f).attr({
                method: 'post',
                action: link
            }).append('<input type="hidden" name="_method" value="PUT" />'));
            $(f).submit();
   
            return false;
        });

        // 审核不通过理由弹窗
        $('.jq-nopass').click(function() {
            var link = $(this).attr('href');
            $.jBox('<div class="Look_content"><ul>'+
                    '<li><input class="Look_input" name="reason" type="radio" value="恶意软件" />恶意软件</li>'+
                    '<li><input class="Look_input" name="reason" type="radio" value="游戏信息错误" />游戏信息错误</li>'+
                    '<li><input class="Look_input" name="reason" type="radio" value="other" />其它<input name="reasonText" type="text" size="30" class="Look_text" /></li>'+
               '</ul>'+
            '</div>', {
                title: "<div class='ask_title'>不通过原因</div>",
                showIcon: false,
                draggable: false,
                buttons: {'确定':true, "算了": false},
                submit: function(v, h, f) {

                    if(v) {
                        var reason = (f.reason == 'other') ? f.reasonText : f.reason;

                        if(typeof(reason) == 'undefined' || reason.length < 1) {
                            alert('请输入原因');

                            return false;
                        }
                        var form = document.createElement('form');

                        $(this).after($(form).attr({
                            method: 'post',
                            action: link
                        }).append('<input type="hidden" name="reason" value="'+reason+'" /><input type="hidden" name="_method" value="PUT" />'));
                        $(form).submit();
                    }
                }
            });

            return false;
        });
    });
</script>
@stop