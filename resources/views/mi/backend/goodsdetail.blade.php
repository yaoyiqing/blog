@extends('adminlte::page')

@section('title', '商品详情')

@section('content_header')
    <h1>{{$goods->goods_name}}</h1>
@stop

@section('content')
    <div class="box-body">
        <table  class="table table-bordered table-hover dataTable" style="background: #e3e5e7;">
            <tr>
                <th>商品货号</th>
                <td>{{$goods->goods_number}}</td>
            </tr>
            <tr>
                <th width="200px">商品图片</th>
                <td><img src="{{URL::asset($goods->goods_img)}}" alt="" width="100px"></td>
            </tr>
            <tr>
                <th>商品描述</th>
                <td>{{$goods->goods_desc}}</td>
            </tr>
            <tr>
                <th>商品价格</th>
                <td>{{$goods->goods_price}}</td>
            </tr>
            <tr>
                <th>商品库存</th>
                <td>{{$goods->goods_count}}</td>
            </tr>
            <tr>
                <th>所属分类</th>
                <td>{{$goods->cate_name}}</td>
            </tr>
            <tr>
                <th>修改时间</th>
                <td>{{date("Y-m-d H:i:s",$goods->update_time)}}</td>
            </tr>
            <tr>
                <th>添加时间</th>
                <td>{{date("Y-m-d H:i:s",$goods->add_time)}}</td>
            </tr>
            <tr>
                <th>是否上架</th>
                <td>{{$goods->is_sale==1 ? '上架' : '下架'}}</td>
            </tr>
        </table>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop