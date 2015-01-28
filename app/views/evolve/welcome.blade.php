@extends('evolve.layout')

@section('custom')
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/common.css') }}">
<link rel="stylesheet" href="{{ asset('/evolve/styles/admin/pages/other.css') }}">
<script type="text/javascript" src="{{ asset('/evolve/js/admin/jquery-1.9.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/evolve/js/admin/common.js') }}"></script>
@stop

@section('content')
<div class="welcome">
   <p><img src="{{ asset('/images/admin/logo.jpg') }}" alt="logo"></p> 
   <p class="user">管理员:<span class="red">{{ Sentry::getUser()->username }}</span></p>
   <p class="title">欢迎使用游戏商店后台系统</p>
</div>
@stop
