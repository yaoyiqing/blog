@include('mi.header')
<!-- start banner_x -->
		<div class="banner_x center">
			<a href="/index" target="_blank"><div class="logo fl"></div></a>
			<a href=""><div class="ad_top fl"></div></a>
			<div class="nav fl">
				<ul>
					@foreach($navs as $nav)
						<li><a href="{{$nav->nav_route}}" target="_blank">{{$nav->nav_name}}</a></li>
					@endforeach
					<li><a href="">服务</a></li>
					<li><a href="">社区</a></li>
				</ul>
			</div>
			<div class="search fr">
				<form action="" method="post">
					<div class="text fl">
						<input type="text" class="shuru"  placeholder="&nbsp;&nbsp;小米6&nbsp;&nbsp;&nbsp;小米MIX现货">
					</div>
					<div class="submit fl">
						<input type="submit" class="sousuo" value="搜索"/>
					</div>
				</form>
			</div>
		</div>
<!-- end banner_x -->

	<!-- start banner_y -->
		<div class="banner_y center">
			<div class="nav">				
				<ul>
					@foreach($cates as $key => $cate)
					<li>
						<a href="">{{$cate['cate_name']}}</a>
						<div class="pop">
							@foreach($cate['son'] as $sonCate)
								@if($sonCate['cate_id'] % 3 == 0)
								<div class="left fl" style="height:80px;">
									<div>
										<div class="xuangou_left fl">
											<a href="">
												<div class="img fl"><img src="{{URL::asset('/mi/image/xm6_80.png')}}" alt=""></div>
												<span class="fl">{{$sonCate['cate_name']}}</span>
												<div class="clear"></div>
											</a>
										</div>
										<div class="xuangou_right fr"><a href="detail.blade.php" target="_blank">选购</a></div>
										<div class="clear"></div>
									</div>
								</div>
								@endif
								@if($sonCate['cate_id'] % 3 == 1)
								<div class="ctn fl" style="height:80px;">
									<div>
										<div class="xuangou_left fl">
											<a href="">
												<div class="img fl"><img src="/mi/image/xm5-80.jpg" alt=""></div>
												<span class="fl">{{$sonCate['cate_name']}}</span>
												<div class="clear"></div>
											</a>
										</div>
										<div class="xuangou_right fr"><a href="">选购</a></div>
										<div class="clear"></div>
									</div>
								</div>
								@endif
								@if($sonCate['cate_id'] % 3 == 2)
								<div class="right fl" style="height:80px;">
									<div>
										<div class="xuangou_left fl">
											<a href="">
												<div class="img fl"><img src="/mi/image/mimobile.jpg" alt=""></div>
												<span class="fl">{{$sonCate['cate_name']}}</span>
												<div class="clear"></div>
											</a>
										</div>
										<div class="xuangou_right fr"><a href="">选购</a></div>
										<div class="clear"></div>
									</div>
								</div>
								@endif
							@endforeach
						</div>
						<div class="clear"></div>
					</li>
					@endforeach
				</ul>
			</div>
		
		</div>	

		<div class="sub_banner center">
			<div class="sidebar fl">
				<div class="fl"><a href=""><img src="{{URL::asset('/mi/image/hjh_01.gif')}}"></a></div>
				<div class="fl"><a href=""><img src="{{URL::asset('/mi/image/hjh_02.gif')}}"></a></div>
				<div class="fl"><a href=""><img src="{{URL::asset('/mi/image/hjh_03.gif')}}"></a></div>
				<div class="fl"><a href=""><img src="{{URL::asset('/mi/image/hjh_04.gif')}}"></a></div>
				<div class="fl"><a href=""><img src="{{URL::asset('/mi/image/hjh_05.gif')}}"></a></div>
				<div class="fl"><a href=""><img src="{{URL::asset('/mi/image/hjh_06.gif')}}"></a></div>
			</div>
			<div class="datu fl"><a href=""><img src="{{URL::asset('/mi/image/hongmi4x.png')}}" alt=""></a></div>
			<div class="datu fl"><a href=""><img src="{{URL::asset('/mi/image/xiaomi5.jpg')}}" alt=""></a></div>
			<div class="datu fr"><a href=""><img src="{{URL::asset('/mi/image/pinghengche.jpg')}}" alt=""></a></div>


		</div>
	<!-- end banner -->

	<!-- start danpin -->
		<div class="danpin center">
			
			<div class="biaoti center">小米明星单品</div>
			<div class="main center">
				@foreach($goods as $key => $value)
				<div class="mingxing fl">
					<div class="sub_mingxing"><a href="{{$value->goods_id}}"><img src="{{$value->goods_img}}" alt=""></a></div>
					<div class="pinpai"><a href="">{{$value->goods_name}}</a></div>
					<div class="youhui">5月9日-21日享花呗12期分期免息</div>
					<div class="jiage">￥{{$value->goods_price}}</div>
				</div>
					@endforeach
			</div>
		</div>
		<div class="peijian w">
			<div class="biaoti center">配件</div>
			<div class="main center">
				<div class="content">
					<div class="remen fl"><a href=""><img src="/mi/image/peijian1.jpg"></a></div>
					@foreach($parts as $value)
						<div class="remen fl">
							<div class="xinpin"><span>新品</span></div>
							<div class="tu"><a href="{{$value->goods_id}}"><img src="{{$value->goods_img}}"></a></div>
							<div class="miaoshu"><a href="{{$value->goods_id}}">{{$value->goods_name}}</a></div>
							<div class="jiage">￥{{$value->goods_price}}</div>
							<div class="pingjia">372人评价</div>
							<div class="piao">
								<a href="">
									<span>发货速度很快！很配小米6！</span>
									<span>来至于mi狼牙的评价</span>
								</a>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
@include('mi.footer')