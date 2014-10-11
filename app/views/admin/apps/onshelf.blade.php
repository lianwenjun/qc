@extends('admin.layout')

@section('content')

<link href="{{ asset('css/admin/timepicker/jquery-ui-1.11.0.custom.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/admin/timepicker/jquery-ui-timepicker-addon.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/owl.theme.css') }}" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{{ asset('js/jquery-ui-1.8.23.custom.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-addon.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-zh-CN.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jurlp.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/owl.carousel.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.pager.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/common.js') }}"></script>

<!-- 预览 -->
<div class="Browse_bottom jq-previewWindow" style="display:none">
   <div class="Browse_phone">
      <div class="Browse_down"><a href="javascript:closePreview();">退出浏览</a></div>
      <div class="preview-title-html Browse_centent_title"></div>
      <div class="Browse_centent">
         <ul>
            <li class="Browse_centent_lei hover_lei">游戏详情</li>
            <li class="Browse_centent_lei">玩家评论</li>
            <div class="clear"></div>
            <li class="Browse_centent_apk">
               <div class="Browse_centent_img"><img class="preview-icon-src" src="" width="47" height="47" /></div>
               <div class="Browse_centent_text">
                  <ul>
                     <li class="preview-title-html Browse_centent_text_title"></li>
                     <li class="Browse_centent_text_shuo">
                         <span class="preview-star-loop" data-time="">
                            <img src="{{ asset('images/star.jpg') }}"/><img src="{{ asset('images/star.jpg') }}"/><img src="{{ asset('images/star.jpg') }}"/><img src="{{ asset('images/star.jpg') }}"/><img src="{{ asset('images/star.jpg') }}"/>
                        </span>
                        <span class="preview-version-html"></span>版本
                        <span class="preview-size-html"></span>
                     </li>
                     <li class="Browse_centent_text_shuo">
                        <span>
                        总下载：<span class="preview-download_manual-html"></span><span class="preview-updated_at-html"></span>更新</span>
                     </li>
                     <li class="Browse_centent_text_guan">
                        <span><img class="preview-has_ad-src" src="" data-template="{{ asset('images/{val}.jpg') }}"/>无广告</span> <img src="" data-template="{{ asset('images/{val}.jpg') }}" class="preview-is_verify-src"  />安全认证
                     </li>
                  </ul>
               </div>
            </li>
            <li class="Browse_centent_shot">
               <b>游戏截图</b>
               <div class="frotpage-demo margin-top">
                  <div class="row">
                     <div class="large-12 columns">
                        <div class="preview-images-loop owl-carousel" data-template="<div class='article'><img src='{val}' width='134'></div>">
                        </div>
                     </div>
                  </div>
               </div>
            </li>
            <li class="Browse_centent_about">
               <b>简介</b>
               <span class="preview-summary-html"></span>
            </li>
            <li class="Browse_centent_about">
               <b>同作者游戏</b>
               <div class="preview-sameAuthor-loop" data-template="<div class='Browse_centent_Browse'><ul><li class='Browse_centent_Browse_apk'><img src='{icon}' width='60' height='60' /></li><li class='Browse_centent_text'>{title}</li></ul></div>" data-fields="['icon', 'title']">
               </div>
            </li>
            <li class="Browse_centent_about">
               <b>同类游戏</b>
               <div class="preview-sameCate-loop" data-template="<div class='Browse_centent_Browse'><ul><li class='Browse_centent_Browse_apk'><img src='{icon}' width='60' height='60' /></li><li class='Browse_centent_text'>{title}</li></ul></div>" data-fields="['icon', 'title']">
               </div>
            </li>
            <li class="Browse_centent_about">
               <b>游戏标签</b>
               <div class="preview-tags-loop Browse_centent_biao" data-template="<h2>{title}</h2>" data-fields="['title']"></div>
            </li>
         </ul>
      </div>
   </div>
</div>
<!--/ 预览 -->

