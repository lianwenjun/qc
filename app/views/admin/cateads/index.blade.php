@extends('admin.layout')

@section('content') 
<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>广告位管理 <span>分类页图片位推广</span></h1></div>                
    <div class="Search_cunt" style="padding-top:15px;">共 <strong>{{ $cateads->getTotal() }}</strong> 条信息 </div>
                     
    <div class="Search_biao">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="Search_biao_title">
                <td width="10%">ID</td>
                <td width="25%">图片</td>
                <td width="25%">分类名称</td>
                <td width="20%">操作</td>
            </tr>
            @foreach($cateads as $catead)
                <tr class="jq-tr">
                    <td>{{ $catead->id }}</td>
                    <td>{{ $catead->image ? $catead->image : '<img src="/images/admin/u1188.png" width="28" height="28" />' }} </td>
                    <td>{{ $catead->title }}</td>
                    <td><a href="javascript:;" target=BoardRight class="Search_show jq-cateads-upload">重新上传图片</a></td>
                </tr>
            @endforeach
        </table>
        <div id="pager">{{ $cateads->links() }}</div>
    </div>               
</div>
<script>
$(function(){
    $(".jq-tr:odd").addClass("Search_biao_two");
    $(".jq-tr:even").addClass("Search_biao_one");
});
</script>
@stop