@extends('adminlte::page')

@section('title', '添加属性')

@section('content_header')
    <h1><b>添加属性</b></h1>
@stop

@section('content')
    <form action="{{url('/admin/doAddAttr')}}" method="post" class="form-horizontal">
        <div class="box-body">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">属性名称：</label>
                <div class="col-sm-10"><input type="text" name="attr_name" class="form-control"></div>
            </div>
            <label for="exampleInputEmail1" class="col-sm-2 control-label"></label>
            <input type="submit" value="添加属性" class="btn btn-primary">
        </div>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        // console.log('Hi!');
    </script>
@stop
