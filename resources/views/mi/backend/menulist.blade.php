@extends('adminlte::page')

@section('title', '权限列表')

@section('content_header')
    <h1><b>权限列表</b></h1>
@stop

@section('content')
    <table  class="table table-bordered table-hover dataTable" style="background: #e3e5e7;">
        <tr>
            <th>ID</th>
            <th>权限名称</th>
            <th>权限路由</th>
            <th>父级权限</th>
            <th>层级关系</th>
            <th>操作</th>
        </tr>
        @foreach($menus as $menu)
            <tr>
                <td>{{$menu->menu_id}}</td>
                <td>{{str_repeat('|—',substr_count($menu->path,'-'))}}{{$menu->text}}</td>
                <td>{{$menu->url}}</td>
                <td>{{$menu->parent_id}}</td>
                <td>{{$menu->path}}</td>
                <td>
                    <a href="/admin/updatemenu/menu_id/{{$menu->menu_id}}" class="fa fa-fw fa-edit" title="修改权限"></a>
                    <a href="/admin/delmenu/menu_id/{{$menu->menu_id}}" class="fa fa-fw fa-close" title="删除权限"></a>
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