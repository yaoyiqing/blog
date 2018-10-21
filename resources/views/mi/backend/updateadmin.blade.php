@extends('adminlte::page')

@section('title', '修改管理员资料')

@section('content_header')
    <h1>修改管理员资料</h1>
@stop

@section('content')
    <form action="{{url('/admin/doUpdate')}}" method="post" class="form-horizontal">
        <div class="box-body">
            @csrf
            <div class="form-group">
                <input type="hidden" name="user_id" value="{{$userinfo->user_id}}">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">管理员名称：</label>
                <div class="col-sm-10"><input type="text" name="user_name" class="form-control" value="{{$userinfo->user_name}}"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">管理员邮箱：</label>
                <div class="col-sm-10"><input type="email" name="user_email" class="form-control" value="{{$userinfo->user_email}}"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">管理员手机：</label>
                <div class="col-sm-10"><input type="text" name="mobile" class="form-control" value="{{$userinfo->mobile}}"></div>
            </div>
            <label for="exampleInputEmail1" class="col-sm-2 control-label"></label>
            <input type="submit" value="确认修改" class="btn btn-primary">
        </div>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
