@extends('admin.layout')

@section('content')
<link href="{{ asset('css/admin/timepicker/jquery-ui-1.11.0.custom.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/admin/timepicker/jquery-ui-timepicker-addon.css') }}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{ asset('js/jquery-ui-1.8.23.custom.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-addon.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/timepicker/jquery-ui-timepicker-zh-CN.js') }}"></script>
<div class="Content_right_top Content_height">
   <div class="Theme_title">
      <h1>游戏管理 <span>上架游戏列表</span></h1>
   </div>
   <form action="Game_List.html" method="get">
      <div class="Theme_Search">
         <ul>
            <li>
               <span>
                  <b>查询：</b>
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
   <div class="Search_cunt">上架游戏：共 <strong>55</strong> 条记录 </div>
   <div class="Search_biao">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr class="Search_biao_title">
            <td width="6%">游戏ID</td>
            <td width="4%">icon</td>
            <td width="8%">游戏名称</td>
            <td width="12%">包名</td>
            <td width="7%">游戏分类</td>
            <td width="5%" style="cursor:pointer">大小 ↑</td>
            <td width="6%">版本号</td>
            <td width="7%">预览</td>
            <td width="7%" style="cursor:pointer">下载量 ↑</td>
            <td width="8%" style="cursor:pointer">上架时间 ↑</td>
            <td width="18%">操作</td>
         </tr>
         <tr class="Search_biao_one">
            <td>10</td>
            <td><img src="images/u1188.png" width="28" height="28" /></td>
            <td>植物大战僵尸</td>
            <td>com.xxxxxxx.xxxx.xx</td>
            <td>休闲益智</td>
            <td>12.6 M</td>
            <td>3.1.124</td>
            <td><a href="#" class="Search_Look">点击预览</a></td>
            <td>1586</td>
            <td>2014-7-9</td>
            <td><a href="#" class="Search_show">下架</a> <a href="Update.html" target=BoardRight class="Search_show">更新</a> <a href="History.html" target=BoardRight class="Search_show">历史版本</a> </td>
         </tr>
         <tr class="Search_biao_two">
            <td>9</td>
            <td><img src="images/u1188.png" width="28" height="28" /></td>
            <td>植物大战僵尸</td>
            <td>com.xxxxxxx.xxxx.xx</td>
            <td>休闲益智</td>
            <td>12.6 M</td>
            <td>3.1.124</td>
            <td><a href="#" class="Search_Look">点击预览</a></td>
            <td>1586</td>
            <td>2014-7-9</td>
            <td><a href="#" class="Search_show">下架</a> <a href="Update.html" target=BoardRight class="Search_show">更新</a> <a href="History.html" target=BoardRight class="Search_show">历史版本</a> </td>
         </tr>
         <tr class="Search_biao_one">
            <td>8</td>
            <td><img src="images/u1188.png" width="28" height="28" /></td>
            <td>植物大战僵尸</td>
            <td>com.xxxxxxx.xxxx.xx</td>
            <td>休闲益智</td>
            <td>12.6 M</td>
            <td>3.1.124</td>
            <td><a href="#" class="Search_Look">点击预览</a></td>
            <td>1586</td>
            <td>2014-7-9</td>
            <td><a href="#" class="Search_show">下架</a> <a href="Update.html" target=BoardRight class="Search_show">更新</a> <a href="History.html" target=BoardRight class="Search_show">历史版本</a> </td>
         </tr>
         <tr class="Search_biao_two">
            <td>7</td>
            <td><img src="images/u1188.png" width="28" height="28" /></td>
            <td>植物大战僵尸</td>
            <td>com.xxxxxxx.xxxx.xx</td>
            <td>休闲益智</td>
            <td>12.6 M</td>
            <td>3.1.124</td>
            <td><a href="#" class="Search_Look">点击预览</a></td>
            <td>1586</td>
            <td>2014-7-9</td>
            <td><a href="#" class="Search_show">下架</a> <a href="Update.html" target=BoardRight class="Search_show">更新</a> <a href="History.html" target=BoardRight class="Search_show">历史版本</a> </td>
         </tr>
         <tr class="Search_biao_one">
            <td>6</td>
            <td><img src="images/u1188.png" width="28" height="28" /></td>
            <td>植物大战僵尸</td>
            <td>com.xxxxxxx.xxxx.xx</td>
            <td>休闲益智</td>
            <td>12.6 M</td>
            <td>3.1.124</td>
            <td><a href="#" class="Search_Look">点击预览</a></td>
            <td>1586</td>
            <td>2014-7-9</td>
            <td><a href="#" class="Search_show">下架</a> <a href="Update.html" target=BoardRight class="Search_show">更新</a> <a href="History.html" target=BoardRight class="Search_show">历史版本</a> </td>
         </tr>
         <tr class="Search_biao_two">
            <td>5</td>
            <td><img src="images/u1188.png" width="28" height="28" /></td>
            <td>植物大战僵尸</td>
            <td>com.xxxxxxx.xxxx.xx</td>
            <td>休闲益智</td>
            <td>12.6 M</td>
            <td>3.1.124</td>
            <td><a href="#" class="Search_Look">点击预览</a></td>
            <td>1586</td>
            <td>2014-7-9</td>
            <td><a href="#" class="Search_show">下架</a> <a href="Update.html" target=BoardRight class="Search_show">更新</a> <a href="History.html" target=BoardRight class="Search_show">历史版本</a> </td>
         </tr>
         <tr class="Search_biao_one">
            <td>4</td>
            <td><img src="images/u1188.png" width="28" height="28" /></td>
            <td>植物大战僵尸</td>
            <td>com.xxxxxxx.xxxx.xx</td>
            <td>休闲益智</td>
            <td>12.6 M</td>
            <td>3.1.124</td>
            <td><a href="#" class="Search_Look">点击预览</a></td>
            <td>1586</td>
            <td>2014-7-9</td>
            <td><a href="#" class="Search_show">下架</a> <a href="Update.html" target=BoardRight class="Search_show">更新</a> <a href="History.html" target=BoardRight class="Search_show">历史版本</a> </td>
         </tr>
         <tr class="Search_biao_two">
            <td>3</td>
            <td><img src="images/u1188.png" width="28" height="28" /></td>
            <td>植物大战僵尸</td>
            <td>com.xxxxxxx.xxxx.xx</td>
            <td>休闲益智</td>
            <td>12.6 M</td>
            <td>3.1.124</td>
            <td><a href="#" class="Search_Look">点击预览</a></td>
            <td>1586</td>
            <td>2014-7-9</td>
            <td><a href="#" class="Search_show">下架</a> <a href="Update.html" target=BoardRight class="Search_show">更新</a> <a href="History.html" target=BoardRight class="Search_show">历史版本</a> </td>
         </tr>
      </table>
      <div id="pager"></div>
   </div>
</div>
@end