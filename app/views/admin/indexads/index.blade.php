@extends('admin.layout')

@section('content')
<div class="Content_right_top Content_height">
    <div class="Theme_title">
        <h1>广告位管理 <span>首页图片位管理</span></h1>
        <a href="{{ URL::route('indexads.create') }}" target=BoardRight>添加游戏</a>
    </div>
    <form action="{{ URL::route('indexads.index') }}" method="get">
        <div class="Theme_Search">
            <ul>
                <li>
                     <span><b>查询：</b>
                        <select name="is_top">
                            <option value="">是否置顶</option>
                            @foreach($is_top as $k=>$v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                    </span>
                    <span>
                         <select name="status">
                            <option value="">状态</option>
                            @foreach($status as $k=>$v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                         </select>
                    </span>
                    <span>
                         <select name="location">
                           <option value="">所属类别</option>
                            @foreach($location as $k=>$v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                         </select>
                    </span>
                     
                    <span><input name="" type="text" class="Search_wenben" size="20" value="输入游戏名称" /></span>
                    <input name="" type="submit" value="搜索" class="Search_en" />
                </li>            
            </ul>
        </div>
    </form>
                    
    <div class="Search_cunt">共 <strong>{{ $ads->getTotal() }}</strong> 条信息 </div>
                     
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
                    <td width="7%">是否置顶</td>
                    <td width="15%">操作</td>
                </tr>
                @forelse($ads as $ad)                   
                <tr class="jq-tr">
                    <td>{{ $ad->id }}</td>
                    <td><img src="{{ $ad->image }}" width="28" height="28" /></td>
                    <td>{{ $ad->title }}</td>
                    <td>{{ isset($location[$ad->location]) ? $location[$ad->location] : '' }}</td>
                    <td>{{ $ad->sort }}</td>
                    <td>{{ $ad->onshelfed_at }}</td>
                    <td>{{ $ad->offshelfed_at }}</td>
                    <!--应该整理这块-->
                    @if ($ad->is_onshelf == 'yes')
                        @if (strtotime($ad->offshelfed_at) < time())
                            <td>已过期</td>
                        @elseif (strtotime($ad->onshelfed_at) > time())
                            <td>线上展示</td>
                        @else
                            <td>{{ Config::get('status.ads.is_onshelf')[$ad->is_onshelf] }}</td>
                        @endif
                    @else
                        <td>{{ Config::get('status.ads.is_onshelf')[$ad->is_onshelf] }}</td>
                    @endif
                    <td>{{ Config::get('status.ads.is_top')[$ad->is_top] }}</td>
                    <td>
                        @if($ad->is_onshelf == 'yes')
                            <a href="{{ URL::route('indexads.offshelf', $ad->id) }}" target=BoardRight class="Search_show">下架</a>
                        @endif
                        <a href="{{ URL::route('indexads.edit', $ad->id) }}" target=BoardRight class="Search_show">编辑</a>
                        <a href="{{ URL::route('indexads.delete', $ad->id) }}" class="Search_del">删除</a>
                    </td>
                </tr>
            @empty
                <tr class="jq-tr">
                    <td colspan="9">没数据</td>
                <tr>
            @endforelse
        </table>
        <div id="pager">{{ $ads->links() }}</div>
    </div>
</div>
<script>
$(function(){
    $(".jq-tr:odd").addClass("Search_biao_two");
    $(".jq-tr:even").addClass("Search_biao_one");
});
</script>
@stop