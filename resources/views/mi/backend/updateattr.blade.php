@extends('adminlte::page')

@section('title', '修改属性')

@section('content_header')
    <h1><b>修改属性</b></h1>
@stop

@section('content')
    <form action="{{url('/admin/doUpdateAttr')}}" method="post" class="form-horizontal">
        <div class="box-body">
            @csrf
            <input type="hidden" value="{{$attr->attr_id}}" name="attr_id">
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">属性名称：</label>
                <div class="col-sm-10"><input type="text" name="attr_name" class="form-control" value="{{$attr->attr_name}}"></div>
            </div>
            <label for="exampleInputEmail1" class="col-sm-2 control-label"></label>
            <input type="submit" value="修改属性" class="btn btn-primary">
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
