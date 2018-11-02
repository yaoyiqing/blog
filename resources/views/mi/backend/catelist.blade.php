@extends('adminlte::page')

@section('title', '分类列表')

@section('content_header')
    <h1><b>分类列表</b></h1>
@stop

@section('content')
    <table  class="table table-bordered table-hover dataTable" style="background: #e3e5e7;">
        <tr>
            <th>ID</th>
            <th>分类名称</th>
            <th>分类图片</th>
            <th>上级分类</th>
            <th>分类路由</th>
            <th>层级关系</th>
            <th>操作</th>
        </tr>
        @foreach($cates as $cate)
            <tr>
                <td>{{$cate->cate_id}}</td>
                <td>{{str_repeat('|—',substr_count($cate->path,'-'))}}{{$cate->cate_name}}</td>
                <td><img src="{{URL::asset($cate->cate_img)}}" alt="" width="80px"></td>
                <td>{{$cate->parent_id}}</td>
                <td>{{$cate->cate_route}}</td>
                <td>{{$cate->path}}</td>
                <td>
                    <a href="/admin/updatecate/cate_id/{{$cate->cate_id}}" class="fa fa-fw fa-edit" title="修改分类"></a>
                    <a href="/admin/delcate/cate_id/{{$cate->cate_id}}" class="fa fa-fw fa-close" title="删除分类"></a>
                </td>
            </tr>
        @endforeach
    </table>
@stop

{{--@section('css')--}}
{{--<link rel="stylesheet" href="/css/admin_custom.css">--}}
{{--@stop--}}

@section('js')
    <script>
        // console.log('Hi!');
    </script>
@stop