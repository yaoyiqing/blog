@extends('adminlte::page')

@section('title', '属性值列表')

@section('content_header')
    <h1><b>属性值列表</b></h1>
@stop

@section('content')
    <table  class="table table-bordered table-hover dataTable" style="background: #e3e5e7;">
        <tr>
            <th>ID</th>
            <th>属性值名称</th>
            <th>所属属性</th>
            <th>操作</th>
        </tr>
        @foreach($values as $value)
            <tr>
                <td>{{$value->attr_value_id}}</td>
                <td>{{$value->attr_value_name}}</td>
                <td>{{$value->attr_name}}</td>
                <td>
                    <a href="/admin/updateattrvalue/value_id/{{$value->attr_value_id}}" class="fa fa-fw fa-edit" title="修改属性值"></a>
                    <a href="/admin/delattrvalue/value_id/{{$value->attr_value_id}}" class="fa fa-fw fa-close" title="删除属性值"></a>
                </td>
            </tr>
        @endforeach
    </table>
    {{$values->render()}}
@stop

{{--@section('css')--}}
{{--<link rel="stylesheet" href="/css/admin_custom.css">--}}
{{--@stop--}}

@section('js')
    <script>
        // console.log('Hi!');
@stop