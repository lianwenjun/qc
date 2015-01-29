@extends('evolve.layout')
@section('custom')
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/common.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugins/jquery-ui/jquery-ui.min.css') }}">
<link rel="stylesheet" href="../css/fonts.css">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugin.css') }}">
<link rel="stylesheet" href="../css/pages/ads.css">
<script type="text/javascript" src="{{ asset('/evolve/js/admin/jquery-1.9.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery-ui/datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery-ui/datepicker.zh-CN.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/timepicker/jquery-ui-timepicker-addon.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/timepicker/jquery-ui-timepicker-zh-CN.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/common.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/pages/ads/edit.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/pages/datetimepicker.js') }}"></script>

@stop
@section('content')

	<div class="breadcrumb">
        <a href="javascript:;">广告位管理</a><span>&gt;</span><a href="frontendpics.html">首页图片位管理</a><span>&gt;</span>编辑
    </div>  
    <div class="content"> 
        <!-- 表单 -->
        <form name="form" action="" method="get" class="validate jq-form">
            <p class="record-title">应用信息：</p>
            <table cellpadding="0" cellspacing="0" class="edit-zebra-table">
                <tbody>
                    <tr>
                        <td class="label">请输入游戏名称：</td>
                        <td>
                            <input type="text" placeholder="应用名称输入时自动匹配" class="input label-content" name="keywords" />
                        </td>
                    </tr>
                    <tr>
                        <td class="label">ID：</td>
                        <td>1234567</td>
                    </tr>
                    <tr>
                        <td class="label">游戏名称：</td>
                        <td>我叫MT online（天天专属版）</td>
                    </tr>
                    <tr>
                        <td class="label">包名：</td>
                        <td>game name</td>
                    </tr>
                    <tr>
                        <td class="label">大小：</td>
                        <td>365.1M</td>
                    </tr>
                    <tr>
                        <td class="label">版本：</td>
                        <td>4.0.4</td>
                    </tr>
                    <tr>
                        <td class="label">图标：</td>
                        <td>
                            <img src="../images/pages/icon90.jpg" class="icon90" />
                        </td>
                    </tr>
                    <tr>
                        <td class="label">小编点评：</td>
                        <td>
                            <p class="text t2">把公文种类调整为十二类十三种，删去“指令”、“决议”、“布告”三个文种，将“议案”作为一个新文种列入主要公文种类。即：命令（令），议案，决定，指示，公告，通告，通知，通报，报告，请示，批复，函，会议纪要。此外，中共中央办公厅于1989年4月25日发布的《中国共产党各级领导机关文件处理条例（试行）》中，正式文件的种类里还列有公报、条例、规定三个文种。这样，现在常用的公文种类总共有十六种。</p>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">广告区域：</td>
                        <td>
                            <select class="select" name="ads">
                                <option value="">广告区域</option>
                                <option value="轮播焦点图">轮播焦点图</option>
                                <option value="专题管理">专题管理</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">上传图片：</td>
                        <td>
                            <div class="pr upload-button-wrap icon240x100 jq-addPic">
                                <img src="../images/pages/pic-preview1.jpg" class="icon240x100" />
                                <div class="add-pic"><i class="icon-plus"></i></div>
                                <input type="file" class="upload-button" title="上传图片" style="width: 240px; height: 100px" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">排序：</td>
                        <td>
                            <input type="text" placeholder="3" class="input" />
                            <span class="red">（值为空，按上架时间默认升序排列）</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">上线时间：</td>
                        <td>
                            <input type="text" class="input jq-startime" name="startime" /> 到 <input type="text" class="input jq-endtime" />
                            <span class="red">（下架时间为空，为不限下架时间）</span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="inline-button">
                <input type="submit" value="  提  交  " class="button" />
                <a href="frontendpics.html" class="button">返回列表</a>
            </p>
        </form>
        <!-- /表单 -->
    </div>
    <p class="copyright"><a class="link-gray">使用前必读</a><span>粤ICP证030173号</span></p>
@stop