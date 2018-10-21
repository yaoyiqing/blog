@extends('adminlte::page')

@section('title', '添加管理员')

@section('content_header')
    <h1>添加管理员</h1>
@stop

@section('content')
    <form action="{{url('/admin/doAdd')}}" method="post" class="form-horizontal">
        <div class="box-body">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">管理员名称：</label>
                <div class="col-sm-10"><input type="text" name="user_name" class="form-control"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">管理员邮箱：</label>
                <div class="col-sm-10"><input type="email" name="user_email" class="form-control"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">管理员手机：</label>
                <div class="col-sm-10"><input type="text" name="mobile" class="form-control"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">添加人名称：</label>
                <div class="col-sm-10"><input type="text" name="create_name" value="{{session()->get('user.user_name')}}" class="form-control"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">超级管理员：</label>
                <div class="col-sm-10"><input type="radio" name="is_supper" value="1"> 是 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="is_supper" value="0" checked> 否</div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">分配角色：</label>
                <div class="col-sm-10">
                    <select name="role_id" id="" class="form-control">
                        <option value="0">请选择要赋予的角色</option>
                        @foreach($roles as $role)
                            <option value="{{$role->role_id}}">{{$role->role_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <label for="exampleInputEmail1" class="col-sm-2 control-label"></label>
            <input type="submit" value="添加管理员" class="btn btn-primary">
        </div>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
