@extends('admin.layout')

@section('content')               
<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>系统管理 <span> 游戏分类管理</span></h1></div>
    <div class="Theme_Search">
        <ul>
            <li> 
                 @if (Sentry::getUser()->hasAccess('cate.create'))
                 <span><input id="Classification" type="submit" value="添加分类" class="Search_en" /></span>
                 @endif
                 @if (Sentry::getUser()->hasAccess('tag.create'))
                 <span><input id="Tag" type="submit" value="添加标签" class="Search_en" /></span>
                 @endif
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
                                <li class="jq-cate" data-cate-id="{{  $cate['data']['id'] }}"><a href="javascript:;"><span class="Push_page">{{  $cate['data']['title'] }}</span></a>
                                    <!--二级分类!-->
                                    <ul>
                                        @foreach($cate['list'] as $tag)
                                            <li class="Push_fen"><span>{{$tag['title']}}</span></li>
                                        @endforeach
                                    </ul>
                                    <!--二级分类!-->
                                </li>
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
                                <!--标签列表开始!-->
                                <!--标签列表结束!-->
                                </ul>
                            </div>
                            <div class="down"></div>
                        </div>

                        <div class="user_right_width"></div> 
                        <!--标签信息-->
                        <p class='jq-tagList'>
                        <!--标签列表详细开始>!-->
                        <!--标签列表详细结束!-->
                        </p>
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
function delMsgBox(func) {
    $.jBox("<p style='margin: 10px'>您要删除吗？</p>", {
            title: "<div class='ask_title'>是否删除？</div>",
            showIcon: false,
            draggable: false,
            buttons: {'确定':true, "算了": false},
            submit: function(v, h, f) {
                if (v){
                    func();
                }
            }
    });
};

