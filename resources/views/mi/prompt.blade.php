<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{URL::asset('/mi/css/bootstrap.css')}}">
    <title>Document</title>
</head>
<body>
<div class="wrapper-page">
    <div class="panel panel-color {{ $data['status']?'panel-inverse':'panel-danger' }}">

        <div class="panel-heading">
            <h3 class="text-center m-t-10">{{ $data['message'] }}</h3>
        </div>

        <div class="panel-body">
            <div class="text-center">
                <div class="alert {{ $data['status']?'alert-info':'alert-danger' }} alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    浏览器页面将在<b id="loginTime">{{ $data['jumpTime'] }}</b>秒后跳转......
                </div>
                <div class="form-group m-b-0">
                    <div class="input-group">
                        {{--<input type="password" class="form-control" placeholder="Enter Email">--}}
                        <span class="input-group-btn"> <button type="submit" class="btn {{ $data['status']?'btn-success':'btn-danger' }}">点击立即跳转</button> </span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script src="/mi/js/jquery.min.js"></script>
<script type="text/javascript">
    $(function(){
        //循环倒计时，并跳转
        var url = "{{ $data['url'] }}";
        var loginTime = parseInt($('#loginTime').text());
        console.log(loginTime);
        var time = setInterval(function(){
            loginTime = loginTime-1;
            $('#loginTime').text(loginTime);
            if(loginTime==0){
                clearInterval(time);
                window.location.href=url;
            }
        },1000);
    })
    //点击跳转
    $('.btn-success').click(function () {
        var url = "{{ $data['url'] }}";
        window.location.href=url;
    })
</script>

</body>
</html>