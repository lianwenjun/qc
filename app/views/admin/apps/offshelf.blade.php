@extends('admin.layout')

@section('content')
<link href="{{ asset('css/admin/timepicker/jquery-ui-1.11.0.custom.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/admin/timepicker/jquery-ui-timepicker-addon.css') }}" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{{ asset('js/jquery-ui-1.8.23.custom.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-addon.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-zh-CN.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.pager.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/common.js') }}"></script>
<div class="Content_right_top Content_height">
   <div class="Theme_title">
      {{ Breadcrumbs::render('apps.offshelf') }}
   </div>
   <form action="{{ URL::route('apps.offshelf') }}" method="get">
      <div class="Theme_Search">
         <ul>
            <li>
               <span>
                  <b>查询：</b>
                  <select name="cate_id">
                     <option value="">--全部--</option>
                     @foreach($cates as $cate)
                     <option value="{{ $cate->id }}" @if(Input::get('cate_id') == $cate->id)selected="selected"@endif>{{ $cate->title }}</option>
                     @endforeach
                  </select>
               </span>
               <span>
                  <input name="title" type="text" class="Search_wenben" size="20" placeholder="请输入关键词" value="{{ Input::get('title') }}"/>
               </span>
               <span>　<b>日期：</b><input name="offshelfed_at[]" type="text" class="Search_wenben" value="{{ isset(Input::get('offshelfed_at')[0]) ? Input::get('offshelfed_at')[0] : '' }}"/><b>-</b><input name="offshelfed_at[]" type="text" class="Search_wenben" value="{{ isset(Input::get('offshelfed_at')[1]) ? Input::get('offshelfed_at')[1] : '' }}"/></span>
               <input type="submit" value="搜索" class="Search_en" />
            </li>
         </ul>
      </div>
   </form>
   <div class="Search_cunt">下架游戏：共 <strong>{{ $apps['total'] }}</strong> 条记录 </div>
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
            <td width="6%">游戏ID</td>
            <td width="9%">游戏名称</td>
            <td width="6%">图标</td>
            <td width="15%">包名</td>
            <td width="8%">游戏分类</td>
            <td width="6%">大小</td>
            <td width="6%">版本号</td>
            <td width="10%">上架时间</td>
            <td width="10%">下架时间</td>
            <td width="6%">操作人</td>
            <td width="8%">操作</td>
         </tr>
         @foreach($apps['data'] as $k => $app)
         <tr class="Search_biao_{{ $k%2 == 0 ? 'one' : 'two'}}">
            <td>{{ $app['id'] }}</td>
            <td>{{ $app['title'] }}</td>
            <td><img src="{{ asset($app['icon']) }}" width="28" height="28" /></td>
            <td>{{ $app['pack'] }}</td>
            <td>{{ !empty($app['cate_name']) ? $app['cate_name'] : '/' }}</td>
            <td>{{ $app['size'] }}</td>
            <td>{{ $app['version'] }}</td>
            <td>{{ $app['onshelfed_at'] != '0000-00-00 00:00:00' ? date('Y-m-d H:i', strtotime($app['onshelfed_at'])) : '' }}</td>
            <td>{{ $app['offshelfed_at'] != '0000-00-00 00:00:00' ? date('Y-m-d H:i', strtotime($app['offshelfed_at'])) : '' }}</td>
            <td>{{ isset($app['operator']) && !empty($app['operator']) ? $app['operator'] : '' }}</td>
            <td>
              <a href="{{ URL::route('apps.offshelf.edit', ['id' => $app['id'] ]) }}" target="BoardRight" class="Search_show">编辑</a>
            </td>
         </tr>
         @endforeach
         @if(empty($apps['total']))
            <tr class="no-data"><td colspan="11">没有数据</td></tr>
         @endif
      </table>
      @if($apps['last_page'] > 1)
        <div id="pager"></div>
      @endif
   </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
      // 日期控件
      $('input[name="offshelfed_at[]"]').datepicker({dateFormat: 'yy-mm-dd'});

      // 分页
      pageInit({{ $apps['current_page'] }}, {{ $apps['last_page'] }}, {{ $apps['total'] }});
    });
</script>
@stop