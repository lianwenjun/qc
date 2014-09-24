@extends('admin.layout')

@section('content')               
<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>系统管理 <span> 游戏分类管理</span></h1></div>
    <div class="Theme_Search">
        <ul>
            <li> 
                 <span><input name="" id="Classification" type="submit" value="添加分类" class="Search_en" /></span>
                 <span><input name="" id="Tag" type="submit" value="添加标签" class="Search_en" /></span>
            </li>
           
        </ul>
    </div>                 
    <div class="Search_biao">                   
        <div class="user_left">
            <ul>
                <li class="user_title"><span>分类标签管理</span></li>
                <li class="user_li">
                  
                    <!--分类标签管理!-->
                    <div style="width:100%; height:390px; scrollbar-3dlight-color:#DDD; scrollbar-arrow-color:#333; scrollbar-base-color:#cfcfcf; scrollbar-darkshadow-color:#fff; scrollbar-face-color:#cfcfcf; scrollbar-highlight-color:#fff; scrollbar-shadow-color:#595959; overflow-y:auto; overflow-x:hidden">
                        <ul id="listdata">
                            <li class="Push_left_one"><span class="Push_page">单机专区</span></li>
                            <li class="Push_left_tow"><span class="Push_pagezk">优质游戏</span></li>
                           
                               <!--二级栏目!-->
                                
                                <li class="Push_fen"><span>植物大战僵尸</span></li>
                                <li class="Push_fen"><span>全民打飞机</span>  </li>
                                <li class="Push_fen"><span>全民打飞机</span></li>
                                <li class="Push_fen"><span>植物大战僵尸</span></li>
                                <li class="Push_fen"><span>全民打飞机</span></li>
                                <li class="Push_fen"><span>植物大战僵尸</span></li> 
                               
                               <!--二级栏目!-->
                               
                           
                            <li class="Push_left_one"><span>卡牌休闲</span></li>
                            <li class="Push_left_tow"><span>单机专区</span></li>
                            <li class="Push_left_tow"><span class="Push_page">优质游戏</span></li>
                            <li class="Push_left_one"><span class="Push_page">卡牌休闲</span></li>
                            <li class="Push_left_tow"><span class="Push_page">优质游戏   </span></li>
                            <li class="Push_left_tow"><span class="Push_page">优质游戏</span></li>
                        </ul> 
                    </div>
                    <!--分类标签管理!-->
                </li>
            </ul>
        </div>
                           
        <div class="user_width"></div>                      
        <!--游戏分类-->
        <div class="user_center" >
            <ul>
                <li class="user_title"><span>游戏分类管理</span></li>
                <li class="user_li">
                <!--游戏分类-->
                <!--未选择游戏分类-->
                <div class="user_Prompt"  style="display:none">未选择游戏分类</div>
                    <!--未选择游戏分类-->
                    <div class="user_tabler user_Lower" >
                        <ul>
                            <li class="user_one "><strong>分类名称：</strong>单机专区</li>
                            <li class="user_two"><strong>游戏数量：</strong>2254</li>
                            <li class="user_one"><strong>搜索次数：</strong>55</li>
                            <li class="user_two"><strong>标签管理：</strong><a href="#">20（点击查看标签信息）</a></li>
                            <li class="user_one"><strong>添加时间：</strong>2014-7-8</li>
                            <li class="user_button"><a class="Search_show" href="#">修 改</a> <a class="Search_xiajia" href="#">删除</a></li>
                        </ul>
                    </div>
                    <!--游戏分类-->
                    <!--修改游戏分类-->
                    <div class="user_tabler" style="display:none">
                            <ul>
                              <li class="user_one"><strong>分类名称：</strong><input name="" type="text" value="单机专区" /></li>
                              <li class="user_two"><strong>游戏数量：</strong>2254</li>
                              <li class="user_one"><strong>搜索次数：</strong>55</li>
                              <li class="user_two"><strong>标签管理：</strong><a href="#">20（点击查看标签信息）</a></li>
                              <li class="user_one"><strong>添加时间：</strong>2014-7-8</li>
                              <li class="user_button"><a class="Search_show" href="#">确定</a></li>
                            </ul>
                    </div>
                    <!--修改游戏分类-->
                 
                </li>
            </ul>
        </div>
        <!--游戏分类-->
                           
        <div class="user_width"></div>
                           
                           
                           
        <div class="user_right">
            <ul>
                <li class="user_title"><span>标签管理</span></li>
                <li class="user_li">
                    <!--未选择标签管理提示-->
                    <div class="user_Prompttwo" style="display:none">未选择标签信息</div>
                    <!--未选择标签管理提示-->
                    <div class="user_centent">
                        <div id="scrollDiv" >
                            <div class="up"></div>
                            <div class="scrollText">
                                <ul>
                                    <li class="scrollText_hover">植物大战僵尸</li>
                                    <li class="scrollText_two">全民打飞机</li>
                                    <li class="scrollText_one">德州扑克</li>
                                    <li class="scrollText_two">斗地主</li>
                                    <li class="scrollText_one">植物大战僵尸</li>
                                    <li class="scrollText_two">全民打飞机</li>
                                    <li class="scrollText_one">德州扑克</li>
                                    <li class="scrollText_two">斗地主</li>
                                    <li class="scrollText_one">植物大战僵尸</li>
                                    <li class="scrollText_two">全民打飞机</li>
                                    <li class="scrollText_one">德州扑克</li>
                                    <li class="scrollText_two">斗地主</li>
                                    <li class="scrollText_one">植物大战僵尸</li>
                                    <li class="scrollText_two">全民打飞机</li>
                                    <li class="scrollText_one">德州扑克</li>
                                    <li class="scrollText_two">斗地主</li>
                                    <li class="scrollText_one">植物大战僵尸</li>
                                    <li class="scrollText_two">全民打飞机</li>
                                    <li class="scrollText_one">德州扑克</li>
                                    <li class="scrollText_two">斗地主</li>
                                </ul>
                            </div>
                            <div class="down"></div>
                        </div>

                        <div class="user_right_width"></div> 
                        <!--标签信息-->  
                        <div class="user_right_title" >
                            <ul>
                                <li class="user_one"><strong>ID：</strong>1</li>
                                <li class="user_two"><strong>所属标签：</strong>连连看</li>
                                <li class="user_one"><strong>游戏数量：</strong>152</li>
                                <li class="user_two"><strong>自然搜索量：</strong>158</li>
                                <li class="user_one"><strong>添加时间：</strong>2014-7-23</li>
                                <li class="user_button"><a class="Search_show" href="#">修 改</a> <a class="Search_xiajia" href="#">删除</a></li>
                            </ul>
                        </div>
                        <!--标签信息-->
                                            
                        <!--修改标签信息-->  
                        <div class="user_right_title" style="display:none">
                            <ul>
                                <li class="user_one"><strong>ID：</strong>1</li>
                                <li class="user_two"><strong>所属标签：</strong><input name="" type="text" value="连连看" /></li>
                                <li class="user_one"><strong>游戏数量：</strong>152</li>
                                <li class="user_two"><strong>自然搜索量：</strong>158</li>
                                <li class="user_one"><strong>添加时间：</strong>2014-7-23</li>
                                <li class="user_button"><a class="Search_show" href="#">确定</a></li>
                            </ul>
                        </div>
                        <!--修改标签信息-->
                    </div>                                                  
                </li>
            </ul>
        </div>
    </div>            
</div>
<script src="/js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){
    //$("#scrollDiv").textSlider({line:4,speed:500,timer:3000});
});
$(function(){
    //JQ-add
    TagCreateUrl = "{{ route('cate.create') }}";
    $("#Classification").click(function(){
        $.jBox("iframe:" + TagCreateUrl, {  
          title: "<div class=ask_title>分类添加</div>",  
          width: 550,  
          height:370,
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
    
    $("#Tag").click(function(){
        $.jBox("iframe:add_Tag.html", {  
          title: "<div class=ask_title>标签添加</div>",  
          width: 550,  
          height:370,
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
  
$(function() {
    $( "#listdata" ).sortable({
      stop: function(event, ui) {
        var app_id='';
        $('input[name=del_id]').each(function(index, element) {
          app_id+=$(this).val()+',';
        });
        $.post('market_app.php', {'act':'update_sort', 'app_id':app_id}, function(){}, 'html');
      }
      });
    $( "#listdata" ).disableSelection();
    
    $('.qqtip').qtip({position: { my: 'bottom left', at: 'top center'}});
});
</script>              
@stop
