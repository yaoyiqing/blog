@extends('adminlte::page')

@section('title', '属性列表')

@section('content_header')
    <h1><b>属性列表</b></h1>
@stop

@section('content')
    <table  class="table table-bordered table-hover dataTable" style="background: #e3e5e7;">
        <tr>
            <th>ID</th>
            <th>属性名称</th>
            <th>操作</th>
        </tr>
        @foreach($attrs as $attr)
            <tr>
                <td>{{$attr->attr_id}}</td>
                <td>{{$attr->attr_name}}</td>
                <td>
                    <a href="/admin/updateattr/attr_id/{{$attr->attr_id}}" class="fa fa-fw fa-edit" title="修改属性"></a>
                    <a href="/admin/delattr/attr_id/{{$attr->attr_id}}" class="fa fa-fw fa-close" title="删除属性"></a>
                </td>
            </tr>
        @endforeach
    </table>
    {{$attrs->render()}}
@stop

{{--@section('css')--}}
{{--<link rel="stylesheet" href="/css/admin_custom.css">--}}
{{--@stop--}}

@section('js')
    <script>
        // console.log('Hi!');
@stop