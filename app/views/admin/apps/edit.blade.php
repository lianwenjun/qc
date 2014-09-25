@extends('admin.layout')

@section('content')
<link href="{{ asset('css/admin/select2.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('js/admin/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/admin/select2_locale_zh-CN.js') }}" type="text/javascript"></script>
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
               <td>{{ $app->title }}</td>
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei">包名：</td>
               <td>{{ $app->pack }}</td>
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei">大小：</td>
               <td>{{ $app->size }}</td>
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei">版本号：</td>
               <td>{{ $app->version }}</td>
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei">上传时间：</td>
               <td>{{ $app->created_at }}</td>
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei">上传新版本：</td>
               <td class="Search_apk"><span><a href="#" class="Search_Update">选择APK</a></span><img src="{{ $app->icon }}" width="90" height="90"></td>
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei">游戏关键字：</td>
               <td><input name="keywords" type="text" value="" class="Search_text jq-initKeyword"></td>
            </tr>
            <tr class="Search_biao_one">
                <td  class="Search_lei">游戏分类：</td>
                <td>
                    <span style="float:left; line-height:26px; padding-right:8px;">
                             单机专区、卡牌
                    </span>
                    <span style=" float:left;"><input name="" id="Classification" type="submit" value="修改" class="Search_en" /></span>
                </td>
            </tr>

            <tr class="Search_biao_two">
               <td class="Search_lei">游戏标签：</td>
               <td>
                  <input name="" type="text" value="卡牌" class="Search_text">
               </td>
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei">游戏作者：</td>
               <td><input type="checkbox" name="checkbox" id="checkbox" class="Search_checkbox">勾选表示无广告</td>
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei">是否无广告：</td>
               <td><input type="checkbox" name="checkbox" id="checkbox" class="Search_checkbox">勾选表示无广告</td>
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei">系统要求：</td>
               <td>
                  <select class="Search_select">
                     <option value="Android">Android</option>
                  </select>
                  <input name="" type="text" class="Search_input" value="2.3" size="8">
                  以上
               </td>
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei">包名：</td>
               <td>
                  <input name="" type="text" value="wojiaoMT online" class="Search_text">
               </td>
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei">排序：</td>
               <td>
                  <input name="" type="text" value="9999" class="Search_input">
               </td>
            </tr>
            <tr class="Search_biao_two">
               <td class="Search_lei">下载次数：</td>
               <td>
                  <input name="" type="text" value="5000万+" class="Search_input">
               </td>
            </tr>
            <tr class="Search_biao_one">
               <td class="Search_lei">游戏简介：</td>
               <td><textarea name="" class="Search_textarea" cols="" rows="">《黑暗之光》职业介绍
                  【狂战士——追求极致力量，心醉武道的狂战士】
                  描述：狂战士是近距离作战的王者。他们拥有令人生畏的力量和优秀的防御能力。他们擅长使用巨剑作为自己进攻的武器。战斗中他们不畏生死，追求极致力量是他们永恒的信念。
                  技能：重击、地裂、跳斩、风暴之锤、大地之震</textarea>
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
               <td><textarea name="" class="Search_textarea" cols="" rows="">《黑暗之光》职业介绍
                  【狂战士——追求极致力量，心醉武道的狂战士】
                  描述：狂战士是近距离作战的王者。他们拥有令人生畏的力量和优秀的防御能力。他们擅长使用巨剑作为自己进攻的武器。战斗中他们不畏生死，追求极致力量是他们永恒的信念。
                  技能：重击、地裂、跳斩、风暴之锤、大地之震</textarea>
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
    $(function(){

        $(".jq-initKeyword").select2({
                      tags:["red", "green", "blue"],
                      tokenSeparators: ["，",",", " "]});

        // 默认值
        $(".jq-initKeyword").val(["AK","CO"]).trigger("change");

        var cateSelect = "<div class='add_update'>" +
                           "<div class='add_update_title'>游戏分类</div>" +
                           "<div class='add_update_lei'>" +
                              "<ul>" +
                                 "<li><input type='checkbox' name='checkbox' id='checkbox' />休闲益智</li>" +
                              "</ul>" +
                           "</div>" +
                           "<div class='add_update_Label'>" +
                              "<div class='add_update_title'>标签内容</div>" +
                              "<div class='add_update_title_lei'>休闲益智</div>" +
                              "<div class='add_update_lei'>" +
                                 "<ul>" +
                                    "<li><input type='checkbox' name='checkbox' id='checkbox' />休闲益智</li>" +
                                 "</ul>" +
                              "</div>" +
                           "</div>" +
                           "<div class='add_update_button'><input name='' type='button' value='确定' class='Search_en' /></div>" +
                        "</div>";

        $("#Classification").click(function(){
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
                }
                 ,
                 closed:function(){
                   $("body").css("overflow-y","auto");
                 }
                 
            });
        });

    });
    
</script>>
@stop