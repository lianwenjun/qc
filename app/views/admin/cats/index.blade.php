总条数：{{ $cats->getTotal()}}
<BR>
@forelse($cats as $cat)
<tr>
    <td>{{ $cat->id }}</td>
    <td>{{ $cat->position }}</td>
    <td><span class="elimit6em cursor" title="{{ $cat->title }}">{{ $cat->title }}</span></td>
    <td>{{ $cat->sort }}</td>
    <td><span class="elimit12em cursor" title="{{ $cat->tags }}">{{ $cat->tags }}</span></td>
    <td>{{ $cat->operator }}</td>
    <td>
        <a href="add-sort.html" class="button">编辑</a>
        <a href="javascript:;" class="button red-button jq-delete" data-url="">删除</a>
    </td>
</tr>
<br>    
@empty
<tr class="no-data">
    <td colspan="6">亲！还没有数据哦！</td>
<tr>
@endforelse


