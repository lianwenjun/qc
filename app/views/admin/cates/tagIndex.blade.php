@extends('admin.layout')

@section('content')       
<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>系统管理 <span> 游戏标签管理</span></h1></div>
    <div class="Theme_Search">
        <ul>
            <li>
                <span><b>标签名称：</b>
                    <input id="addTag" name="" type="text" class="Search_wenben" size="20" value="请输入标签名称" /></span>
                <span>
                    <b>游戏分类：</b>
                    <select name="">
                        <option>--全部--</option>
                        @foreach ($cates as $index => $value )
                            <option>{{ $value }}</option>
                        @endforeach
                    </select>
                </span>
                <input name="" type="submit" value="添加" class="Search_en" />
            </li>
            <li>
                <span>
                    <b>查询：</b>
                    <select name="">
                        <option>--全部--</option>
                        @foreach ($cates as $index => $value)
                            <option>{{ $value }}</option>
                        @endforeach
                    </select>
                </span>
                <span>
                    <input id="searchTag" name="" type="text" class="Search_wenben" size="20" value="输入关键字" />
                </span>
                <input name="" type="submit" value="搜索" class="Search_en" />
            </li>       
        </ul>
    </div>
    <div class="Search_cunt">共 <strong>{{ $total }}</strong> 条记录 </div>     
    <div class="Search_biao">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="Search_biao_title">
                <td width="5%">ID</td>
                <td width="15%">标签名称</td>
                <td width="10%">所属游戏分类</td>
                <td width="10%">搜索量</td>
                <td width="10%">排序</td>
                <td width="15%">最后更新时间</td>
                <td width="10%">操作</td>
            </tr>
            @foreach($tags as $tag)
                <tr class="Search_biao_one">
                    <td>{{ $tag->id }}</td>
                    <td>{{ $tag->title }}</td>
                    <td>{{ isset($cates[$tag->parent_id]) ? $cates[$tag->parent_id]: 0}}</td>
                    <td>{{ $tag->search_total }}</td>
                    <td>{{ $tag->sort }}</td>
                    <td>{{ $tag->updated_at }}</td>
                    <td><a href="javascript:;" class="Search_show">编辑</a> <a href="javascript:;" class="Search_del">删除</a></td>
                    <td style="display:none">
                        <input id="edit-url" value="{{ route('tag.update', $tag->id) }}" type="hidden"/>
                        <input id="del-url" value="{{ route('tag.delete', $tag->id) }}" type="hidden"/>
                        <input id="preWord" value="{{ $tag->word }}" type="hidden"/>
                        <input id="proSort" value="{{ $tag->sort }}" type="hidden"/>
                    </td>
                </tr>
            @endforeach
            <tr class="Search_biao_two">
                <td>2</td>
                <td><input name="textfield" type="text" id="textfield" value="植物大战僵尸" size="30" class="Classification_text" /></td>
                <td>装机必备</td>
                <td>24242</td>
                <td><input name="textfield" type="text" id="textfield" value="2" size="8" class="Classification_text" /></td>
                <td>2014-6-23</td>
                <td><a href="#" class="Search_show">确定</a> <a href="#" class="Search_show">取消</a></td>
            </tr>                
            </table>
        <div id="pager">{{ $tags->links() }}</div>
    </div>   
</div>
<script>
$(function(){
    $("#addTag").focus(function() {
        $(this).val("");
    });
    $("#searchTag").focus(function() {
        $(this).val("");
    });
});
</script>
@stop