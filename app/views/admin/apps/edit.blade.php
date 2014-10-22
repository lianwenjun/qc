@extends('admin.layout')

@section('content')
<link href="{{ asset('css/admin/select2.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('js/admin/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/admin/select2_locale_zh-CN.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/admin/plupload/plupload.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/admin/tinymce/tinymce.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/admin/tinymce/jquery.tinymce.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/admin/jquery-sortable.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/admin/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/admin/additional-methods.min.js') }}" type="text/javascript"></script>
<script>
tinymce.init({
    selector: "textarea",
    theme: "modern",
    width: '100%',
    height: '100%',
    language: 'zh_CN',
    plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         "save table contextmenu directionality emoticons template paste textcolor"
   ],
   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor ",
   style_formats: [
        {title: 'Bold text', inline: 'b'},
        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
        {title: 'Example 1', inline: 'span', classes: 'example1'},
        {title: 'Example 2', inline: 'span', classes: 'example2'},
        {title: 'Table styles'},
        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
    ]
 });
</script>
<style>
body.dragging, body.dragging * {
  cursor: move !important;
}
.dragged {
  position: absolute;
  opacity: 0.5;
  z-index: 2000;
}

ul.ui-sortable li.placeholder {
  position: relative;
}
ul.ui-sortable li.placeholder:before {
  position: absolute;
}
.required {color:red;}

