@extends('admin.layout')

@section('content') 
<div class="Content_right_top Content_height">
    <div class="Theme_title"><h1>系统管理 <span> 游戏评分列表</span></h1></div>
             
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
                    
    <div class="Search_cunt">共 <strong>{{ $ratings->getTotal() }}</strong> 条记录 </div>
                     
    <div class="Search_biao">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="Search_biao_title">
                <td width="4%">ID</td>
                <td width="8%">游戏名称</td>
                <td width="12%">包名</td>
                <td width="8%">游戏总分</td>
                <td width="8%">评分次数</td>
                <td width="10%">游戏平均分</td>
                <td width="10%">干扰后分值</td>
                <td width="10%">操作</td>
            </tr>
            @foreach($ratings as $rating)
                <tr class="Search_biao_one">
                    <td>{{ $rating->id }}</td>
                    <td>{{ $rating->title }}</td>
                    <td>{{ $rating->pack }}</td>
                    <td>{{ $rating->total }}</td>
                    <td>{{ $rating->counts }}</td>
                    <td>{{ $rating->avg }}</td>
                    <td>{{ $rating->manual }}</td>
                    <td><a href="#" class="Search_show">修改</a></td>
                </tr>
            @endforeach                
            <tr class="Search_biao_one">
                <td>1</td>
                <td>植物大战僵尸</td>
                <td>com.ltyx.anxy</td>
                <td>45</td>
                <td>10</td>
                <td>4.5</td>
                <td>5</td>
                <td><a href="#" class="Search_show">修改</a></td>
            </tr>
            <tr class="Search_biao_two">
                <td>2</td>
                <td>植物大战僵尸</td>
                <td>com.ltyx.anxy</td>
                <td>24</td>
                <td>15</td>
                <td>4</td>
                <td><input name="textfield" type="text" id="textfield" value="2" size="8" class="Classification_text" /></td>
            <td><a href="#" class="Search_show">确定</a> <a href="#" class="Search_show">取消</a></td>
            </tr>
            <tr class="Search_biao_one">
                <td>1</td>
                <td>植物大战僵尸</td>
                <td>com.ltyx.anxy</td>
                <td>45</td>
                <td>10</td>
                <td>4.5</td>
                <td>5</td>
                <td><a href="#" class="Search_show">修改</a></td>
            </tr>
            <tr class="Search_biao_two">
                <td>2</td>
                <td>植物大战僵尸</td>
                <td>com.ltyx.anxy</td>
                <td>24</td>
                <td>15</td>
                <td>4</td>
                <td>5</td>
            <td><a href="#" class="Search_show">修改</a></td>
            </tr>
            <tr class="Search_biao_one">
                <td>1</td>
                <td>植物大战僵尸</td>
                <td>com.ltyx.anxy</td>
                <td>45</td>
                <td>10</td>
                <td>4.5</td>
                <td>5</td>
                <td><a href="#" class="Search_show">修改</a></td>
            </tr>
            <tr class="Search_biao_two">
                <td>2</td>
                <td>植物大战僵尸</td>
                <td>com.ltyx.anxy</td>
                <td>24</td>
                <td>15</td>
                <td>4</td>
                <td>5</td>
            <td><a href="#" class="Search_show">修改</a></td>
            </tr>                     
        </table>
        <div id="pager">{{ $ratings->links() }}</div>
    </div>                               
</div>
@stop