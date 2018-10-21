@extends('adminlte::page')

@section('title', '查看角色')

@section('content_header')
    <h1>{{$role->role_name}}</h1>
@stop

@section('content')
    <div class="box-body">
        <table  class="table table-bordered table-hover dataTable" style="background: #e3e5e7;">
            <tr>
                <th>ID</th>
                <th>权限名称</th>
                <th>父级权限ID</th>
                <th>层级关系</th>
                <th>操作</th>
            </tr>
            @foreach($menus as $key => $menu)
                <tr>
                    <td>{{$menu->menu_id}}</td>
                    <td>{{str_repeat('|—',substr_count($menu->path,'-'))}}{{$menu->text}}</td>
                    <td>{{$menu->parent_id}}</td>
                    <td>{{$menu->path}}</td>
                    <td><a href="" class="fa fa-fw fa-close" title="移除角色"></a></td>
                </tr>
            @endforeach
        </table>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
