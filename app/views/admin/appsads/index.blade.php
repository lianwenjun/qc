@extends('admin.layout')

@section('content') 
<div class="Content_right_top Content_height">
    <div class="Theme_title">
        <h1>广告位管理 <span>首页游戏位管理</span></h1>
        @if(Sentry::getUser()->hasAccess('appsads.create'))
        <a href="{{ URL::route('appsads.create') }}" target=BoardRight>添加游戏</a>
        @endif
    </div>
    <form action="{{ URL::route('appsads.index') }}" method="get">
        <div class="Theme_Search">
            <ul>
                <li>
                    <span><b>查询：</b>
                        {{ Form::select('status', $status, Input::get('status')); }}
                    </span>
                    <span>
                        {{ Form::select('location', $location, Input::get('location')); }}
                    </span>
                    <span><input maxlength="16" name="word" type="text" class="Search_wenben" size="20" placeholder="输入游戏名称" /></span>
                    <input type="submit" value="搜索" class="Search_en" />
                </li>
            </ul>
        </div>
    </form>
                    
    <div class="Search_cunt">共 <strong>{{ $ads->getTotal() }}</strong> 条信息 </div>
    @if (Session::get('msg'))
        <div class="Search_cunt">{{ Session::get('msg')}}</div>
    @endif            
    <div class="Search_biao">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="Search_biao_title">
                <td width="5%">游戏ID</td>
                <td width="4%">图片</td>
                <td width="9%">游戏名称</td>
                <td width="6%">所属类别</td>
                <td width="7%">排列序号</td>
                <td width="13%">上架时间</td>
                <td width="13%">下线时间</td>
                <td width="7%">状态</td>
                <td width="15%">操作</td>
            </tr>
            @forelse($ads as $ad)
                <tr class="jq-tr">
                    <td>{{ $ad->app_id }}</td>
                    <td><img src="{{ $ad->image }}" width="28" height="28" /></td>
                    <td>{{ $ad->title }}</td>
                    <td>{{ isset($location[$ad->location]) ? $location[$ad->location] : '' }}</td>
                    <td>{{ $ad->sort }}</td>
                    <td {{ Config::get('status.ads.timeColor')[CUtil::adsStatus($ad)] }}>{{ $ad->stocked_at }}</td>
                    <td {{ Config::get('status.ads.timeColor')[CUtil::adsStatus($ad)] }}>{{ $ad->unstocked_at }}</td>
                    <td {{ Config::get('status.ads.statusColor')[CUtil::adsStatus($ad)] }}>{{ Config::get('status.ads.status')[CUtil::adsStatus($ad)] }}</td>
                    
                    <td>
                        @if($ad->is_stock == 'yes' && Sentry::getUser()->hasAccess('appsads.unstock'))
                            <a href="{{ URL::route('appsads.unstock', $ad->id) }}" target=BoardRight class="Search_show">下架</a>
                        @endif
                        @if(Sentry::getUser()->hasAccess('appsads.edit'))
                        <a href="{{ URL::route('appsads.edit', $ad->id) }}" target=BoardRight class="Search_show">编辑</a>
                        @endif
                        @if(Sentry::getUser()->hasAccess('appsads.delete'))
                        <a href="{{ URL::route('appsads.delete', $ad->id) }}" class="Search_del jq-delete">删除</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr class="no-data">
                    <td colspan="9">没数据</td>
                <tr>
            @endforelse
        </table>
        @if($ads->getLastPage() > 1)
            <div id="pager"></div>
        @endif
    </div>            
</div>
<script type="text/javascript" src="{{ asset('js/jquery.pager.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/admin/common.js') }}"></script>
<script>
$(function(){
    $(".jq-tr:odd").addClass("Search_biao_two");
    $(".jq-tr:even").addClass("Search_biao_one");
    $("input[name=word]").focus(function() {
        $(this).val("");
    });
    //分页
    pageInit({{ $ads->getCurrentPage() }}, {{ $ads->getLastPage() }}, {{ $ads->getTotal() }});
});
</script>
@stop