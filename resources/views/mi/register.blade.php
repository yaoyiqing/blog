<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta name="author" content="order by dede58.com"/>
		<title>用户注册</title>
		<script src="{{URL::asset('/mi/js/jquery.min.js')}}"></script>
		<link rel="stylesheet" type="text/css" href="{{URL::asset('/mi/css/login.css')}}">

	</head>
	<body>
		<form  method="post" action="{{url('/regist')}}" id="form">
			{{--<input type="hidden" name="_token" value="{{csrf_token()}}">--}}
			@csrf
{{--			{{csrf_field()}}--}}
		<div class="regist">
			<div class="regist_center">
				<div class="regist_top">
					<div class="left fl">会员注册</div>
					<div class="right fr"><a href="{{url('/index')}}" target="_self">小米商城</a></div>
					<div class="clear"></div>
					<div class="xian center"></div>
				</div>
				<div class="regist_main center">
					<div class="username">用&nbsp;&nbsp;户&nbsp;&nbsp;名:&nbsp;&nbsp;<input class="shurukuang" type="text" name="username" placeholder="请输入邮箱或者手机号" id="username" onblur="checkusername()" value="{{old('username')}}"/><span id="checkname">邮箱或者手机号用于登录</span></div>
					<div class="username">密&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;码:&nbsp;&nbsp;<input class="shurukuang" type="password" name="password" placeholder="请输入你的密码" id="password" onblur="checkpwd()"/><span id="checkpwd">请输入6位以上字符</span></div>
					
					<div class="username">确认密码:&nbsp;&nbsp;<input class="shurukuang" type="password" name="password_confirmation" placeholder="请确认你的密码" id="repassword" onblur="checkrepwd()"/><span id="checkrepwd">两次密码要输入一致哦</span></div>
					<div class="username">
						<div class="left fl">验&nbsp;&nbsp;证&nbsp;&nbsp;码:&nbsp;&nbsp;<input class="yanzhengma" type="text" name="verificode" placeholder="请输入验证码"/></div>

						@if($errors->has('captcha'))
							<div class="col-md-12">
								<p class="text-danger text-left"><strong>{{$errors->first('captcha')}}</strong></p>
							</div>
						@endif

						<div class="right fl"><img src="{{captcha_src()}}"  style="cursor: pointer" onclick="this.src='{{captcha_src()}}'+Math.random()"></div>
						<div class="clear"></div>
					</div>
				</div>
				<div class="regist_submit">
					<input class="submit" type="submit" value="立即注册" >
				</div>
				
			</div>
		</div>
		</form>
	</body>
</html>
<script>
	function checkusername()
	{
		var username = $("#username").val();
		var regemail = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
		var regmobile = /^1[345678][0-9]{9}$/;
		if(regemail.test(username)){
		    $("#checkname").text('邮箱注册');
		}else if(regmobile.test(username)){
		    $("#checkname").text('手机号注册');
		}else{
		    $("#checkname").text('用户名验证失败');
		}
		$.ajax({
		    type:'post',
			url:"{{url('/checkNameIsOnly')}}",
			dataType:'json',
			data:{'_token':'{{csrf_token()}}','username':username},
			success:function(msg){
			    if(msg){
                    $("#checkname").text('可以注册');
                    $("#form").submit();
					// return true;
				}else{
			        // alert('用户名已存在');
                    $("#checkname").text('用户名已存在');
                    return false;
				}
			}
		})
	}
</script>