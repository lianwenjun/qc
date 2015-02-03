@extends('evolve.layout')
@section('custom')
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/common.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugins/jquery-ui/jquery-ui.min.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugins/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/fonts.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugin.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/pages/ads.css') }}">
<script type="text/javascript" src="{{ asset('/evolve/js/admin/jquery-1.9.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/timepicker/jquery-ui-timepicker-addon.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/timepicker/jquery-ui-timepicker-zh-CN.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/select2/i18n/zh-CN.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/common.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/pages/autoComplete.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/pages/ads/edit.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/pages/datetimepicker.js') }}"></script>
@stop
@section('content')
<div class="breadcrumb">
            <a href="javascript:;">广告位管理</a><span>&gt;</span><a href="frontendpics.html">首页图片位管理</a><span>&gt;</span>新增
        </div>  
        <div class="content"> 
            <!-- 表单 -->
            {{ Form::open(['route' => $datas['routeAs'].'create', 'method' => 'post']) }}
                <p class="record-title">应用信息：</p>
                <table cellpadding="0" cellspacing="0" class="edit-zebra-table">
                    <tbody>
                        <tr>
                            <td class="label">请输入游戏名称：</td>
                            <td>
                                <input class="input label-content jq-searchGameName" type="text" name="searchGameName" placeholder="应用名称输入时自动匹配" />
                                <input class="jq-searchGameId" type="hidden" name="gameId" value="" />
                            </td>
                        </tr>
                        <!-- <tr>
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
                                <textarea class="textarea" name="summary"></textarea>
                            </td>
                        </tr> -->
                        @if($datas['type'] != 'choice')
                        <tr>
                            <td class="label">广告区域：</td>
                            <td>
                                {{ Form::select('location', $datas['locations'], '', ['class' => 'select']) }}
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
                        @else
                        {{ Form::hidden('location', 'app_choice') }}
                        @endif
                        <tr>
                            <td class="label">排序：</td>
                            <td>
                                <input type="text" placeholder="例：1" class="input" name="sort" value="" />
                                <span class="red">（值为空，按上架时间默认升序排列）</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">上线时间：</td>
                            <td>
                                <input type="text" class="input jq-startime" name="stocked_at" /> 到 
                                <input type="text" class="input jq-endtime" name="unstocked_at"/>
                                <span class="red">（下架时间为空，为不限下架时间）</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="inline-button">
                    <input type="submit" value="提&#12288;交" class="button" />
                    <a href="{{ URL::route($datas['routeAs'].'index')}}" class="button">返回列表</a>
                </p>
            {{ Form::close() }}
            <!-- /表单 -->
        </div>
        <p class="copyright"><a class="link-gray">使用前必读</a><span>粤ICP证030173号</span></p>
        @stop