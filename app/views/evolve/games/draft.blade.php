@extends('evolve.layout')

@section('custom')
<title>游戏管理——添加编辑游戏</title>
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/common.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugins/jquery-ui/jquery-ui.min.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugins/plupload/jquery.plupload.queue.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugins/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/fonts.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/plugin.css') }}">
<script type="text/javascript" src="{{ asset('/evolve/js/admin/jquery-1.9.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery-ui/datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/jquery-ui/datepicker.zh-CN.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/plupload/plupload.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/plupload/jquery.plupload.queue.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/plupload/i18n/zh_CN.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/plugins/select2/i18n/zh-CN.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/common.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/pages/autoComplete.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/pages/apps/draft.js') }}"></script>
@stop

@section('breadcrumb')
<div class="breadcrumb"><a href="javascript:;">游戏管理</a><span>&gt;</span>添加编辑游戏</div>
@stop

@section('content')
<div class="content">
    <!-- 查询-->
    <form action="#" method="post" class="validate jq-search">
        <div class="search">
            <p>查询:
                <select class="select" name="gametype">
                    <option value="">全部</option>
                    <option value="">角色扮演</option>
                    <option value="">休闲益智</option>
                    <option value="">射击游戏</option>
                    <option value="">冒险游戏</option>
                    <option value="">动作游戏</option>
                    <option value="">策略游戏</option>
                    <option value="">实时策略</option>
                    <option value="">格斗游戏</option>
                    <option value="">竞速游戏</option>
                    <option value="">体育游戏</option>
                    <option value="">单机游戏</option>
                    <option value="">棋牌游戏</option>
                </select>
                <input class="input w250 jq-searchGameName" type="text" name="searchGameName" />
                <input class="jq-searchGameId" type="hidden" name="gameId" value="" />
            </p>
            <div class="jq-date date">日期:
                <input class="input" type="text" name="date" placeholder="2014.10.10——2014.11.11" /><div class="date-table"></div>
            </div>
            <input type="button" class="button" value="查询" />
        </div>      
    </form>
    <!-- /查询 -->
    <!-- 表格 -->
    <p class="record-title">添加编辑游戏：共<b class="red">{{ $games->getTotal() }}</b>条记录<a href="javascript:;" class="button fr jq-uploadApk">上传游戏</a></p>
    <table cellpadding="0" cellspacing="0" class="zebra-table tc">
        <thead>
            <tr>
                <th>ID</th>
                <th>图标</th>
                <th>名称<i class="icon-download ml5"></i></th>
                <th>包名</th>
                <th>分类</th>
                <th>大小</th>
                <th>版本号</th>
                <th>上传时间</th>
                <th>上传人</th>
                <th>最后编辑人</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse($games as $game)
                <tr>
                    <td>12345</td>
                    <td><img src="../images/pages/icon2.jpg" alt="图标1" class="icon25" /></td>
                    <td><a href="javascript:;" class="link-blue elimit6em jq-download" title="会说话的汤姆猫" data-url="">会说话的汤姆猫</a></td>
                    <td><span class="elimit12em cursor" title="1234567890adcvbnmawertgyu0000000">1234567890adcvbnmawertgyu0000000</span></td>
                    <td><span class="elimit6em cursor" title="策略游戏,休闲游戏">策略游戏,休闲游戏</span></td>
                    <td>180.5M</td>
                    <td>4.4.3</td>
                    <td><span class="elimit7em cursor" title="2014-09-03 19:09">2014-09-03 19:09</span></td>
                    <td>吸毒欧阳顺</td>
                    <td>吸毒欧阳顺</td>
                    <td>
                        <a href="edit.html" class="button">编辑</a>
                        <a href="javascript:;" class="button red-button jq-delete" data-url="">删除</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="13">没找到数据</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <!-- /表格 -->
    <!-- 上下翻页 -->
    {{ $games->appends(Input::all())->links('evolve.page') }}
    <!-- /上下翻页 -->
</div>
<!-- 上传游戏弹窗 -->
<div class="jq-uploadModal" title="上传游戏">
</div>
<!-- /上传游戏弹窗 -->
@stop

@section('footer')
<p class="copyright"><a class="link-gray">使用前必读</a>粤ICP证030173号</p>
@stop