@extends('adminlte::page')

@section('title', '添加属性值')

@section('content_header')
    <h1><b>添加属性值</b></h1>
@stop

@section('content')
    <form action="{{url('/admin/doAddValue')}}" method="post" class="form-horizontal">
        <div class="box-body">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">属性值：</label>
                <div class="col-sm-10"><input type="text" name="attr_value_name" class="form-control"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">属性：</label>
                <div class="col-sm-10">
                    <select name="attr_id" id=""  class="form-control">
                        @foreach($attrs as $key => $attr)
                            <option value="{{$attr->attr_id}}">{{$attr->attr_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <label for="exampleInputEmail1" class="col-sm-2 control-label"></label>
            <input type="submit" value="添加属性值" class="btn btn-primary">
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
