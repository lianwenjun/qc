@extends('admin.layout')

@section('content')   
    <div class="Content_right_top Content_height">
        <div class="Theme_title">
            <h1>游戏管理 <span>上传游戏</span></h1>
            <a href="#" id="Upload" target=BoardRight>游戏上传</a>
        </div>
    <form action="Game_List.html" method="get">
        <div class="Theme_Search">
            <ul>
                
                <li>
                    <span><b>查询：</b>
                    <select name="">
                        <option>--全部--</option>
                        <option>1</option>
                    </select>
                    </span>
                    <span><input name="" type="text" class="Search_wenben" size="20" value="请输入关键词" /></span>
                    <span>　<b>日期：</b><img src="images/darte.jpg" width="156" height="22" /><b>-</b><img src="images/darte.jpg" width="156" height="22" /></span>
                    <input name="" type="submit" value="搜索" class="Search_en" />
                </li>
                
            </ul>
        </div>
    </form>
    <div class="Search_cunt">待编辑游戏：共 <strong>55</strong> 条记录 </div>
    <div class="Search_biao">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="Search_biao_title">
                <td width="6%">游戏ID</td>
                <td width="6%">icon</td>
                <td width="10%">游戏名称</td>
                <td width="15%">包名</td>
                <td width="8%">游戏分类</td>
                <td width="8%">大小</td>
                <td width="8%">版本号</td>
                <td width="8%">上架时间</td>
                <td width="12%">操作</td>
            </tr>
            <tr class="Search_biao_one">
                <td>10</td>
                <td><img src="images/u1188.png" width="28" height="28" /></td>
                <td>植物大战僵尸</td>
                <td>com.xxxxxxx.xxxx.xx</td>
                <td>休闲益智</td>
                <td>12.6 M</td>
                <td>3.1.124</td>
                <td>2014-7-9</td>
                <td><a href="Editor.html" target=BoardRight class="Search_show">编辑</a> <a href="#" class="Search_del">删除</a></td>
            </tr>
            <tr class="Search_biao_two">
                <td>10</td>
                <td><img src="images/u1188.png" width="28" height="28" /></td>
                <td>植物大战僵尸</td>
                <td>com.xxxxxxx.xxxx.xx</td>
                <td>休闲益智</td>
                <td>12.6 M</td>
                <td>3.1.124</td>
                <td>2014-7-9</td>
                <td><a href="Editor.html" target=BoardRight class="Search_show">编辑</a> <a href="#" class="Search_del">删除</a></td>
            </tr>
            <tr class="Search_biao_one">
                <td>10</td>
                <td><img src="images/u1188.png" width="28" height="28" /></td>
                <td>植物大战僵尸</td>
                <td>com.xxxxxxx.xxxx.xx</td>
                <td>休闲益智</td>
                <td>12.6 M</td>
                <td>3.1.124</td>
                <td>2014-7-9</td>
                <td><a href="Editor.html" target=BoardRight class="Search_show">编辑</a> <a href="#" class="Search_del">删除</a></td>
            </tr>
            <tr class="Search_biao_two">
                <td>10</td>
                <td><img src="images/u1188.png" width="28" height="28" /></td>
                <td>植物大战僵尸</td>
                <td>com.xxxxxxx.xxxx.xx</td>
                <td>休闲益智</td>
                <td>12.6 M</td>
                <td>3.1.124</td>
                <td>2014-7-9</td>
                <td><a href="Editor.html" target=BoardRight class="Search_show">编辑</a> <a href="#" class="Search_del">删除</a></td>
            </tr>
            
            <tr class="Search_biao_one">
                <td>10</td>
                <td><img src="images/u1188.png" width="28" height="28" /></td>
                <td>植物大战僵尸</td>
                <td>com.xxxxxxx.xxxx.xx</td>
                <td>休闲益智</td>
                <td>12.6 M</td>
                <td>3.1.124</td>
                <td>2014-7-9</td>
                <td><a href="Editor.html" target=BoardRight class="Search_show">编辑</a> <a href="#" class="Search_del">删除</a></td>
            </tr>
            
            <tr class="Search_biao_two">
                <td>10</td>
                <td><img src="images/u1188.png" width="28" height="28" /></td>
                <td>植物大战僵尸</td>
                <td>com.xxxxxxx.xxxx.xx</td>
                <td>休闲益智</td>
                <td>12.6 M</td>
                <td>3.1.124</td>
                <td>2014-7-9</td>
                <td><a href="Editor.html" target=BoardRight class="Search_show">编辑</a> <a href="#" class="Search_del">删除</a></td>
            </tr>
            
            <tr class="Search_biao_one">
                <td>10</td>
                <td><img src="images/u1188.png" width="28" height="28" /></td>
                <td>植物大战僵尸</td>
                <td>com.xxxxxxx.xxxx.xx</td>
                <td>休闲益智</td>
                <td>12.6 M</td>
                <td>3.1.124</td>
                <td>2014-7-9</td>
                <td><a href="Editor.html" target=BoardRight class="Search_show">编辑</a> <a href="#" class="Search_del">删除</a></td>
            </tr>
            
            <tr class="Search_biao_two">
                <td>10</td>
                <td><img src="images/u1188.png" width="28" height="28" /></td>
                <td>植物大战僵尸</td>
                <td>com.xxxxxxx.xxxx.xx</td>
                <td>休闲益智</td>
                <td>12.6 M</td>
                <td>3.1.124</td>
                <td>2014-7-9</td>
                <td><a href="Editor.html" target=BoardRight class="Search_show">编辑</a> <a href="#" class="Search_del">删除</a></td>
            </tr>
            
            <tr class="Search_biao_one">
                <td>10</td>
                <td><img src="images/u1188.png" width="28" height="28" /></td>
                <td>植物大战僵尸</td>
                <td>com.xxxxxxx.xxxx.xx</td>
                <td>休闲益智</td>
                <td>12.6 M</td>
                <td>3.1.124</td>
                <td>2014-7-9</td>
                <td><a href="Editor.html" target=BoardRight class="Search_show">编辑</a> <a href="#" class="Search_del">删除</a></td>
            </tr>
            
            <tr class="Search_biao_two">
                <td>10</td>
                <td><img src="images/u1188.png" width="28" height="28" /></td>
                <td>植物大战僵尸</td>
                <td>com.xxxxxxx.xxxx.xx</td>
                <td>休闲益智</td>
                <td>12.6 M</td>
                <td>3.1.124</td>
                <td>2014-7-9</td>
                <td><a href="Editor.html" target=BoardRight class="Search_show">编辑</a> <a href="#" class="Search_del">删除</a></td>
            </tr>
        </table>
        <div id="pager"></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#Upload").click(function(){
                $.jBox("iframe:add_apk.html", {  
                    title: "<div class=ask_title>游戏上传</div>",  
                    width: 650,  
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
</script>
@stop
