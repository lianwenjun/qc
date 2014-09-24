@extends('admin.layout')

@section('content') 
<table align="center" border="0" cellspacing="0" cellpadding="0" class="add_Classification">
  <tr>
    <td width="114" align="right">分类名称：</td>
    <td height="40"><input name="cate" type="text" class="add_Classification_text"/></td>
  </tr>
  <tr>
    <td align="right" valign="top">所属标签：</td>
    <td height="40">
    <input name="" type="text"  class="add_Classification_text"/>
    <span><a href="#"><img src="/css/images/jiahao.jpg" width="17" height="17" /></a></span>
    </td>
  </tr>
  <tr>
    <td colspan="2" style=" text-align:center; padding:15px 0px;"><input name="" type="button" value="添加" class="Search_en jq-addCate" /></td>
  </tr>
</table>
<script type="text/javascript">
    $(function(){
        $('.jq-addCate').click(function(){
            alert('添加分类');
            var cate = $('input[name=cate]').val();
            var createUrl = "{{ route('cate.create') }}";
            $.post(createUrl, {word:cate}, function(res){
                if ( res.status == 'ok' ){
                    return;
                }
            });
        });
    });    
    
</script>
@stop
