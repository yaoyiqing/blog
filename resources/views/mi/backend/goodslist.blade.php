@extends('adminlte::page')

@section('title', '商品列表')

@section('content_header')
    <h1><b>商品列表</b></h1>
@stop

@section('content')
    <table  class="table table-bordered table-hover dataTable" style="background: #e3e5e7;">
        <tr>
            <th>ID</th>
            <th>商品名称</th>
            <th>商品图片</th>
            <th>商品价格</th>
            <th>所属分类</th>
            <th>上、下架</th>
            <th>操作</th>
        </tr>
        @foreach($goods as $val)
            <tr>
                <td>{{$val->goods_id}}</td>
                <td>{{$val->goods_name}}</td>
                <td><img src="{{URL::asset($val->goods_img)}}" alt="" width="80px"></td>
                <td>￥{{$val->goods_price}}</td>
                <td>{{$val->cate_name}}</td>
                <td>{{$val->is_sale == 1 ? '上架' : '下架'}}</td>
                <td>
                    <a href="/admin/goodsdetail/goods_id/{{$val->goods_id}}" class="fa fa-fw fa-file-text-o" title="查看详情"></a>
                    <a href="/admin/updategoods/goods_id/{{$val->goods_id}}" class="fa fa-fw fa-edit" title="修改商品"></a>
                    @if($val->is_sale == 1)
                        <a href="javascript:void(0);" class="fa fa-fw fa-toggle-on onsale" title="下架" id="{{$val->goods_id}}"></a>
                    @elseif($val->is_sale == 0)
                        <a href="javascript:void(0);" class="fa fa-fw fa-toggle-off onsale" title="上架" id="{{$val->goods_id}}"></a>
                    @endif
                    <a href="/admin/delgoods/goods_id/{{$val->goods_id}}" class="fa fa-fw fa-close" title="删除商品"></a>
                </td>
            </tr>
        @endforeach
    </table>
    <center>{{$goods->render()}}</center>
@stop

{{--@section('css')--}}
{{--<link rel="stylesheet" href="/css/admin_custom.css">--}}
{{--@stop--}}

@section('js')
    <script>
        // console.log('Hi!');
        $(".onsale").click(function(){
            var goodsid = $(this).attr('id');
            $.ajax({
                'type':'post',
                'url':"onsale",
                'data':{goods_id:goodsid,'_token':'{{csrf_token()}}'},
                success:function (msg) {
                    if(msg){
                        // $("body").html(msg);
                        history.go(0);
                    }
                }
            });
        });
    </script>
@stop