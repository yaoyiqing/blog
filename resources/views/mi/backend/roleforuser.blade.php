@extends('adminlte::page')

@section('title', '分配角色')

@section('content_header')
    <h1>分配角色：{{$user->user_name}}</h1>
@stop

@section('content')
    <form action="{{url('/admin/doRoleForUser')}}" method="post" class="form-horizontal">
        <div class="box-body">
            @csrf
            <input type="hidden" name="user_id" value="{{$user->user_id}}">
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">分配角色：</label>
                @foreach($roles as $key => $role)
                    <label for="exampleInputEmail1" class="col-sm-2 control-label"></label>
                    <div class="col-sm-10"><input type="checkbox" name="role_name[]" value="{{$role->role_id}}"  @if(in_array($role->role_id,$roleForUser)) checked @endif>{{$role->role_name}}</div>
                @endforeach
            </div>
            <label for="exampleInputEmail1" class="col-sm-2 control-label"></label>
            <input type="submit" value="分配角色" class="btn btn-primary">
        </div>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        // console.log('Hi!');
@stop
