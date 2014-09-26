@extends('admin.layout')

@section('content')
<link href="{{ asset('css/admin/select2.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('js/admin/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/admin/select2_locale_zh-CN.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/admin/plupload/plupload.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/admin/nicEdit.js') }}" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>

<div class="Content_right_top Content_height">
   <div class="Theme_title">
      {{ Breadcrumbs::render('apps.edit') }}
   </div>
   <div class="Search_title">游戏信息</div>
   <div class="Search_biao">
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
               <td class="upload-size-html">{{ friendlyFilesize($app->size) }}</td>
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
               <td class="Search_apk"><span id="container"><a href="javascript:;" class="Search_Update" id="jq-uploadApp">选择APK</a><span id="uploadInfo"></span></span><img class="upload-icon-src" src="{{ $app->icon }}" width="90" height="90"></td>
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei">游戏关键字：</td>
               <td><input name="keywords" type="text" value="" class="Search_text jq-initKeyword"></td>
            </tr>
            <tr class="Search_biao_one">
                <td  class="Search_lei">游戏分类：</td>
                <td>
                    <span style="float:left; line-height:26px; padding-right:8px;" class="jq-initCates">
                        <?php $split = ''; ?>
                        @foreach($app->cates as $cate)
                            {{ $split.$cate->title }}
                            <?php $split = ', '; ?>
                        @endforeach
                    </span>
                    <span style="float:left;"><button class="Search_en jq-cates">修改</button></span>
                </td>
            </tr>

            <tr class="Search_biao_two">
               <td class="Search_lei">游戏标签：</td>
               <td>
                  <span style="float:left; line-height:26px; padding-right:8px;" class="jq-initTags">
                        <?php $split = ''; ?>
                        @foreach($app->tags as $tag)
                            {{ $split.$tag->title }}
                            <?php $split = ', '; ?>
                        @endforeach
                  </span>
               </td>
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei">游戏作者：</td>
               <td><input name="author" type="text" value="{{ $app->author }}" class="Search_text"></td>
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei">是否无广告：</td>
               <td><label><input type="checkbox" name="has_ad" @if($app->has_ad == 'yes')checked="checked"@endif class="Search_checkbox">勾选表示无广告</label></td>
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei">是否安全认证：</td>
               <td><lable><input type="checkbox" name="is_verify" @if($app->is_verify == 'yes')checked="checked"@endif  class="Search_checkbox">勾选表示已认证</lable></td>
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei">系统要求：</td>
               <td>
                  <select name="os" class="Search_select">
                     <option value="Android">Android</option>
                  </select>
                  <input name="os_version" type="text" class="Search_input" value="" size="8">
                  以上
               </td>
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei">包名：</td>
               <td>
                  <input name="pack" type="text" value="{{ $app->version_code }}" class="upload-version_code-val Search_text">
               </td>
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei">排序：</td>
               <td>
                  <input name="sort" type="text" value="{{ $app->sort }}" class="Search_input">
               </td>
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei">下载次数：</td>
               <td>
                  <input name="download_manual" type="text" value="{{ $app->download_manual }}" class="Search_input">
               </td>
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei">游戏简介：</td>
               <td><textarea name="" class="Search_textarea" cols="" rows="">{{ $app->summary }}</textarea>
               </td>
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei">游戏截图：</td>
               <td><a href="#" class="Search_Update">图片上传</a> <span style="color:#C00">可选择多张，图片规格为220*370px 的JPG/PNG</span></td>
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei">截图预览：</td>
               <td class="Search_img">
                  <div class="Update_img">
                     <ul id="listdata" class="ui-sortable">
                        <li><img src="images/1.jpg"><a href="#">删除</a></li>
                        <li><img src="images/2.jpg"><a href="#">删除</a></li>
                     </ul>
                  </div>
               </td>
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei">新版特性：</td>
               <td><textarea name="" class="Search_textarea" cols="" rows="">{{ $app->changes }}</textarea>
               </td>
            </tr>
            <tr class="Search_biao_one">
               <td colspan="2" align="center" class="Search_submit"><input name="" type="submit" value="提 交"> <a href="Game_List.html" target="BoardRight">返回列表</a></td>
            </tr>
         </tbody>
      </table>
   </div>
</div>


<script type="text/javascript">

    // 初始化分类
    function initCates() {
        var catesText = $('.jq-initCates').text();
        $('[id^="cate_"]').hide();

        var cates = catesText.split(", ");
        $('input[type="checkbox"]').each(function() {
            for(i in cates) {
                // console.log($(this).parent().text() + ' ---> ' + cates[i].trim());
                if($(this).parent().text() == cates[i].trim()) {

                    // 选中
                    $(this).attr('checked', 'checked');

                    // 显示
                    $('#cate_' + $(this).val()).show();
                }
            }
        });
    }

    // 初始化标签
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
        $(".jq-initKeyword").val(["AK","CO"]).trigger("change");

        // 弹出内容
        var cateSelect = "<div class='add_update'>" +
                           "<div class='add_update_title'>游戏分类</div>" +
                           "<div class='add_update_lei'>" +
                              "<ul>" +
                              @foreach($cates as $cate)
                                 "<li><lable><input type='checkbox' class='jq-cateClick' value='{{ $cate->id }}' name='cates[]'/>{{ $cate->title }}</lable></li>" +
                              @endforeach
                              "</ul>" +
                           "</div>" +
                           "<div class='add_update_Label'>" +
                              "<div class='add_update_title'>标签内容</div>" +
                              @foreach($tags as $k => $cate)
                              "<div id='cate_{{$k}}'>"+
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
                loaded:function(){
                  $("body").css("overflow-y","hidden");
                  initCates();
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
                $('#cate_' + $(this).val()).show();
            } else {
                $('#cate_' + $(this).val()).find('input[type="checkbox"]').attr('checked', false);
                $('#cate_' + $(this).val()).hide();
            }
        });

        // 确定分类
        $(".jq-cateSubmit").live('click', function() {

            // 分类提交
            var cates = [];
            $('.jq-cateClick').each(function() {
                if($(this).attr('checked') == 'checked') {
                    cates.push($(this).parent().text());
                }
            });
            $('.jq-initCates').text(cates.join(", "));

            // 标签提交
            var tags = [];
            $('[id^="cate_"]').each(function() {
                $(this).find('input[type="checkbox"]').each(function(){
                    if($(this).attr('checked') == 'checked') {
                        tags.push($(this).parent().text());
                    }
                });
            });
            $('.jq-initTags').text(tags.join(", "));

            $.jBox.close();

            // 表单包含到提交表单 TODO
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
                    document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
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


    });
    
</script>>
@stop