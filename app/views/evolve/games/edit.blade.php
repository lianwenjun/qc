@extends('evolve.layout')

@section('custom')
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/common.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugins/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugins/simditor/font-awesome.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugins/simditor/simditor.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugins/jquery-ui/jquery-ui.min.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/fonts.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugin.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/pages/apps.css') }}">
<script type="text/javascript" src="{{ asset('/evolve/js/admin/jquery-1.9.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/plupload/plupload.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/plupload/i18n/zh_CN.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery.tmpl.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/select2/i18n/zh-CN.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/simditor/module.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/simditor/uploader.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/simditor/simditor.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/common.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/pages/autoComplete.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/pages/apps/edit.js') }}"></script>
@stop

@section('breadcrumb')
<div class="breadcrumb">
    <a href="javascript:;">游戏管理</a><span>&gt;</span><a href="stock.html">上架游戏列表</a><span>&gt;</span>编辑
</div>
@stop

@section('content')
<div class="content"> 
    <!-- 表单 -->
    <form action="" method="get" class="validate jq-editForm">
        <p class="record-title">应用信息：</p>
        <table cellpadding="0" cellspacing="0" class="edit-zebra-table">
            <tbody class="jq-apkData">
                <tr>
                    <td class="label">ID：</td>
                    <td class="jq-apkId">{{ $game->id }}</td>
                </tr>
                <tr>
                    <td class="label">游戏名称：</td>
                    <td class="jq-apkName">{{ $game->title }}</td>
                </tr>
                <tr>
                    <td class="label">包名：</td>
                    <td class="jq-apkBag">{{ $game->package }}</td>
                </tr>
                <tr>
                    <td class="label">大小：</td>
                    <td class="jq-apkSize">{{ $game->size }}</td>
                </tr>
                <tr>
                    <td class="label">版本：</td>
                    <td class="jq-apkVersion">{{ $game->version }}</td>
                </tr>
                <tr>
                    <td class="label">版本代号：</td>
                    <td class="jq-apkVersion">{{ $game->version_code }}</td>
                </tr>
                <tr>
                    <td class="label">上传时间：</td>
                    <td class="jq-apkDate">{{ $game->created_at }}</td>
                </tr>
                <tr>
                    <td class="label">上传APK：</td>
                    <td>
                        <a href="javascript:;" class="button jq-apkUpload" id="apkUpload">选择APK文件</a>
                    </td>
                </tr>
                <tr>
                    <td class="label">上传图片：</td>
                    <td>
                        <div class="pr icon90 jq-addIcon">
                            <img class="icon90" src="{{ $game->icon }}" />
                            <div class="add-icon none" id="iconUpload"><i class="icon-plus"></i></div> 
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="label"><b class="red">*</b>游戏关键字：</td>
                    <td>
                        <input type="text" class="input label-content jq-keyword" value="" name="keyword" />
                    </td>
                </tr>
                <tr>
                    <td class="label"><b class="red">*</b>游戏分类：</td>
                    <td>
                        <span class="jq-initCate">休闲游戏，角色扮演</span>
                        <input type="button" value="修改" class="button jq-editSort" />
                        <input type="hidden" value=",1,4," class="jq-gameCate" name="checkCate" />
                    </td>
                </tr>
                <tr>
                    <td class="label"><b class="red">*</b>游戏标签：</td>
                    <td>
                        <ul class="jq-initTag">
                            <li class="gametag fl"><i>卡牌</i><span class="jq-deleteTag">×</span></li>
                            <li class="gametag fl"><i>战争</i><span class="jq-deleteTag">×</span></li>
                        </ul>
                        <input type="hidden" value=",卡牌,战争," class="jq-gameTag" name="gameTag" />
                    </td>
                </tr>
                <tr>
                    <td class="label"><b class="red">*</b>游戏作者：</td>
                    <td>
                        <input type="text" value="{{ $game->author }}" placeholder="深圳市第七大道科技有限公司" class="input label-content" name="author" />
                    </td>
                </tr>
                <!--<tr>
                    <td class="label"><b class="red">*</b>游戏供应商：</td>
                    <td>
                        <select class="select" name="supplier">
                            <option value="">游戏供应商</option>
                            <option value="乐逗游戏">乐逗游戏</option>
                            <option value="第七大道">第七大道</option>
                        </select>
                        <i>{{ $game->vendor }}</i>（供应商拼音简写）
                    </td>
                </tr>-->
                <tr>
                    <td class="label"><b class="red">*</b>系统要求：</td>
                    <td>
                        <select class="select" name="os_version">
                            <option value="">系统要求</option>
                            <option value="Android">Android</option>
                            <option value="IOS">IOS</option>
                        </select>
                        <select class="select" name="version">
                            <option value="">版本号</option>
                            <option value="2.1">2.1</option>
                            <option value="2.2">2.2</option>
                            <option value="2.3">2.3以上</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">排序：</td>
                    <td>
                        <input type="text" placeholder="9999" value="{{ $game->sort }}" class="input" name="sort" />
                    </td>
                </tr>
                <tr>
                    <td class="label">下载次数：</td>
                    <td>{{ $game->download_display }}</td>
                </tr>
                <tr>
                    <td class="label"><b class="red">*</b>游戏介绍：</td>
                    <td>
                        <textarea class="textarea" name="summary">{{ $game->summary }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td class="label">小编点评：</td>
                    <td>
                        <textarea class="textarea" name="review">{{ $game->review }}</textarea>
                    </td>
                </tr>
                <tr>
                    <td class="label"><b class="red">*</b>截图预览：</td>
                    <td>
                        <p class="red pic-tip">（最多上传6张，图片规格为220*370px 的JPG/PNG）</p>
                        <ul class="jq-sortable">
                            @foreach(unserialize($game->screenshots) as $img)
                                <li class="pic-preview">
                                    <img src="{{ $img }}" class="icon110x185" />
                                    <input type="button" value="删除" class="button red-button jq-picDelete" />
                                    <input type="hidden" name="screenshots[]" value="{{ $img }}" />
                                </li>
                            @endforeach
                        </ul>
                        <div class="pic-preview">
                            <div class="add-pic jq-picUpload" id="picUpload"><i class="icon-plus"></i></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="label">新版特性：</td>
                    <td>
                        <textarea class="jq-features none" name="features">{{ $game->features }}</textarea>
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="inline-button">
            <input type="button" value="存为草稿" class="button" />
            <input type="submit" value="&#12288;提交&#12288;" class="button" />
            <a href="edit.html" class="button">取消修改</a>
            <a href="stock.html" class="button">返回列表</a>
        </p>
    </form>
    <!-- /表单 -->
    <!-- 弹窗 -->
    <div class="addModal jq-dialog" title="游戏分类">
        <div class="sort-wrap">
            <span class="sort-title">游戏分类</span>
            <ul class="sort-list jq-initSort">
                <li><input type="checkbox" name="init-sort" value="1" class="jq-sortClick" />休闲游戏</li>
                <li><input type="checkbox" name="init-sort" value="2" class="jq-sortClick" />塔防游戏</li>
                <li><input type="checkbox" name="init-sort" value="3" class="jq-sortClick" />棋牌游戏</li>
                <li><input type="checkbox" name="init-sort" value="4" class="jq-sortClick" />角色扮演</li>
                <li><input type="checkbox" name="init-sort" value="5" class="jq-sortClick" />策略游戏</li>
                <li><input type="checkbox" name="init-sort" value="6" class="jq-sortClick" />体育竞技</li>
                <li><input type="checkbox" name="init-sort" value="7" class="jq-sortClick" />模拟经营</li>
                <li><input type="checkbox" name="init-sort" value="8" class="jq-sortClick" />音乐舞蹈</li>
            </ul>
        </div>
        <div class="tags-wrap">
            <span class="tags-title">标签内容</span>
            <ul>
                <li class="none" id="sort_1">
                    <span class="sub-tag-title">休闲游戏</span>
                    <ul class="sub-tag-list">
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="卡牌" />卡牌</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="剧情" />剧情</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="童话" />童话</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="养成" />养成</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="穿越" />穿越</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="街机" />街机</li>
                    </ul>
                </li>
                <li class="none" id="sort_2">
                    <span class="sub-tag-title">塔防游戏</span>
                    <ul class="sub-tag-list">
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="1" />1</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="2" />2</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="3" />3</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="4" />4</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="5" />5</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="6" />6</li>
                    </ul>
                </li>
                <li class="none" id="sort_3">
                    <span class="sub-tag-title">棋牌游戏</span>
                    <ul class="sub-tag-list">
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="冒险" />冒险</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="棋牌" />棋牌</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="宫廷" />宫廷</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="韩系" />韩系</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="梦幻" />梦幻</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="社交" />社交</li>
                    </ul>
                </li>
                <li class="none" id="sort_4">
                    <span class="sub-tag-title">角色扮演</span>
                    <ul class="sub-tag-list">
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="战争" />战争</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="塔防" />塔防</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="闯关" />闯关</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="武侠" />武侠</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="奇幻" />奇幻</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="水浒" />水浒</li>
                    </ul>
                </li>
                <li class="none" id="sort_5">
                    <span class="sub-tag-title">策略游戏</span>
                    <ul class="sub-tag-list">
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="7" />7</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="8" />8</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="9" />9</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="10" />10</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="11" />11</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="12" />12</li>
                    </ul>
                </li>
                <li class="none" id="sort_6">
                    <span class="sub-tag-title">体育竞技</span>
                    <ul class="sub-tag-list">
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="13" />13</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="14" />14</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="15" />15</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="16" />16</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="17" />17</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="18" />18</li>
                    </ul>
                </li>
                <li class="none" id="sort_7">
                    <span class="sub-tag-title">模拟经营</span>
                    <ul class="sub-tag-list">
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="19" />19</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="20" />20</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="21" />21</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="22" />22</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="23" />23</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="24" />24</li>
                    </ul>
                </li>
                <li class="none" id="sort_8">
                    <span class="sub-tag-title">音乐舞蹈</span>
                    <ul class="sub-tag-list">
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="25" />25</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="26" />26</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="27" />27</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="28" />28</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="29" />29</li>
                        <li><input type="checkbox" name="init-tag" class="jq-tagClick" value="30" />30</li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- /弹窗 -->
</div>
@stop

@section('footer')
<p class="copyright"><a class="link-gray">使用前必读</a>粤ICP证030173号</p>
@stop