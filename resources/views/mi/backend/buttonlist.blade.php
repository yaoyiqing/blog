@extends('adminlte::page')

@section('title', '按钮列表')

@section('content_header')
    <h1><b>按钮列表</b></h1>
@stop

@section('content')
    <table  class="table table-bordered table-hover dataTable" style="background: #e3e5e7;">
        <tr>
            <th>ID</th>
            <th>按钮名称</th>
            <th>所属菜单</th>
            <th>操作</th>
        </tr>
        @foreach($buttons as $button)
            <tr>
                <td>{{$button->button_id}}</td>
                <td>{{$button->button_name}}</td>
                <td>{{$button->text}}</td>
                <td>
                    <a href="/admin/updatebutton/button_id/{{$button->button_id}}" class="fa fa-fw fa-edit" title="修改按钮"></a>
                    <a href="/admin/delbutton/button_id/{{$button->button_id}}" class="fa fa-fw fa-close" title="删除按钮"></a>
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
@stop