.jq-initTags h2 {
  position: relative;
  padding-right: 14px;
  padding-left: 14px;
}
.jq-initTags h2:after{
  content: "x";
  top: -5px;
  right: 3px;
  position: absolute;
  font-family: fantasy;
  color: #F66;
}
</style>
<div class="Content_right_top Content_height">
   <div class="Theme_title">
      {{ Breadcrumbs::render('apps.edit') }}
   </div>
   <!-- 提示 -->
    @if(Session::has('tips'))
    <div class="tips">
        <div class="{{ Session::get('tips')['success'] ? 'success' : 'fail' }}">{{ Session::get('tips')['message'] }}</div>
    </div>
    @endif
    <!-- /提示 -->
   <div class="Search_title">游戏信息</div>
   <div class="Search_biao">
      <form id="form" method="post" action="">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tbody>
            <tr class="Search_biao_one">
               <td width="101" class="Search_lei">游戏ID：</td>
               <td width="1489">{{ $app->id }}</td>
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei">游戏名称：</td>
               <td class="upload-title-html">{{ $app->title }}</td>
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei">包名：</td>
               <td class="upload-pack-html">{{ $app->pack }}</td>
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei">大小：</td>
               <td class="upload-size-html">{{ $app->size }}</td>
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei">版本号：</td>
               <td class="upload-version-html">{{ $app->version }}</td>
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei">上传时间：</td>
               <td>{{ $app->created_at }}</td>
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei">上传新版本：</td>
               <td class="Search_apk"><span id="container"><a href="javascript:;" class="Search_Update" {{ Sentry::getUser()->hasAccess('apps.appupload') ? 'id="jq-uploadApp"':''}} >选择APK</a><span id="uploadInfo"></span></span><img class="upload-icon-src" src="{{ $app->icon }}" width="90" height="90"></td>
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei">游戏关键字：</td>
               <td><input name="keywords" type="text" value="" class="Search_text jq-initKeyword"></td>
            </tr>
            <tr class="Search_biao_one">
                <td  class="Search_lei"><span class="required">*</span>游戏分类：</td>
                <td>
                    <span style="float:left; line-height:26px; padding-right:8px;" class="jq-initCates">
                        <?php $split = ''; $catesText = ''; $catesInput = ''; ?>
                        @foreach($app->cates as $cate)
                            <?php $catesText .=  $split.$cate->title; ?>
                            <?php $catesInput .= "<input name='cates[]' value='".$cate->id."'>"; ?>
                            <?php $split = ', '; ?>
                        @endforeach
                        {{ $catesText }}
                    </span>
                    <input name="checkCate" type="hidden" value="{{ $catesText }}"/><!-- 验证用 -->
                    <span style="float:left;"><a href="javascript:;" class="Search_en jq-cates">修改</a></span>
                </td>
            </tr>

            <tr class="Search_biao_two">
               <td class="Search_lei"><span class="required">*</span>游戏标签：</td>
               <td>
                  <span style="float:left; line-height:26px; padding-right: 0; background: none; margin-top:0; border: 0px" class="jq-initTags Browse_centent_about">
                        <?php $split = ''; $tagsText = ''; ?>
                        @foreach($app->tags as $tag)
                            <?php $tagsText .=  $split.$tag->title; ?>
                            <?php $catesInput .= "<input name='cates[]' value='".$tag->id."'>"; ?>
                            <?php $split = '</h2>, <h2>'; ?>
                        @endforeach
                        {{ '<h2>' . $tagsText  . '</h2>' }}
                  </span>
                  <input name="checkTag" type="hidden" value="{{ $tagsText }}"/><!-- 验证用 -->
               </td>
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei"><span class="required">*</span>游戏作者：</td>
               <td><input name="author" type="text" value="{{ $app->author }}" class="Search_text"></td>
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei">是否无广告：</td>
               <td><label><input type="checkbox" name="has_ad" value="yes" @if($app->has_ad == 'yes')checked="checked"@endif class="Search_checkbox">勾选表示无广告</label></td>
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei">是否安全认证：</td>
               <td><lable><input type="checkbox" name="is_verify" value="yes" @if($app->is_verify == 'yes')checked="checked"@endif  class="Search_checkbox">勾选表示已认证</lable></td>
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei"><span class="required">*</span>系统要求：</td>
               <td>
                  <select name="os" class="Search_select">
                     <option value="Android">Android</option>
                  </select>
                  <input name="os_version" type="text" class="Search_input" value="{{ $app->os_version }}" size="8">
                  以上
               </td>
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei"><span class="required">*</span>包名：</td>
               <td>
                  <input name="version_code" type="text" value="{{ $app->version_code }}" class="upload-version_code-val Search_text">
               </td>
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei"><span class="required">*</span>排序：</td>
               <td>
                  <input name="sort" type="text" value="{{ $app->sort }}" class="Search_input">
               </td>
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei"><span class="required">*</span>下载次数：</td>
               <td>
                  <input name="download_manual" type="text" value="{{ $app->download_manual }}" class="Search_input">
               </td>
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei"><span class="required">*</span>游戏简介：</td>
               <td><textarea name="summary" id="summary" class="Search_textarea" cols="" rows="">{{ $app->summary }}</textarea>
               </td>
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei"><span class="required">*</span>游戏截图：</td>
               <td><a href="javascript:;" class="Search_Update" id="jq-uploadPic">图片上传</a> <span style="color:#C00" class="jq-picTips">最多可选择6张，图片规格为220*370px 的JPG/PNG</span></td>
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei">截图预览：</td>
               <td class="Search_img">
                  <div class="Update_img">
                     <ul class="ui-sortable jq-pictures">
                        @if(is_array($app->images))
                            @foreach($app->images as $image)
                            <li><img src="{{ $image }}"><input name="images[]" value="{{ $image }}" type="hidden"/><a class="jq-picDelete dragged" href="javascript:;">删除</a></li>
                            @endforeach
                        @endif
                        <input name="images[]" value="" type="hidden"/><!-- 验证用 -->
                     </ul>
                  </div>
               </td>
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei">新版特性：</td>
               <td><textarea name="changes" id="changes" class="Search_textarea">{{ $app->changes }}</textarea>
               </td>
            </tr>
            <tr class="Search_biao_one">
               <td colspan="2" align="center" class="Search_submit">
                  @if($app->status == 'new' || $app->status == 'draft')
                  <a href="javascript:;" class="jq-submitDraft" data-action="{{ URL::route('apps.draft.edit', ['id' => $app->id]) }}">存为草搞件</a>
                  <a href="javascript:;" data-action="{{ URL::route('apps.pending.edit', ['id' => $app->id]) }}" class="jq-submit">提 交</a>
                  @elseif($app->status == 'onshelf')
                  <a href="javascript:;" data-action="{{ URL::route('apps.onshelf.edit', ['id' => $app->id]) }}" class="jq-submit">提 交</a>
                  @elseif($app->status == 'nopass' || $app->status == 'offshelf')
                  <a href="javascript:;" data-action="{{ URL::route('apps.pending.edit', ['id' => $app->id]) }}" class="jq-submit">提交待审核列表</a>
                  @endif
                  <a href="{{ Request::header('referer') }}" target="BoardRight">返回列表</a></td>
            </tr>
         </tbody>
      </table>
      <div class="jq-cate" style="display:none">{{ $catesInput }}</div>
      <input name="_method" type="hidden" value="put"/>
      </form>
   </div>
