@extends('adminlte::page')

@section('title', '角色列表')

@section('content_header')
    <h1><b>角色列表</b></h1>
@stop

@section('content')
    <table  class="table table-bordered table-hover dataTable" style="background: #e3e5e7;">
        <tr>
            <th>ID</th>
            <th>角色名称</th>
            <th>操作</th>
        </tr>
        @foreach($roles as $role)
            <tr>
                <td>{{$role->role_id}}</td>
                <td>{{$role->role_name}}</td>
                <td>
                    <a href="/admin/detail/role_id/{{$role->role_id}}" class="fa fa-fw fa-file-text-o" title="查看权限"></a>
                    <a href="/admin/updaterole/role_id/{{$role->role_id}}" class="fa fa-fw fa-edit" title="分配权限"></a>
                    <a href="/admin/delrole/role_id/{{$role->role_id}}" class="fa fa-fw fa-close" title="删除角色"></a>
                </td>
            </tr>
        @endforeach
    </table>
    {{$roles->render()}}
@stop

{{--@section('css')--}}
{{--<link rel="stylesheet" href="/css/admin_custom.css">--}}
{{--@stop--}}

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop