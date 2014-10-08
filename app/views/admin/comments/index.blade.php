@extends('admin.layout')

@section('content')
<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>系统管理 <span> 游戏评论列表</span></h1></div>
             
    <div class="Theme_Search">
        <ul>
            <li>
                 <span><b>查询：</b>
                 <select name="">
                   <option>--全部--</option>
                   <option>1</option>
                 </select>
                 </span>
                 <span>
                 <input name="" type="text" class="Search_wenben" size="20" value="输入关键字" />
                 </span>
                 <input name="" type="submit" value="搜索" class="Search_en" />
            </li>
        </ul>
    </div>
                    
    <div class="Search_cunt">共 <strong>{{ $comments->getTotal() }}</strong> 条记录 </div>
                     
    <div class="Search_biao">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="Search_biao_title">
                <td width="4%">ID</td>
                <td width="7%">游戏名称</td>
                <td width="10%">包名</td>
                <td width="13%">iMEI辨识码</td>
                <td width="7%">用户机型</td>
                <td width="7%">用户IP</td>
                <td width="15%">评论内容</td>
                <td width="8%">评论时间</td>
                <td width="5%">评分</td>
                <td width="10%">操作</td>
            </tr>
            @foreach($comments as $comment)
                <tr class="Search_biao_one">
                    <td>{{ $comment->id }}</td>
                    <td>{{ $comment->title }}</td>
                    <td>{{ $comment->pack }}</td>
                    <td>{{ $comment->imei }}</td>
                    <td>{{ $comment->type }}</td>
                    <td>{{ $comment->ip }}</td>
                    <td>{{ $comment->content }}</td>
                    <td>{{ $comment->created_at }}</td>
                    <td>{{ $comment->rating }}</td>
                    <td><a href="#" class="Search_show">修改</a> <a href="#" class="Search_del">删除</a></td>
                </tr>
            @endforeach
            <tr class="Search_biao_one">
                <td>1</td>
                <td>植物大战僵尸</td>
                <td>com.ltyx.anxy</td>
                <td>123456789123456789</td>
                <td>HTC HD2</td>
                <td>192.168.1.3</td>
                <td>这个游戏太难玩了，难度好高</td>
                <td>2014-6-23 15:12:29</td>
                <td>5</td>
                <td><a href="#" class="Search_show">修改</a> <a href="#" class="Search_del">删除</a></td>
            </tr>
            <tr class="Search_biao_two">
                <td>2</td>
                <td>植物大战僵尸</td>
                <td>com.ltyx.anxy</td>
                <td>123456789123456789</td>
                <td>魅族MX3</td>
                <td>192.168.1.3</td>
                <td><input name="textfield" type="text" id="textfield" value="这个游戏太难玩了，难度好高" size="8" class="Classification_text" /></td>
                <td>2014-6-23 15:12:29</td>
                <td>5</td>
            <td><a href="#" class="Search_show">确定</a> <a href="#" class="Search_show">取消</a></td>
            </tr>
          
            <tr class="Search_biao_one">
                <td>1</td>
                <td>植物大战僵尸</td>
                <td>com.ltyx.anxy</td>
                <td>123456789123456789</td>
                <td>HTC HD2</td>
                <td>192.168.1.3</td>
                <td>这个游戏太难玩了，难度好高</td>
                <td>2014-6-23 15:12:29</td>
                <td>5</td>
                <td><a href="#" class="Search_show">修改</a> <a href="#" class="Search_del">删除</a></td>
            </tr>
          
            <tr class="Search_biao_two">
                <td>1</td>
                <td>植物大战僵尸</td>
                <td>com.ltyx.anxy</td>
                <td>123456789123456789</td>
                <td>HTC HD2</td>
                <td>192.168.1.3</td>
                <td>这个游戏太难玩了，难度好高</td>
                <td>2014-6-23 15:12:29</td>
                <td>5</td>
                <td><a href="#" class="Search_show">修改</a> <a href="#" class="Search_del">删除</a></td>
          </tr>
          
          <tr class="Search_biao_one">
                <td>1</td>
                <td>植物大战僵尸</td>
                <td>com.ltyx.anxy</td>
                <td>123456789123456789</td>
                <td>HTC HD2</td>
                <td>192.168.1.3</td>
                <td>这个游戏太难玩了，难度好高</td>
                <td>2014-6-23 15:12:29</td>
                <td>5</td>
                <td><a href="#" class="Search_show">修改</a> <a href="#" class="Search_del">删除</a></td>
          </tr>
          
          <tr class="Search_biao_two">
                <td>1</td>
                <td>植物大战僵尸</td>
                <td>com.ltyx.anxy</td>
                <td>123456789123456789</td>
                <td>HTC HD2</td>
                <td>192.168.1.3</td>
                <td>这个游戏太难玩了，难度好高</td>
                <td>2014-6-23 15:12:29</td>
                <td>5</td>
                <td><a href="#" class="Search_show">修改</a> <a href="#" class="Search_del">删除</a></td>
          </tr>
          
          <tr class="Search_biao_one">
                <td>1</td>
                <td>植物大战僵尸</td>
                <td>com.ltyx.anxy</td>
                <td>123456789123456789</td>
                <td>HTC HD2</td>
                <td>192.168.1.3</td>
                <td>这个游戏太难玩了，难度好高</td>
                <td>2014-6-23 15:12:29</td>
                <td>5</td>
                <td><a href="#" class="Search_show">修改</a> <a href="#" class="Search_del">删除</a></td>
          </tr>
          
          <tr class="Search_biao_two">
                <td>1</td>
                <td>植物大战僵尸</td>
                <td>com.ltyx.anxy</td>
                <td>123456789123456789</td>
                <td>HTC HD2</td>
                <td>192.168.1.3</td>
                <td>这个游戏太难玩了，难度好高</td>
                <td>2014-6-23 15:12:29</td>
                <td>5</td>
                <td><a href="#" class="Search_show">修改</a> <a href="#" class="Search_del">删除</a></td>
          </tr>
        
        
        </table>
        <div id="pager">{{ $comments->links() }}</div>
    </div>            
</div>
@stop