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
                        <ul class="dropdown">
                            @foreach($cates as $index => $cate)
                                @if ($cate['one'] == 1)                    
                                    <li class="Push_left_one jq-cate" data-cate-id="{{  $cate['data']['id'] }}"><a href="javascript:;"><span class="Push_page">{{  $cate['data']['title'] }}</span></a>
                                        <!--二级分类!-->
                                        <ul>
                                            @foreach($cate['list'] as $tag)
                                                <li class="Push_fen"><span>{{$tag['title']}}</span></li>
                                            @endforeach
                                        </ul>
                                        <!--二级分类!-->
                                    </li>
                                @else
                                    <li class="Push_left_tow jq-cate" data-cate-id="{{  $cate['data']['id'] }}"><a href="javascript:;"><span class="Push_page">{{  $cate['data']['title'] }}</span></a>
                                        <!--二级分类!-->
                                        <ul>
                                            @foreach($cate['list'] as $tag)
                                                <li class="Push_fen"><span>{{$tag['title']}}</span></li>
                                            @endforeach
                                        </ul>
                                        <!--二级分类!-->
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <!--分类标签管理!-->
                </li>
            </ul>
        </div>
                           
        <div class="user_width"></div>                      
        <!--游戏分类-->
        <div class="user_center" style="display:none">
            <ul>
                <li class="user_title"><span>游戏分类管理</span></li>
                <li class="user_li">
                <!--游戏分类-->
                <!--未选择游戏分类-->
                <div class="user_Prompt"  style="display:none">未选择游戏分类</div>
                    <!--未选择游戏分类-->
                    @foreach($cates as $index => $cate)
                        <div data-cate-id= "{{ $cate['data']['id'] }}" class="user_tabler user_Lower ja-cate-id jq-cate-{{ $cate['data']['id'] }}" style="display:none">
                            <ul>
                                <li class="user_one"><strong>分类名称：</strong><p class="jq-title">{{ $cate['data']['title']}}</p></li>
                                <li class="user_two"><strong>游戏数量：</strong>{{ $cate['appcount']}}</li>
                                <li class="user_one"><strong>搜索次数：</strong>{{ $cate['data']['search_total'] }}</li>
                                <li class="user_two"><strong>标签管理：</strong><a data-url="{{ URL::route('cate.show', $cate['data']['id']) }}" class="jq-showCate" href="javascript:;">{{ count($cate['list']) }}（点击查看标签信息）</a></li>
                                <li class="user_one"><strong>添加时间：</strong>{{ $cate['data']['created_at'] }}</li>
                                <li class="user_button">
                                    <a class="Search_show jq-editCate" href="javascript:;">修 改</a>
                                    <a class="Search_xiajia jq-delCate" href="javascript:;">删除</a>
                                </li>
                                
                                <input type="hidden" name="edit_url" value="{{ URL::route('cate.edit', $cate['data']['id']) }}"/>
                                <input type="hidden" name="pre_title" value="{{ $cate['data']['title']}}"/>
                                <input type="hidden" name="del_url" value="{{ URL::route('cate.delete', $cate['data']['id']) }}" />
                            </ul>
                        </div>
                    @endforeach
                    <!--游戏分类-->
                    <!--修改游戏分类-->
                    <div class="user_tabler" style="display:none">
                            <ul>
                              <li class="user_one"><strong>分类名称：</strong><input name="" type="text" value="单机专区" /></li>
                              <li class="user_two"><strong>游戏数量：</strong>2254</li>
                              <li class="user_one"><strong>搜索次数：</strong>55</li>
                              <li class="user_two"><strong>标签管理：</strong><a href="#">20（点击查看标签信息）</a></li>
                              <li class="user_one"><strong>添加时间：</strong>2014-7-8</li>
                              <li class="user_button"><a class="Search_show jq-updateCate" href="javascript:;">确定</a></li>
                            </ul>
                    </div>
                    <!--修改游戏分类-->
                 
                </li>
            </ul>
        </div>
        <!--游戏分类-->
                           
        <div class="user_width"></div>
                           
                           
                           
        <div class="user_right" style="display:none">
            <ul>
                <li class="user_title"><span>标签管理</span></li>
                <li class="user_li">
                    <!--未选择标签管理提示-->
                    <div class="user_Prompttwo jq-taglist" style="display:none">未选择标签信息</div>
                    <!--未选择标签管理提示-->
                    <div class="user_centent">
                        <div id="scrollDiv" >
                            <div class="up"></div>
                            <div class="scrollText jq-tagul">
                                <ul>
                                </ul>
                            </div>
                            <div class="down"></div>
                        </div>

                        <div class="user_right_width"></div> 
                        <!--标签信息-->
                        <p class='jq-tagList'></p>
                            <div class="user_right_title" style="display:none">
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
<!--script src="/js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>!-->
<script src="/js/admin/tendina.js" type="text/javascript"></script>
<script src="/js/admin/jQuery.textSlider.js" type="text/javascript"></script>