</div>


<script type="text/javascript">

    /**
     * 初始化分类
     * 
     * @param h jbox节点
     *
     * @return void
     */
    function initCates(h) {
        var catesText = $('.jq-initCates').text();

        var cates = catesText.trim().split(", ");

        h.find('.jq-cateClick').each(function() {
            for(i in cates) {
                // console.log($(this).parent().text() + ' ---> ' + cates[i].trim());
                if($(this).parent().text() == cates[i].trim()) {

                    // 选中
                    $(this).attr('checked', 'checked');

                    // 显示
                    h.find('#cate_' + $(this).val()).show();
                }
            }
        });
    }

    /**
     * 初始化标签
     * 
     *
     * @return void
     */
    function initTags() {
        var tagsText = $('.jq-initTags').text();

        var tags = tagsText.split(", ");
        $('input[type="checkbox"]').each(function() {
            for(i in tags) {
                // console.log($(this).parent().text() + ' ---> ' + tags[i].trim());
                if($(this).parent().text() == tags[i].trim()) {
                    $(this).attr('checked', 'checked');
                }
            }
        });
    }

    $(function(){

        // 初始化关键词
        $(".jq-initKeyword").select2({tags: [],tokenSeparators: ["，",",", " "]});

        // 默认值
        $(".jq-initKeyword").val({{ json_encode($app->keywords) }}).trigger("change");

        // 弹出内容
        var cateSelect = "<div class='add_update jq-cateForm'>" +
                           "<div class='add_update_title'>游戏分类</div>" +
                           "<div class='add_update_lei'>" +
                              "<ul>" +
                              @foreach($cates as $cate)
                                 "<li><lable><input type='checkbox' class='jq-cateClick' value='{{ $cate->id }}' name='cates[]'/>{{ $cate->title }}</lable></li>" +
                              @endforeach
                              "</ul>" +
                           "</div>" +
                           "<div class='add_update_Label' style='height: 230px'>" +
                              "<div class='add_update_title'>标签内容</div>" +
                              @foreach($tags as $k => $cate)
                              "<div class='tags-list' id='cate_{{$k}}'>"+
                                  "<div class='add_update_title_lei'>{{ $cate['title'] }}</div><div class='add_update_lei'><ul>"+
                                     @if(isset($cate['tags']))
                                        @foreach($cate['tags'] as $tag)
                                        "<li><lable><input type='checkbox' name='cates[]' value='{{ $tag['id'] }}'/>{{ $tag['title'] }}</lable></li>" +
                                        @endforeach
                                     @endif
                                  "</ul></div>" +
                              "</div>" +
                              @endforeach
                           "</div>" +
                           "<div class='add_update_button'><input type='button' value='确定' class='Search_en jq-cateSubmit'/></div>" +
                        "</div>";


        // 弹出分类选择
        var jbox = null;
        $(".jq-cates").click(function(){
            $.jBox(cateSelect, {
                title: "<div class=ask_title>游戏分类</div>",
                width: 650,
                height:450,
                border: 5,
                showType: 'slide',
                opacity: 0.3,
                showIcon:false,
                top: '20%',
                loaded:function(h){
                    $("body").css("overflow-y","hidden");
                    jbox = h;
                    initCates(h);
                    initTags();
                },
                closed:function(){
                    $("body").css("overflow-y","auto");
                }

            });
        });

        // 分类选择处理
        $(".jq-cateClick").live('click', function() {
            if($(this).attr('checked') == 'checked') {
                jbox.find('#cate_' + $(this).val()).show();
            } else {
                jbox.find('#cate_' + $(this).val()).find('input[type="checkbox"]').attr('checked', false);
                jbox.find('#cate_' + $(this).val()).hide();
            }
        });

        // 确定分类
        $(".jq-cateSubmit").live('click', function() {

            $('.jq-initCates').text('');
            $('.jq-initTags').text('');

            // 分类提交
            var cates = [];
            jbox.find('.jq-cateClick').each(function() {
                if($(this).attr('checked') == 'checked') {
                    cates.push($(this).parent().text());
                }
            });

            $('.jq-initCates').html(cates.join(",  ")).next('input').val(cates.join(", "));

            // 标签提交
            var tags = [];
            jbox.find('[id^="cate_"]').each(function() {
                $(this).find('input[type="checkbox"]').each(function(){
                    if($(this).attr('checked') == 'checked') {
                        tags.push($(this).parent().text());
                    }
                });
            });
            $('.jq-initTags').html("<h2>" + tags.join("</h2>, <h2>") + "</h2>").next('input').val(tags.join(", "));

            // 表单包含到提交表单
            $('.jq-cate').html($('.jq-cateForm').clone());

            $.jBox.close();
        });

        // 标签删除
        $('.jq-initTags h2').live('click', function() {
            var input = $(this).parent().next('input');
            var val = input.val();
            var newVal = val.replace($(this).text() + ', ', '').replace($(this).text(), '');
            input.val(newVal);

            var $this = $(this);
            $(this).fadeOut(500, function() {
                $(this).remove();
                var html = $('.jq-initTags').html();
                html = html.replace(', , ', ', ');
                html = html.replace(/^, /, '');

                $('.jq-initTags').html(html);
            });
        });


        // APK上传
        var apkUploader = new plupload.Uploader({
            runtimes : 'html5',
            browse_button : 'jq-uploadApp',
            container: document.getElementById('container'),
            url : '{{ URL::route('apps.appupload') }}/dontSave',
            chunk_size: '1mb',
            flash_swf_url : '../js/Moxie.swf',

            filters : {
                max_file_size : '2048mb',
                mime_types: [
                    {title : "apk文件", extensions : "apk"}
                ]
            },

            init: {
                PostInit: function() {
                    document.getElementById('uploadInfo').style.display = 'none';
                },

                FilesAdded: function(up, files) {
                    plupload.each(files, function(file) {
                        document.getElementById('uploadInfo').innerHTML = '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
                    });

                    document.getElementById('jq-uploadApp').style.display = 'none';
                    document.getElementById('uploadInfo').style.display = 'block';
                    apkUploader.start();
                },

                UploadProgress: function(up, file) {
                    if(file.percent == 100) file.percent = 99;
                    document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
                },

                Error: function(up, err) {
                    console.log(err.code + ": " + err.message);
                }
            }
        });

        apkUploader.bind('FileUploaded', function(up, file, object) {
            var response;
            try {
                response = eval(object.response);
            } catch(err) {
                response = eval('(' + object.response + ')');
            }

            for(i in response.result) {
                var $this = $('[class^="upload-' + i + '"]');


                if(typeof($this.attr('class')) != 'undefined') {
                    var className = $this.attr('class');
                    var regexp = /upload-\w+-\w+/gi;
                    var matches = className.match(regexp);
                    var dom = matches[0].replace('upload-'+i+'-', '');

                    if(dom == 'html') {
                        $this.html(response.result[i]);
                        $this.append('<input type="hidden" name="'+ i +'" value="'+ response.result[i] +'">');
                    } else if(dom == 'val'){
                        $this.val(response.result[i]);
                    } else {
                        $this.attr(dom, response.result[i]);
                        $this.after('<input type="hidden" name="'+ i +'" value="'+ response.result[i] +'">');
                    }
                }
            }

            $('#jq-uploadApp').show();
            $('#uploadInfo').hide();
        });

        apkUploader.init();

        // 游戏截图上传
        var picUploader = new plupload.Uploader({
            runtimes : 'html5',
            browse_button : 'jq-uploadPic',
            url : '{{ URL::route('apps.imageupload') }}',
            chunk_size: '1mb',
            flash_swf_url : '../js/Moxie.swf',

            filters : {
                max_file_size : '10mb',
                file_pixel_size: '220x370',
                mime_types: [
                    {title : "图片文件", extensions : "jpg,png"}
                ]
            },
            init: {
                FilesAdded: function(up, files) {
                    picUploader.start();
                },

                Error: function(up, err) {
                    // console.log(err.code + ": " + err.message);

                    $('.jq-picTips').html(err.message);
                }
            }
        });

        // 图片大小限制
        plupload.addFileFilter('file_pixel_size', function(limitSize, file, cb) {
            var self = this, img = new o.Image();
            var sizes = limitSize.split('x');

            function finalize(result) {

                img.destroy();
                img = null;

                if (!result) {
                    self.trigger('Error', {
                        code : plupload.IMAGE_DIMENSIONS_ERROR,
                        message : file.name + "图片规格应该为 " + limitSize  + " 像素.",
                        file : file
                    });
                }
                cb(result);
            }

            img.onload = function() {
                finalize((img.width == sizes[0] && img.height == sizes[1]));
            };

            img.onerror = function() {
                finalize(false);
            };

            img.load(file.getSource());
        });

        picUploader.bind('FileUploaded', function(up, file, object) {
            var response;
            try {
                response = eval(object.response);
            } catch(err) {
                response = eval('(' + object.response + ')');
            }

            $('.jq-pictures').append('<li><img src="' + response.result + '"/><input name="images[]" value="'+response.result+'" type="hidden"/><a class="jq-picDelete" href="javascript:;">删除</a></li>');
        });

        picUploader.init();

        // 游戏图片排序
        $("ul.jq-pictures").sortable({
            group: 'jq-pictures',
            nested: false,
            vertical: false,
            onDragStart: function ($item, container, _super) {
                var offset = $item.offset(),
                pointer = container.rootGroup.pointer

                adjustment = {
                  left: pointer.left,
                  top: pointer.top - 113
                }

                _super($item, container)
            },
            onDrag: function ($item, position) {
                $item.css({
                  left: position.left - adjustment.left,
                  top: position.top - adjustment.top
                })
            }
        });

        // 游戏图片删除
        $('.jq-picDelete').live('click', function() {
            $(this).parent().fadeOut('300', function() { $(this).remove() });
        });

        // 保存为草稿
        $('.jq-submitDraft').click(function() {
            $('input[name="images[]"][value=""]').remove();
            $('#form').attr('action', $(this).attr('data-action')).submit();
        });

        // 图片
        jQuery.validator.addMethod("images", function(value, element) {
            return $('input[name="images[]"]').length > 0;
        }, "图片必须上传");

        jQuery.validator.addMethod("images", function(value, element) {
            return $('input[name="images[]"]').length < 7;
        }, "图片必须少于6张");

        // 提交表单
        $('.jq-submit').click(function() {

            tinymce.triggerSave();

            // 验证
            $("#form").validate({
                ignore: '',
                rules: {
                    checkCate: "required",
                    checkTag: "required",
                    author: "required",
                    os_version: "required",
                    version_code: "required",
                    sort: "required",
                    download_manual: "required",
                    summary: "required",
                    "images[]": "images",

                },
                messages: {
                    checkCate: {required: '分类为必填'},
                    checkTag: {required: '标签为必填'},
                    os_version: {required: '系统要求为必填'},
                    author: {required: '游戏作者为必填'},
                    version_code: {required: '包名为必填'},
                    sort: {required: '排序为必填'},
                    download_manual: {required: '下载次数为必填'},
                    summary: {required: '简介为必填'},
                    images: {images: ' 图片为必填'},
                }
            });

            if($("#form").valid()) {
                $('input[name="images[]"][value=""]').remove();
                $('#form').attr('action', $(this).attr('data-action')).submit();
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


        // 方向键移动
        $(':input').on('keydown', function(e) {
            // 38 上
            if(e.keyCode == 38) {
                $(':input:eq(' + ($(':input').index(this) - 1) + ')').focus();
            }
            // 40 下
            if(e.keyCode == 40) {
                $(':input:eq(' + ($(':input').index(this) + 1) + ')').focus();
            }
        });

    });

</script>
@stop