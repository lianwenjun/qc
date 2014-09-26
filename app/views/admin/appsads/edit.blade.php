@extends('admin.layout')

@section('content') 
<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>广告位管理 <span>首页游戏位管理</span><b>添加游戏</b></h1></div>                 
    <div class="Search_title">游戏信息</div>
        <div class="Search_biao">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                
                <form action="{{ URL::route('appsads.edit') }}" method="post">
                    <!--数据选择区开始-->
                    <tr class="Search_biao_two">
                        <td  class="Search_lei">游戏ID：</td>
                        <td>{{ $ad->app_id }}</td>
                    </tr>

                    <tr class="Search_biao_one">
                        <td  class="Search_lei">游戏名称：</td>
                        <td>{{ $app->title }}</td>
                    </tr>

                    <tr class="Search_biao_two">
                        <td  class="Search_lei">包名：</td>
                        <td>{{ $app->package }}</td>
                    </tr>

                    <tr class="Search_biao_one">
                        <td  class="Search_lei">大小：</td>
                        <td>{{ $app->size }}</td>
                    </tr>

                    <tr class="Search_biao_two">
                        <td  class="Search_lei">版本号：</td>
                        <td>{{ $app->version }}</td>
                    </tr>

                    <tr class="Search_biao_one">
                        <td  class="Search_lei">上传时间：</td>
                        <td class="Search_apk">{{ $app->created_at }}</td>
                    </tr>

                    <tr class="Search_biao_two">
                        <td  class="Search_lei">ICON：</td>
                        <td><span class="Search_apk"><img src="{{ $app->icon }}" width="90" height="90" /></span></td>
                    </tr>
                    <!--数据选择区结束-->
                    <tr class="Search_biao_one">
                        <td  class="Search_lei">广告区域：</td>
                        <td>
                        <span style="float:left">
                            {{ Form::select('location', $location, $ad->location, ['class'=>'Search_select']); }}
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
                        <td><input name="is_top" type="checkbox" value="" />
                          是　<span style=" color:#C00">（选中后无论上架广告数量，该广告均会在轮播中出现）</span></td>
                    </tr>

                    <tr class="Search_biao_one">
                        <td  class="Search_lei">上线时间：</td>
                        <td><h6>从 </h6> <h6><img src="images/darte.jpg" width="156" height="22" /></h6> <h6> 到 </h6> <h6><img src="images/darte.jpg" width="156" height="22" /></h6></td>
                    </tr>

                    <tr class="Search_biao_two">
                        <td colspan="2" align="center"  class="Search_submit"><input name="" type="submit" value="提 交" /> <a href="img_Promotion.html" target=BoardRight>返回列表</a></td>
                    </tr>
                </form>
                </table>
        </div>                 
    </div>
</div>
@stop