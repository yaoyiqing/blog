<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="author" content="order by dede58.com"/>
    <title>小米商城-个人中心</title>
    <link rel="stylesheet" type="text/css" href="{{URL::asset('/mi/css/style.css')}}">
</head>
<body>
<!-- start header -->
<header>
    <div class="top center">
        <div class="left fl">
            <ul>
                <li><a href="http://www.mi.com/" target="_blank">小米商城</a></li>
                <li>|</li>
                <li><a href="">MIUI</a></li>
                <li>|</li>
                <li><a href="">米聊</a></li>
                <li>|</li>
                <li><a href="">游戏</a></li>
                <li>|</li>
                <li><a href="">多看阅读</a></li>
                <li>|</li>
                <li><a href="">云服务</a></li>
                <li>|</li>
                <li><a href="">金融</a></li>
                <li>|</li>
                <li><a href="">小米商城移动版</a></li>
                <li>|</li>
                <li><a href="">问题反馈</a></li>
                <li>|</li>
                <li><a href="">Select Region</a></li>
                <div class="clear"></div>
            </ul>
        </div>
        <div class="right fr">
            <div class="gouwuche fr"><a href="{{url('/cart')}}">购物车</a></div>
            <div class="fr">
                <ul>
                    @if(session()->has('user'))
                        <li><a href="{{url('/self')}}" target="_blank">{{session()->get('user.username')}}</a></li>
                        <li>|</li>
                        <li><a href="{{url('/logout')}}">退出</a></li>
                        <li>|</li>
                        <li><a href="">消息通知</a></li>
                        <li>|</li>
                        <li><a href="{{url('/order')}}">我的订单</a></li>
                    @else
                        <li><a href="{{url('/login')}}" target="_blank">登录</a></li>
                        <li>|</li>
                        <li><a href="{{url('/register')}}" target="_blank" >注册</a></li>
                        <li>|</li>
                        <li><a href="">消息通知</a></li>
                    @endif
                </ul>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
</header>
<!--end header -->