function returnMsgBox(text) {
    $.jBox("<p style='margin: 10px'>"+text+"</p>", {
            title: "<div class='ask_title'>返回结果</div>",
            showIcon: false,
            draggable: false,
    });
};
$(function(){
    $(".jq-cate:odd").addClass("Push_left_two");
    $(".jq-cate:even").addClass("Push_left_one");
    $("#scrollDiv").textSlider({line:4,speed:500,timer:3000});

    //JQ-add
    cateCreateUrl = "{{ route('cate.create') }}";
    tagCreateUrl = "{{ route('tag.create') }}";
    updateCate = '<a class="Search_show jq-updateCate" href="javascript:;">确定</a>';
    updateTag = '<a class="Search_show jq-updateTag" href="javascript:;">确定</a>';
    buttonCate = '<a class="Search_show jq-editCate" href="javascript:;">修 改</a><a class="Search_xiajia jq-delCate" href="javascript:;">删除</a>';
    buttonTag = '<a class="Search_show jq-editTag" href="javascript:;">修 改</a><a class="Search_xiajia jq-delTag" href="javascript:;">删除</a>';
    var cateText = '<table align="center" border="0" cellspacing="0" cellpadding="0" class="add_Classification">' +
                    '<tr>' + 
                        '<td width="114" align="right">分类名称：</td>' + 
                        '<td height="40"><input name="cate" maxlength="15" type="text" class="add_Classification_text"/></td>' + 
                    '</tr><tr>' + 
                        '<td colspan="2" style=" text-align:center; padding:15px 0px;">'+
                        '<input name="" type="button" value="添加" class="Search_en jq-addCate" /></td>'+
                    '</tr></table>';
    var tagText =   '<table align="center" border="0" cellspacing="0" cellpadding="0" class="add_Classification">' +
                        '<tr>'+
                        '<td width="114" align="right">所属分类：</td>' + 
                        '<td height="40">' + 
                            '<select id="u117_input" name="parent_id">' +
                                @foreach($allcates as $cate)
                                    '<option value="{{ $cate->id }}">{{ $cate->title }}</option>' +
                                @endforeach
                            '</select>' + 
                        '</td></tr><tr>' + 
                        '<td align="right" valign="top">标签名称：</td>' +
                        '<td height="40">' + 
                            '<input name="tag" maxlength="15" type="text"  class="add_Classification_text"/>' +
                        '</td></tr><tr>' +
                        '<td colspan="2" style=" text-align:center; padding:15px 0px;">' +
                            '<input name="" type="button" value="添加" class="Search_en jq-addTag" />' +
                        '</td></tr></table>';
    //添加分类
    function addCate(){
        var processCate = function(){
            var cate = $('input[name=cate]').val();
            var createUrl = "{{ route('cate.create') }}";
            $.post(createUrl, {word:cate}, function(res){
                if ( res.status == 'ok' ){
                    $.jBox.close();
                    return;
                }
                returnMsgBox('添加分类失败');
            });
        };
        $('.jq-addCate').click(function(){
            processCate();
        });
        //ENTER健监听
        var $inp = $('input[name=cate]'); 
        $inp.keypress(function (e) { 
            var key = e.which; 
            if (key == 13) {
                processCate();
            }
        });
    }
    //添加便签
    function addTag(){
        var processTag = function () {
            var parent_id = $('select[name=parent_id]').val();
            var tag = $('input[name=tag]').val();
            if (tag == '' || tag == undefined){
                return;
            }
            var createUrl = "{{ route('tag.create') }}";

            $.post(createUrl, {parent_id:parent_id,word:tag}, function(res){
                if ( res.status == 'ok' ){
                    $.jBox.close();
                    return;
                }
                returnMsgBox('添加标签失败');
            });
        }
        $('.jq-addTag').click(function(){
            processTag();
        });
        //ENTER健监听
        var $inp = $('input[name=tag]'); 
        $inp.keypress(function (e) { 
            var key = e.which; 
            if (key == 13) {
                processTag();
            }
        });
    }
    $("#Classification").click(function(){
        $.jBox(cateText, {  
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
                addCate();
            }
            ,
            closed:function(){
                $("body").css("overflow-y","auto");
                location.href = location.href;
            }
           
        });
        
    });
    
    $("#Tag").click(function(){
        $.jBox(tagText, {  
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
                addTag();
            }
            ,
            closed:function(){
                $("body").css("overflow-y","auto");
                location.href = location.href;
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
                returnMsgBox('修改成功');
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
                    text1 += '<li data-tag-id="'+tagdata.data.id+'" class="jq-tagClick jq-tagClick-'+tagdata.data.id+'"">'+tagdata.data.title+'</li>';
                    text2 += '<div class="user_right_title jq-tagDisplay jq-tagDisplay-'+tagdata.data.id+'" style="display:none">' + 
                                '<ul>' +
                                    '<li class="user_two"><strong>所属标签：</strong><p class="jq-title">'+tagdata.data.title+'</p></li>'+
                                    '<li class="user_one"><strong>标签ID：</strong>'+tagdata.data.id+'</li>'+
                                    '<li class="user_two"><strong>搜索次数：</strong>'+tagdata.data.search_total+'</li>'+
                                    '<li class="user_one"><strong>游戏数量：</strong>'+tagdata.count+'</li>'+
                                    '<li class="user_one"><strong>添加时间：</strong>'+tagdata.data.created_at+'</li>'+
                                    '<li class="user_button">'+buttonTag+'</li>'+
                                    '<input type="hidden" name="pre_title" value="'+tagdata.data.title+'"/>' + 
                                    '<input type="hidden" name="edit_url" value="'+tagdata.editurl+'"/>' + 
                                    '<input type="hidden" name="del_url" value="'+tagdata.delurl+'"/>' +
                                    '<input type="hidden" name="tag_id" value="'+tagdata.data.id+'"/>' +                                '</ul>' +
                                '</div>';
                }
                $(".jq-tagul ul").html(text1);
                $(".jq-tagList").html(text2);
                $(".user_right").show();
                $(".jq-tagClick:odd").addClass("scrollText_two");
                $(".jq-tagClick:even").addClass("scrollText_one");
            }
        });
    });
    //点击标签
    $(".jq-tagClick").live('click', function() {
        //清理掉hover的选择并还原数据
        var tag = $(".scrollText_hover");
        tag.removeClass('scrollText_hover');
        var tagId = tag.attr('data-tag-id');
        var title = $(".jq-tagDisplay-"+tagId+' ul input[name=pre_title]').val();
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
        var to_title = '<input name="edit_tag" type="text" value="" />';
        li.eq(0).find('.jq-title').html(to_title);
        li.eq(0).find('input[name=edit_tag]').val(title);
        li.eq(5).html(updateTag);
    });
    //点击确定修改标签
    $(".jq-updateTag").live('click', function(){
        var li = $(this).parents('ul').children('li');
        var title = li.eq(0).find('input[name=edit_tag]').val();
        var data = {word:title};
        var editUrl = $(this).parents().find('input[name=edit_url]').val();
        var tagId = $(this).parents().find('input[name=tag_id]').val();
        $.post(editUrl, data, function(res) {
            if (res.status == 'ok'){
                returnMsgBox('修改成功');
                li.eq(0).find('.jq-title').html(title);
                li.find('.user_button').html(buttonTag);
                $(".jq-tagClick-"+tagId).text(title);
            }
        });
    });
    //点击删除标签
    $(".jq-delTag").live('click', function(){
        var thisObj = $(this);
        var del = function() {
            var delUrl = thisObj.parents().find('input[name=del_url]').val();
            var tagId = thisObj.parents().find('input[name=tag_id]').val();
            $.get(delUrl, function(res) {
                if (res.status == 'ok') {
                    $(".jq-tagDisplay-"+tagId).hide();
                    $(".jq-tagClick-"+tagId).remove();
                }   
            });
        };
        delMsgBox(del);
    });
    //点击删除分类
    $(".jq-delCate").live('click', function(){
        var thisObj = $(this);
        var del = function(){
            var delUrl = thisObj.parents().find('input[name=del_url]').val();
            $.get(delUrl, function(res) {
                if (res.status == 'ok') {
                    window.location.href = window.location.pathname;
                }
            });
        };
        delMsgBox(del);
    });
});
</script>              
@stop
