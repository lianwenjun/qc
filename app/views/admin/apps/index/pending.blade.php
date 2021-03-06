@extends('admin.layout')

@section('content')

<link href="{{ asset('css/admin/timepicker/jquery-ui-1.11.0.custom.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/admin/timepicker/jquery-ui-timepicker-addon.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/owl.theme.css') }}" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="{{ asset('js/jquery-ui-1.8.23.custom.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-addon.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-zh-CN.js') }}"></script>
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
                            <img src="{{ asset('images/star.jpg') }}"/>
                        </span>
                        <span class="preview-version-html"></span>版本
                        <span class="preview-size-html"></span>
                     </li>
                     <li class="Browse_centent_text_shuo">
                        <span>
                        总下载：<span class="preview-download_manual-html"></span><span class="preview-updated_at-html"></span>更新</span>
                     </li>
                     <li class="Browse_centent_text_guan">
                        <span><img class="preview-has_ad-src" src="" data-template="{{ asset('images/{val}.jpg') }}"/>无广告</span> <img src="" data-template="{{ asset('images/{val}.jpg') }}" class="preview-is_verify-src"/>安全认证
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
      {{ Breadcrumbs::render('apps.pending') }}
   </div>
   <form action="{{ URL::route('apps.pending') }}" method="get">
        <div class="Theme_Search">
            <ul>
                <li>
                    <span><b>查询：</b>
                    <select name="cat_id">
                        <option value="">--全部--</option>
                        @foreach($cats as $cat)
                        <option value="{{ $cat->id }}" @if(Input::get('cat_id') == $cat->id)selected="selected"@endif>{{ $cat->title }}</option>
                        @endforeach
                    </select>
                    </span>
                    <span>
                        <input name="title" type="text" class="Search_wenben" size="20" placeholder="请输入关键词" value="{{ Input::get('title') }}"/>
                    </span>
                    <span><input type="text" class="Search_wenben" name="pack" placeholder="请输入包名" value="{{ Input::get('pack') }}"></span>
                    <span>　<b>日期：</b><input name="updated_at[]" type="text" class="Search_wenben" value="{{ isset(Input::get('updated_at')[0]) ? Input::get('updated_at')[0] : '' }}"/><b>-</b><input name="updated_at[]" type="text" class="Search_wenben" value="{{ isset(Input::get('updated_at')[1]) ? Input::get('updated_at')[1] : '' }}"/></span>
                    <input type="submit" value="搜索" class="Search_en" />
                </li>
            </ul>
        </div>
    </form>
   <div class="Search_cunt">待审核游戏：共 <strong>{{ $apps['total'] }}</strong> 条记录 </div>
   <!-- 提示 -->
    @if(Session::has('tips'))
    <div class="tips">
        <div class="{{ Session::get('tips')['success'] ? 'success' : 'fail' }}">{{ Session::get('tips')['message'] }}</div>
    </div>
    @endif
    <!-- /提示 -->
   <div class="Search_biao">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="jq-table">
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
         @foreach($apps['data'] as $k => $app)
         <tr class="Search_biao_{{ $k%2 == 0 ? 'one' : 'two'}}">
            <td><input name="ids[]" type="checkbox" value="{{ $app['id'] }}" /></td>
            <td>{{ $app['id'] }}</td>
            <td><img src="{{ asset($app['icon']) }}" width="28" height="28" /></td>
            <td>{{ $app['title'] }}</td>
            <td>{{ $app['pack'] }}</td>
            <td>{{ !empty($app['cat_name']) ? $app['cat_name'] : '/' }}</td>
            <td>{{ $app['size'] }}</td>
            <td>{{ $app['version'] }}</td>
            <td><a href="javascript:;" data-id="{{ $app['id'] }}" class="Search_Look jq-preview">预览</a></td>
            <td>{{ date('Y-m-d H:i', strtotime($app['updated_at'])) }}</td>
            <td>
                @if(Sentry::getUser()->hasAccess('apps.putStock'))
                <a href="{{ URL::route('apps.putStock', ['ids[]' => $app['id']]) }}" class="Search_show jq-putStock">通过</a>
                @endif
                @if(Sentry::getUser()->hasAccess('apps.putNotpass'))
                <a href="{{ URL::route('apps.putNotpass', ['ids[]' => $app['id']]) }}" class="Search_Notthrough jq-putNotpass">不通过</a>
                @endif
            </td>
         </tr>
         @endforeach
        @if(empty($apps['total']))
            <tr class="no-data"><td colspan="11">没有数据</td></tr>
        @endif
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
            <td class="DataCount_xuanze">
                <span><input class="jq-checkAll" type="checkbox"/>全选</span>
                @if(Sentry::getUser()->hasAccess('apps.putStock'))
                <input type="button" value="已选择全部通过" class="jq-putAllStock DataCount_button" />
                @endif
                @if(Sentry::getUser()->hasAccess('apps.putNotpass'))
                <input type="button" value="已选择全部不通过" class="jq-putAllNotpass DataCount_button" />
                @endif
            </td>
         </tr>
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

        // 时间输入框
        $('input[name="updated_at[]"]').datepicker({dateFormat: 'yy-mm-dd'});

        // 审核通过
        $('.jq-putStock').click(function() {

            var link = $(this).attr('href');

            var f = document.createElement('form');
            $(f).css('display', 'none');
            $(this).after($(f).attr({
                method: 'post',
                action: link
            }).append('<input type="hidden" name="_method" value="PUT" />'));
            $(f).submit();

            return false;
        });

        // 审核不通过理由弹窗
        $('.jq-putNotpass').click(function() {
            var $this = $(this);
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
                        $(form).css('display', 'none');

                        $this.after($(form).attr({
                            method: 'post',
                            action: link
                        }).append('<input type="hidden" name="reason" value="'+reason+'" /><input type="hidden" name="_method" value="PUT" />'));
                        $(form).submit();
                    }
                }
            });

            return false;
        });

        // 全选/取消全选
        $('.jq-checkAll').click(function(){

            var $this = $(this);
            if($this.attr('checked') == 'checked') {
                $('.jq-table').find('tr:gt(0)').find('td:first').find('input:checkbox').attr('checked', 'checked');
            } else {
                $('.jq-table').find('tr:gt(0)').find('td:first').find('input:checkbox').attr('checked', false);
            }
        });

        // 全部通过
        $('.jq-putAllStock').click(function() {

            if(!valiCheckbox('ids[]')) {
                alert('请先选择游戏');
            } else {

                var ids = [];
                $('input[type="checkbox"][name="ids[]"]:checked').each(function() {
                    ids.push($(this).val());
                });

                var form = document.createElement('form');
                $(this).after($(form).attr({
                            method: 'post',
                            action: '{{ URL::route('apps.putStock') }}'
                }));

                for(idx in ids) {
                    $(form).append('<input type="hidden" name="ids[]" value="'+ids[idx]+'" />');
                }
                $(form).append('<input type="hidden" name="_method" value="PUT" />');

                $(form).submit();
            }

        });

        // 全部不通过
        $('.jq-putAllNotpass').click(function() {
            var $this = $(this);
            if(!valiCheckbox('ids[]')) {
                alert('请先选择游戏');
            } else {

                var ids = [];
                $('input[type="checkbox"][name="ids[]"]:checked').each(function() {
                    ids.push($(this).val());
                });

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
                            $this.after($(form).attr({
                                        method: 'post',
                                        action: '{{ URL::route('apps.putNotpass') }}'
                            }));

                            for(idx in ids) {
                                $(form).append('<input type="hidden" name="ids[]" value="'+ids[idx]+'" />');
                            }
                            $(form).append('<input type="hidden" name="reason" value="'+reason+'" />');
                            $(form).append('<input type="hidden" name="_method" value="PUT" />');

                            $(form).submit();
                        }
                    }
                });

            }

        });

        // 分页
        pageInit({{ $apps['current_page'] }}, {{ $apps['last_page'] }}, {{ $apps['total'] }});
    });

    /**
     * 检查checkbox是否选择
     *
     * @param name string checkbox名称
     *
     * @return boolean
     */
     function valiCheckbox(name)
     {
        var isChecked = false;
        $('input[type="checkbox"][name="'+name+'"]').each(function() {
            if($(this).attr('checked') == 'checked') {
                isChecked = true;
            }
        });

        return isChecked;
     }
</script>
@stop