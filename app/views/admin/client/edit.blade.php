@extends('admin.layout')

@section('content')
<script src="{{ asset('js/admin/plupload/plupload.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/admin/plupload/i18n/zh_CN.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/admin/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/admin/additional-methods.min.js') }}" type="text/javascript"></script>


<div class="Content_right_top Content_height">
   <div class="Theme_title">
    <h1>系统管理 <span>游戏中心APP版本管理</span><span>编辑</span></h1>
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
            <tr class="Search_biao_two">
               <td class="Search_lei">游戏名称：</td>
               <td class="upload-title-html">{{ $app->title }}</td>
               <input type="hidden" name="title" value="{{ $app->title }}">
               <input type="hidden" name="download_link" value="{{ $app->download_link }}">
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei">大小：</td>
               <td class="upload-size_int-html">{{ $app->size_int . 'KB' }}</td>
               <input type="hidden" name="size_int" value="{{ $app->size_int }}">
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei">MD5：</td>
               <td class="upload-md5-html">{{ $app->md5 }}</td>
               <input type="hidden" name="md5" value="{{ $app->md5 }}">
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei">版本号：</td>
               <td class="upload-version-html">{{ $app->version }}</td>
               <input type="hidden" name="version" value="{{ $app->version }}">
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei">版本代号：</td>
               <td class="upload-version_code-html">{{ $app->version_code }}</td>
               <input type="hidden" name="version_code" value="{{ $app->version_code }}">
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei">上传时间：</td>
               <td>{{ $app->created_at }}</td>
            </tr>
            <tr class="Search_biao_one">
                <td class="Search_lei">上传新APK</td>
                <td class="Search_apk">
                    <div>
                      <div style="display:inline;">
                        <span id="container">
                          <a href="javascript:;" class="Search_Update" {{ Sentry::getUser()->hasAccess('apps.appupload') ? 'id="jq-uploadApp"':''}} >选择APK</a>
                          <span id="uploadInfo"></span>
                        </span>
                      </div>
                      </div>
                    </div>
                </td>
            </tr>
            <tr>
               <td class="Search_lei">选择渠道：</td>
               <td>
                    {{ Form::select('release', Config::get('status.release'), $app->release); }}
               </td>
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei">新版特性：</td>
               <td><textarea name="changes" id="changes" class="Search_textarea">{{ $app->changes }}</textarea>
               </td>
            </tr>
            <tr class="Search_biao_one">
               <td colspan="2" align="center" class="Search_submit">
                  <a href="javascript:;" data-action="{{ URL::route('client.edit', $app->id) }}" class="jq-submit">提 交</a>
                  <a href="{{ URL::route('client.index') }}" target="BoardRight">返回列表</a></td>
            </tr>
         </tbody>
      </table>
      </form>
   </div>
</div>


<script type="text/javascript">
$(function() {
    $("tr:odd").addClass("Search_biao_two");
    $("tr:even").addClass("Search_biao_one");
    // APK上传
    var apkUploader = new plupload.Uploader({
      runtimes : 'html5',
      browse_button : 'jq-uploadApp',
      container: document.getElementById('container'),
      url : '{{ URL::route('client.apkupload') }}',
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
            alert(err.message);
          }
      }
  });

  apkUploader.bind('FileUploaded', function(up, file, response) {
      response = jQuery.parseJSON( response.response );

      if(typeof(response.result.error) != 'undefined' && response.result.error.code == '500') {
          alert(file.name + response.result.error.message);
          file.status = plupload.FAILED;
      } else {

        for(i in response.result.data) {
            var $this = $('[class^="upload-' + i + '-html"]');

            $('input[name=' + i + ']').val(response.result.data[i]);
            if(typeof($this.attr('class')) != 'undefined') {
                $this.html(response.result.data[i]);
            }
        }
      }

      $('#jq-uploadApp').show();
      $('#uploadInfo').hide();
  });

  apkUploader.init();
  //提交保存
  $('.jq-submit').click(function() {
      $('input[name="images[]"][value=""]').remove();
      $('#form').attr('action', $(this).attr('data-action')).submit();
  });
});
</script>
@stop