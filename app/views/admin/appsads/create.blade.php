@extends('admin.layout')

@section('content') 
<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>广告位管理 <span>首页游戏位管理</span><b>添加游戏</b></h1></div>                 
    <div class="Search_title">游戏信息</div>
        <div class="Search_biao">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr class="Search_biao_one">
                        <td width="134" class="Search_lei">请输入游戏名称：</td>
                        <td><input name="" type="text" class="Search_text" value="应用名称输入时自动匹配" style="width:25%" />　或　从最近新增的游戏添加　<a href="#" class="Search_Update">选择</a></td>
                    </tr>
                    <!--数据选择区开始-->
                    <tr class="Search_biao_two">
                        <td  class="Search_lei">游戏ID：</td>
                        <td>1</td>
                    </tr>

                    <tr class="Search_biao_one">
                        <td  class="Search_lei">游戏名称：</td>
                        <td>植物大战僵尸</td>
                    </tr>

                    <tr class="Search_biao_two">
                        <td  class="Search_lei">包名：</td>
                        <td>com.xxxxxxx.xxx</td>
                    </tr>

                    <tr class="Search_biao_one">
                        <td  class="Search_lei">大小：</td>
                        <td>12.3M</td>
                    </tr>

                    <tr class="Search_biao_two">
                        <td  class="Search_lei">版本号：</td>
                        <td>3.1.12</td>
                    </tr>

                    <tr class="Search_biao_one">
                        <td  class="Search_lei">上传时间：</td>
                        <td class="Search_apk">2014-7-9</td>
                    </tr>

                    <tr class="Search_biao_two">
                        <td  class="Search_lei">ICON：</td>
                        <td><span class="Search_apk"><img src="images/u1188.png" width="90" height="90" /></span></td>
                    </tr>
                    <!--数据选择区结束-->
                    <tr class="Search_biao_one">
                        <td  class="Search_lei">广告区域：</td>
                        <td>
                        <span style="float:left">
                            <select class="Search_select">
                                <option value="广告区域" selected="">广告区域</option>
                                <option value="热门下载（首页）">热门下载（首页）</option>
                                <option value="新品抢玩（首页）">新品抢玩（首页）</option>
                                <option value="精品推荐（搜索页）">精品推荐（搜索页）</option>
                            </select>
                         </span>
                       </td>
                    </tr>

                    <tr class="Search_biao_two">
                        <td  class="Search_lei">游戏截图：</td>
                        <td><a href="#" class="Search_Update">图片上传</a> <span style="color:#C00">（焦点图480*200，专题图230*120）</span></td>
                    </tr>

                    <tr class="Search_biao_one">
                        <td  class="Search_lei">截图预览：</td>
                        <td class="Search_img">
                        <div class="Update_img">
                            <ul id="listdata">
                                <li><img src="images/1.jpg" /><a href="#">删除</a></li>
                            </ul>
                        </div>

                        </td>
                    </tr>

                    <tr class="Search_biao_two">
                        <td  class="Search_lei">广告置顶：</td>
                        <td><input name="input" type="checkbox" value="" />
                          是　<span style=" color:#C00">（选中后无论上架广告数量，该广告均会在轮播中出现）</span></td>
                    </tr>

                    <tr class="Search_biao_one">
                        <td  class="Search_lei">上线时间：</td>
                        <td><h6>从 </h6> <h6><img src="images/darte.jpg" width="156" height="22" /></h6> <h6> 到 </h6> <h6><img src="images/darte.jpg" width="156" height="22" /></h6></td>
                    </tr>

                    <tr class="Search_biao_two">
                        <td colspan="2" align="center"  class="Search_submit"><input name="" type="submit" value="提 交" /> <a href="img_Promotion.html" target=BoardRight>返回列表</a></td>
                    </tr>
                </table>
        </div>                 
    </div>
</div>
@stop