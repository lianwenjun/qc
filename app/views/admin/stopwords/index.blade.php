@extends('admin.layout')

@section('content') 
<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>系统管理 <span> 屏蔽词管理</span></h1></div>
             
    <div class="Theme_Search">
        <ul>
            <li>
                 <span><b>屏蔽添加：</b>
                 <input name="" type="text" class="Search_wenben" size="60" value="添加屏蔽词" />
                 </span>
                 <input name="" type="submit" value="添加" class="Search_en" />
            </li>
               
        </ul>
    </div>
                    
    <div class="Search_cunt">共 <strong>{{ $stopwords->getTotal() }}</strong> 条记录 </div>
                     
    <div class="Search_biao">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="Search_biao_title">
                <td width="4%">ID</td>
                <td width="20%">屏蔽词</td>
                <td width="20%">替换成</td>
                <td width="8%">添加人</td>
                <td width="12%">添加时间</td>
                <td width="9%">最后编辑人</td>
                <td width="12%">最后更新时间</td>
                <td width="12%">操作</td>
            </tr>
                                
            <tr class="Search_biao_one">
                <td>1</td>
                <td>植物大战僵尸</td>
                <td>com.ltyx.anxy</td>
                <td>唐吉坷德</td>
                <td>2014-6-23 15:12:29</td>
                <td>唐吉坷德</td>
                <td>2014-6-23 15:12:29</td>
                <td><a href="#" class="Search_show">修改</a> <a href="#" class="Search_del">删除</a></td>
            </tr>
            <tr class="Search_biao_two">
                <td>2</td>
                <td><input name="textfield" type="text" id="textfield" value="这个游戏太难玩了，难度好高" size="8" class="Classification_text" /></td>
                <td><input name="textfield2" type="text" id="textfield2" value="这个游戏太难玩了，难度好高" size="8" class="Classification_text" /></td>
                 <td>唐吉坷德</td>
                <td>2014-6-23 15:12:29</td>
                <td>唐吉坷德</td>
                <td>2014-6-23 15:12:29</td>
            <td><a href="#" class="Search_show">确定</a> <a href="#" class="Search_show">取消</a></td>
            </tr>

            <tr class="Search_biao_one">
                <td>1</td>
                <td>植物大战僵尸</td>
                <td>com.ltyx.anxy</td>
                 <td>唐吉坷德</td>
                <td>2014-6-23 15:12:29</td>
                <td>唐吉坷德</td>
                <td>2014-6-23 15:12:29</td>
                <td><a href="#" class="Search_show">修改</a> <a href="#" class="Search_del">删除</a></td>
            </tr>

            <tr class="Search_biao_two">
                <td>1</td>
                <td>植物大战僵尸</td>
                <td>com.ltyx.anxy</td>
                 <td>唐吉坷德</td>
                <td>2014-6-23 15:12:29</td>
                <td>唐吉坷德</td>
                <td>2014-6-23 15:12:29</td>
                <td><a href="#" class="Search_show">修改</a> <a href="#" class="Search_del">删除</a></td>
            </tr>

            <tr class="Search_biao_one">
                <td>1</td>
                <td>植物大战僵尸</td>
                <td>com.ltyx.anxy</td>
                 <td>唐吉坷德</td>
                <td>2014-6-23 15:12:29</td>
                <td>唐吉坷德</td>
                <td>2014-6-23 15:12:29</td>
                <td><a href="#" class="Search_show">修改</a> <a href="#" class="Search_del">删除</a></td>
            </tr>

            <tr class="Search_biao_two">
                <td>1</td>
                <td>植物大战僵尸</td>
                <td>com.ltyx.anxy</td>
                 <td>唐吉坷德</td>
                <td>2014-6-23 15:12:29</td>
                <td>唐吉坷德</td>
                <td>2014-6-23 15:12:29</td>
                <td><a href="#" class="Search_show">修改</a> <a href="#" class="Search_del">删除</a></td>
            </tr>

            <tr class="Search_biao_one">
                <td>1</td>
                <td>植物大战僵尸</td>
                <td>com.ltyx.anxy</td>
                 <td>唐吉坷德</td>
                <td>2014-6-23 15:12:29</td>
                <td>唐吉坷德</td>
                <td>2014-6-23 15:12:29</td>
                <td><a href="#" class="Search_show">修改</a> <a href="#" class="Search_del">删除</a></td>
            </tr>

            <tr class="Search_biao_two">
                <td>1</td>
                <td>植物大战僵尸</td>
                <td>com.ltyx.anxy</td>
                 <td>唐吉坷德</td>
                <td>2014-6-23 15:12:29</td>
                <td>唐吉坷德</td>
                <td>2014-6-23 15:12:29</td>
                <td><a href="#" class="Search_show">修改</a> <a href="#" class="Search_del">删除</a></td>
            </tr>
                                
                                
        </table>
        <div id="pager">{{ $stopwords->links() }}</div>
    </div>                   
</div>
@stop