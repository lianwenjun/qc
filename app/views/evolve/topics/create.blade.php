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
            <a href="javascript:;">广告位管理</a><span>&gt;</span><a href="draft.html">专题编辑管理</a><span>&gt;</span>编辑
        </div>  
        <div class="content"> 
            <!-- 表单 -->
            <form name="form" action="" method="get" class="validate jq-form">
                <p class="record-title">应用信息：</p>
                <table cellpadding="0" cellspacing="0" class="edit-zebra-table">
                    <tbody>
                        <tr>
                            <td class="label">专题名称：</td>
                            <td>
                                <input type="text" placeholder="请输入......" class="input label-content" name="keywords" />
                            </td>
                        </tr>
                        <tr>
                            <td class="label">小编点评：</td>
                            <td>
                                <textarea class="textarea"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">上传图片：</td>
                            <td>
                                <div class="pr upload-button-wrap icon230x120 jq-addImg">
                                    <img src="../images/pages/pic-preview1.jpg" class="icon230x120" />
                                    <div class="add-img"><i class="icon-plus"></i></div>
                                    <input type="file" class="upload-button" title="上传图片" style="width: 230px; height: 120px" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">首页展示：</td>
                            <td>
                                <select class="select" name="hot-download">
                                    <option value="">热门下载专题位</option>
                                    <option value="">新品抢玩专题位</option>
                                    <option value="">首页专题位一</option>
                                    <option value="">首页专题位二</option>
                                    <option value="">首页专题位三</option>
                                    <option value="">首页专题位四</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label">添加游戏内容：</td>
                            <td>
                                <ul class="game-content fl">
                                    <li>
                                        <img src="../images/pages/icon90.jpg" class="icon25" />
                                        <p class="gametag">我叫MT online<span class="jq-delete">×</span></p>
                                    </li>
                                    <li>
                                        <input type="text" placeholder="标签输入时自动匹配" class="input" />
                                        <span class="input-delete jq-del">×</span>
                                    </li>
                                </ul>
                                <input class="button jq-add" type="button" value="+">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="inline-button">
                    <input type="button" value="存为草稿件" class="button" />
                    <input type="submit" value="  提  交  " class="button" />
                    <a href="draft.html" class="button">返回列表</a>
                </p>
            </form>
            <!-- /表单 -->
        </div>
        <p class="copyright"><a class="link-gray">使用前必读</a><span>粤ICP证030173号</span></p>
@stop