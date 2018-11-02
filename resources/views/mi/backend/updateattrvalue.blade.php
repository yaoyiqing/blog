@extends('adminlte::page')

@section('title', '修改属性值')

@section('content_header')
    <h1><b>修改属性值</b></h1>
@stop

@section('content')
    <form action="{{url('/admin/doUpdateAttrValue')}}" method="post" class="form-horizontal">
        <div class="box-body">
            @csrf
            <input type="hidden" value="{{$value->attr_value_id}}" name="attr_value_id">
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">属性值：</label>
                <div class="col-sm-10"><input type="text" name="attr_value_name" class="form-control" value="{{$value->attr_value_name}}"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">属性：</label>
                <div class="col-sm-10">
                    <select name="attr_id" id=""  class="form-control">
                        @foreach($attrs as $key => $attr)
                            @if($attr->attr_id == $value->attr_id)
                                <option value="{{$attr->attr_id}}" selected>{{$attr->attr_name}}</option>
                            @endif
                            <option value="{{$attr->attr_id}}">{{$attr->attr_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <label for="exampleInputEmail1" class="col-sm-2 control-label"></label>
            <input type="submit" value="修改属性值" class="btn btn-primary">
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
