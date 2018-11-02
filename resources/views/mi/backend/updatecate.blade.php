@extends('adminlte::page')

@section('title', '修改分类')

@section('content_header')
    <h1><b>修改分类</b></h1>
@stop

@section('content')
    <form action="{{url('/admin/doUpdateCate')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
        <div class="box-body">
            @csrf
            <input type="hidden" value="{{$cate->cate_id}}" name="cate_id">
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">分类名称：</label>
                <div class="col-sm-10"><input type="text" name="cate_name" class="form-control" value="{{$cate->cate_name}}"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">分类路由：</label>
                <div class="col-sm-10"><input type="text" name="cate_route" class="form-control" value="{{$cate->cate_route}}"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">分类图片：</label>
                <div class="col-sm-10">
                    <input type="file" name="cate_img" value="{{$cate->cate_img}}" id="type_img" style="width:250px;height:150px;position:absolute;opacity:0;">
                    <img class="thumb" style="width:200px;height:150px;border-radius:25px;" src="{{URL::asset($cate->cate_img)}}" alt="">
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">父级权限：</label>
                <div class="col-sm-10">
                    <select name="parent_id" id=""  class="form-control">
                        <option value="0">请选择父级权限</option>
                        @foreach($cates as $key => $val)
                            @if($cate->parent_id == $val->cate_id)
                            <option value="{{$val->cate_id}}" selected>{{str_repeat('|—',substr_count($val->path,'-'))}}{{$val->cate_name}}</option>
                            @else
                            <option value="{{$val->cate_id}}">{{str_repeat('|—',substr_count($val->path,'-'))}}{{$val->cate_name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">分配属性：</label>
                <label for="exampleInputEmail1" class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    @foreach($attrs as $key => $attr)
                        <input type="checkbox" name="attr_id[]" value="{{$attr->attr_id}}" @if(in_array($attr->attr_id,$cate->attrs)) checked @endif><b>{{$attr->attr_name}}</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endforeach
                </div>
            </div>
            <label for="exampleInputEmail1" class="col-sm-2 control-label"></label>
            <input type="submit" value="修改分类" class="btn btn-primary">
        </div>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        // console.log('Hi!');
        $(function(){
            $('.thumb').attr('src','/mi/images/inputfile.png');
            $("#type_img").change(function(){
                $(".thumb").attr("src",URL.createObjectURL($(this)[0].files[0]));
            });
        });
    </script>
@stop
