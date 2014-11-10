@extends('admin.layout')

@section('content')

<link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/owl.theme.css') }}" rel="stylesheet" type="text/css" />

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
      {{ Breadcrumbs::render('apps.history') }}
   </div>
   <form action="{{ URL::route('apps.history', ['id' => $id]) }}" method="get">
      <div class="Theme_Search">
         <ul>
            <li>
               <span>
                  <b>查询：</b>
               </span>
               <span>
                  <input name="pack" type="text" class="Search_wenben" size="20" placeholder="包名" value="{{ Input::get('pack') }}"/>
               </span>
               <input type="submit" value="搜索" class="Search_en" />
            </li>
         </ul>
      </div>
   </form>
   <div class="Search_biao">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr class="Search_biao_title">
            <td width="6%">游戏ID</td>
            <td width="4%">图标</td>
            <td width="8%">游戏名称</td>
            <td width="12%">包名</td>
            <td width="7%">游戏分类</td>
            <td width="5%">大小</td>
            <td width="6%">版本号</td>
            <td width="7%">预览</td>
            <td width="8%">上架时间</td>
            <td width="7%">下架时间</td>
            <td width="18%">操作人</td>
         </tr>
         @foreach($apps['data'] as $k => $app)
         <tr class="Search_biao_{{ $k%2 == 0 ? 'one' : 'two'}}">
            <td>{{ $app['id'] }}</td>
            <td><img src="{{ asset($app['icon']) }}" width="28" height="28" /></td>
            <td>{{ $app['title'] }}</td>
            <td>{{ $app['pack'] }}</td>
            <td>{{ !empty($app['cat_name']) ? $app['cat_name'] : '/' }}</td>
            <td>{{ $app['size'] }}</td>
            <td>{{ $app['version'] }}</td>
            <td><a href="javascript:;" data-id="{{ $app['id'] }}" data-type="history" class="Search_Look jq-preview">预览</a></td>
            <td>{{ $app['stocked_at'] != '0000-00-00 00:00:00' ? date('Y-m-d H:i', strtotime($app['stocked_at'])) : '' }}</td>
            <td>{{ $app['unstocked_at'] != '0000-00-00 00:00:00' ? date('Y-m-d H:i', strtotime($app['unstocked_at'])) : '' }}</td>
            <td> {{ isset($app['operator']) ? $app['operator'] : '' }} </td>
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

    // 分页
    pageInit({{ $apps['current_page'] }}, {{ $apps['last_page'] }}, {{ $apps['total'] }});

   });

</script>
@stop