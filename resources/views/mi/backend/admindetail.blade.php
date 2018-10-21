@extends('adminlte::page')

@section('title', '管理员详情')

@section('content_header')
    <h1>{{$admin['user_name']}}</h1>
@stop

@section('content')
    <div class="box-body">
        <table  class="table table-bordered table-hover dataTable" style="background: #e3e5e7;">
            <tr>
                <th width="200px">邮箱</th>
                <td>{{$admin['user_email']}}</td>
            </tr>
            <tr>
                <th>手机号</th>
                <td>{{$admin['mobile']}}</td>
            </tr>
            <tr>
                <th>拥有角色</th>
                <td>{{$admin['roles']}}</td>
            </tr>
            <tr>
                <th>创建时间</th>
                <td>{{date("Y-m-d H:i:s",$admin['create_time'])}}</td>
            </tr>
            <tr>
                <th>创建人</th>
                <td>{{$admin['create_name']}}</td>
            </tr>
            <tr>
                <th>最后一次登陆时间</th>
                <td>{{date("Y-m-d H:i:s",$admin['last_login_time'])}}</td>
            </tr>
            <tr>
                <th>是否是超级管理员</th>
                <td>{{$admin['is_supper']==1 ? '是' : '否'}}</td>
            </tr>
            <tr>
                <th>是否已被冻结</th>
                <td>{{$admin['is_freeze']==0 ? '是' : '否'}}</td>
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