<script type="text/javascript">
$(function(){
    $("#scrollDiv").textSlider({line:4,speed:500,timer:3000});

    //JQ-add
    cateCreateUrl = "{{ route('cate.create') }}";
    tagCreateUrl = "{{ route('tag.create') }}";
    updateCate = '<a class="Search_show jq-update" href="javascript:;">确定</a>';

    buttonCate = '<a class="Search_show jq-editCate" href="javascript:;">修 改</a><a class="Search_xiajia jq-delCate" href="javascript:;">删除</a>';
    $("#Classification").click(function(){
        $.jBox("iframe:" + cateCreateUrl, {  
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
        $.jBox("iframe:" + tagCreateUrl, {  
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
    //<!--分类下拉 -->
    $(".dropdown").tendina( {
        animate: true,
        speed: 500,
        openCallback: function($clickedEl) {
            //console.log($clickedEl);
        },
        closeCallback: function($clickedEl) {
            //console.log($clickedEl);
        }
    });
    //点击分类
    $(".jq-cate").click(function() {
        var cate_id = $(this).attr('data-cate-id');
        $(".ja-cate-id").hide();
        $(".jq-cate-" + cate_id).show();
        $(".user_center").show();
        $(".user_right").hide();
    });
    //点击编辑分类
    $(".jq-editCate").live('click', function() {
        var li = $(this).parents('ul').children('li');
        var title = li.eq(0).find('.jq-title').html();
        //var button = li.find('.user_button').html();
        var to_title = '<input name="editCate" type="text" value="" />';
        li.eq(0).find('.jq-title').html(to_title);
        li.eq(0).find('input[name=editCate]').val(title);
        li.find('.user_button').html(updateCate);
    });
    //确定修改分类
    $(".jq-updateCate").live('click', function() {
        var li = $(this).parents('ul').children('li');
        var title = li.eq(0).find('input[name=editCate]').val();
        var data = {word:title};
        var editUrl = $(this).parents().children('input[name=edit_url]').val();
        $.post(editUrl, data, function(res) {
            if (res.status == 'ok'){
                alert("修改分类成功");
                li.eq(0).find('.jq-title').html(title);
                li.find('.user_button').html(buttonCate);
            }
        });
    });
    //显示分类标签列表
    $(".jq-showCate").click(function() {
        var showUrl = $(this).attr('data-url');
        $.get(showUrl, function(res) {
            if (res.status == 'ok') {
                var text1 = '';
                var text2 = '';
                for(var tag in res.data){
                    var tagdata = res.data[tag];
                    if (tagdata.one == 1) {
                        text1 += '<li data-tag-id="'+tagdata.data.id+'" class="scrollText_one jq-tagClick">'+tagdata.data.title+'</li>';
                    } else {
                        text1 += '<li data-tag-id="'+tagdata.data.id+'" class="scrollText_two jq-tagClick">'+tagdata.data.title+'</li>';
                    }
                    text2 += '<div class="user_right_title jq-tagDisplay jq-tagDisplay-'+tagdata.data.id+'" style="display:none">' + 
                                '<ul>' +
                                    '<li class="user_two"><strong>所属标签：</strong><p class="jq-title">'+tagdata.data.title+'</p></li>'+
                                    '<li class="user_one"><strong>标签ID：</strong>'+tagdata.data.id+'</li>'+
                                    '<li class="user_two"><strong>搜索次数：</strong>'+tagdata.data.search_total+'</li>'+
                                    '<li class="user_one"><strong>游戏数量：</strong>'+tagdata.count+'</li>'+
                                    '<li class="user_one"><strong>添加时间：</strong>'+tagdata.data.created_at+'</li>'+
                                    '<li class="user_button"><a class="Search_show jq-editTag" href="javascript:;">修 改</a> <a class="Search_xiajia" href="javascript:;">删除</a></li>'+
                                    '<input type="hidden" name="pre_title" value="'+tagdata.data.title+'"/>' + 
                                    '' + 
                                    '' + 
                                '</ul>' +
                                '</div>';
                }
                $(".jq-tagul ul").html(text1);
                $(".jq-tagList").html(text2);
                $(".user_right").show();
            }
        });
    });
    //点击标签
    $(".jq-tagClick").live('click', function() {
        //alert('点击标签');
        //清理掉hover的选择并还原数据
        var tag = $(".scrollText_hover");
        tag.removeClass('scrollText_hover');
        var tagId = tag.attr('data-tag-id');
        var title = $(".jq-tagDisplay-"+tagId+' ul input[name=pre_title]').val();
        console.log($(".jq-tagDisplay-"+tagId+' ul li p').html());
        $(".jq-tagDisplay-"+tagId+' ul li p').html(title);
        //新选择
        $(this).addClass('scrollText_hover');
        var tagId = $(this).attr('data-tag-id');
        $(".jq-tagDisplay").hide();
        $(".jq-tagDisplay-"+tagId).show();
    });
    //点击修改标签
    $(".jq-editTag").live('click', function() {
        var li = $(this).parents().children('li');
        var title = li.eq(0).find('.jq-title').html();
        var to_title = '<input name="editTag" type="text" value="" />';
        li.eq(0).find('.jq-title').html(to_title);
        li.eq(0).find('input[name=editTag]').val(title);
        li.eq(5).html(updateCate);
    });
    //点击确定修改标签
    $(".jq-updateTag").live('click', function(){
        var li = $(this).parents('ul').children('li');
        var title = li.eq(0).find('input[name=editCate]').val();
        var data = {word:title};
        var editUrl = $(this).parents().find('input[name=edit_url]').val();
        $.post(editUrl, data, function(res) {
            if (res.status == 'ok'){
                alert("修改标签成功");
                li.eq(0).find('.jq-title').html(title);
                li.find('.user_button').html(buttonCate);
            }
        });
    });
});
</script>              
@stop
