@extends('admin.layout')

@section('content') 
<table align="center" border="0" cellspacing="0" cellpadding="0" class="add_Classification">
  <tr>
    <td width="114" align="right">所属分类：</td>
    <td height="40">
        <select id="u117_input" name="parent_id">
            @foreach($cates as $cate)
                <option value="{{ $cate->id }}">{{ $cate->title }}</option>
            @endforeach
         </select>
    </td>
  </tr>
  <tr>
    <td align="right" valign="top">标签名称：</td>
    <td height="40">
        <input name="tag" type="text"  class="add_Classification_text"/>
        <span>
            <a href="#"><img src="/css/images/jiahao.jpg" width="17" height="17" /></a>
        </span>
    </td>
  </tr>
  <tr>
    <td colspan="2" style=" text-align:center; padding:15px 0px;">
        <input name="" type="button" value="添加" class="Search_en jq-addTag" />
    </td>
  </tr>
</table>
<script type="text/javascript">
    $(function(){
        $('.jq-addTag').click(function(){
            var parent_id = $('select[name=parent_id]').val();
            var tag = $('input[name=tag]').val();
            if (tag == '' || tag == undefined){
                return;
            }
            var createUrl = "{{ route('tag.create') }}";

            $.post(createUrl, {parent_id:parent_id,word:tag}, function(res){
                if ( res.status == 'ok' ){
                    alert('添加成功');
                    return;
                }
                alert('添加失败');
            })
        });
    });    
    
</script>
@stop