<div class="Content_right_top Content_height">
   <div class="Theme_title">
      {{ Breadcrumbs::render('apps.onshelf') }}
   </div>
   <form action="{{ URL::route('apps.onshelf') }}" method="get">
      <div class="Theme_Search">
         <ul>
            <li>
               <span>
                  <b>查询：</b>
                  <select name="type">
                     <option value="">--全部--</option>
                     <option value="title" @if(Input::get('type') == 'title')selected="selected"@endif>游戏名称</option>
                     <option value="pack" @if(Input::get('type') == 'pack')selected="selected"@endif>游戏包名</option>
                     <option value="tag" @if(Input::get('type') == 'tag')selected="selected"@endif>! 游戏标签</option>
                     <option value="cate" @if(Input::get('type') == 'cate')selected="selected"@endif>! 游戏分类</option>
                     <option value="version" @if(Input::get('type') == 'version')selected="selected"@endif>游戏版本号</option>
                  </select>
               </span>
               <span>
                  <input name="keyword" type="text" class="Search_wenben" size="20" placeholder="请输入关键词" value="{{ Input::get('keyword') }}"/>
               </span>
               <span>　<b>安装包大小：</b><input name="size_int[]" type="text" placeholder="10k" style="width: 80px" class="Search_wenben" value="{{ isset(Input::get('size_int')[0]) ? Input::get('size_int')[0] : '' }}"/><b>-</b><input name="size_int[]" type="text" placeholder="10m" style="width: 80px" class="Search_wenben" value="{{ isset(Input::get('size_int')[1]) ? Input::get('size_int')[1] : '' }}"/></span>
               <span>　<b>日期：</b><input name="onshelfed_at[]" type="text" class="Search_wenben" value="{{ isset(Input::get('onshelfed_at')[0]) ? Input::get('onshelfed_at')[0] : '' }}"/><b>-</b><input name="onshelfed_at[]" type="text" class="Search_wenben" value="{{ isset(Input::get('onshelfed_at')[1]) ? Input::get('onshelfed_at')[1] : '' }}"/></span>
               <input type="submit" value="搜索" class="Search_en" />
            </li>
         </ul>
      </div>
   </form>
   <div class="Search_cunt">上架游戏：共 <strong>{{ $apps['total'] }}</strong> 条记录 </div>
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
            <td width="4%">图标</td>
            <td width="8%">游戏名称</td>
            <td width="12%">包名</td>
            <td width="7%">游戏分类</td>
            <td width="5%" style="cursor:pointer" class="jq-sort" data-field='size_int' data-order='' data-title="大小">大小↑↓</td>
            <td width="6%">版本号</td>
            <td width="7%">预览</td>
            <td width="7%" style="cursor:pointer" class="jq-sort" data-field='download_counts' data-order='' data-title="下载量">下载量↑↓</td>
            <td width="8%" style="cursor:pointer" class="jq-sort" data-field='onshelfed_at' data-order='' data-title="上架时间">上架时间↑↓</td>
            <td width="18%">操作</td>
         </tr>
         @foreach($apps['data'] as $k => $app)
         <tr class="Search_biao_{{ $k%2 == 0 ? 'one' : 'two'}}">
            <td>{{ $app['id'] }}</td>
            <td><img src="{{ asset($app['icon']) }}" width="28" height="28" /></td>
            <td>{{ $app['title'] }}</td>
            <td>{{ $app['pack'] }}</td>
            <td>{{ !empty($app['cate_name']) ? $app['cate_name'] : '/' }}</td>
            <td>{{ $app['size'] }}</td>
            <td>{{ $app['version'] }}</td>
            <td><a href="javascript:;" data-id="{{ $app['id'] }}" class="Search_Look jq-preview">点击预览</a></td>
            <td>{{ $app['download_counts'] }}</td>
            <td>{{ date('Y-m-d H:i', strtotime($app['onshelfed_at'])) }}</td>
            <td><a href="{{ URL::route('apps.dooffshelf', ['id' => $app['id']]) }}" class="Search_show jq-dooffshelf">下架</a> <a href="{{ URL::route('apps.edit', ['id' => $app['id'] ]) }}" target="BoardRight" class="Search_show">编辑</a> <a href="{{ URL::route('apps.history', ['id' => $app['id'] ]) }}" target="BoardRight" class="Search_show">历史</a> </td>
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

   // 预览图片滑动初始化
   PREVIEW_URL = '{{ URL::route('apps.preview') }}';
   var initOwl = false;

   $(document).ready(function(){
      // 日期控件
      $('input[name="onshelfed_at[]"]').datepicker({dateFormat: 'yy-mm-dd'});

      // 下架
      $('.jq-dooffshelf').click(function() {
        var link = $(this).attr('href');
        $.jBox("<p style='margin: 10px'>您要下架吗？</p>", {
          title: "<div class='ask_title'>下架游戏</div>",
          showIcon: false,
          draggable: false,
          buttons: {'确定':true, "算了": false},
          submit: function(v, h, f) {

            if(v) {
              var form = document.createElement('form');

              $(this).after($(form).attr({
                method: 'post',
                action: link
              }).append('<input type="hidden" name="_method" value="PUT" />'));
              $(form).submit();
            }
          }
        });

        return false;
      });

      // 排序
      $('.jq-sort').click(function() {
        // initSort();

        var order = '';
        if($(this).attr('data-order') == '') {
          order = 'desc';
        } else {
          order = $(this).attr('data-order');
        }

        var field = $(this).attr('data-field');

        var sp = '&';
        if(/\?orderby/.test($(location).attr('href')) || !/\?/.test($(location).attr('href'))) {
          var sp = '?';
        }

        var url = $.jurlp($(location).attr('href'));

        var orderStr = url.query().orderby;
        var newurl = $(location).attr('href');
        if(typeof(orderStr) != 'undefined') {
           newurl = $(location).attr('href').replace(sp+'orderby='+orderStr, '');
        }

        location.href = newurl + sp + 'orderby=' + field + '.' + order;
      });

    // 分页
    pageInit({{ $apps['current_page'] }}, {{ $apps['last_page'] }}, {{ $apps['total'] }});

    initSort();
   });

   /**
    * 初始化排序dom
    */
   function initSort()
   {
      var url = $.jurlp($(location).attr('href'));

      var orderStr = url.query().orderby;

      if(typeof(orderStr) != 'undefined') {
        var orderArr = orderStr.split('.');
        $('.jq-sort').each(function() {
          if($(this).attr('data-field') == orderArr[0]) {
              if(orderArr[1] == 'desc') {
                $(this).attr('data-order', 'asc');
                $(this).html($(this).attr('data-title') + '↓');
              } else {
                $(this).attr('data-order', 'desc');
                $(this).html($(this).attr('data-title') + '↑');
              }
          }
        });
      }
   }
</script>
@stop