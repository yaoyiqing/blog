@extends('adminlte::page')

@section('title', '添加分类')

@section('content_header')
    <h1><b>添加分类</b></h1>
@stop

@section('content')
    <form action="{{url('/admin/doAddCate')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
        <div class="box-body">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">分类名称：</label>
                <div class="col-sm-10"><input type="text" name="cate_name" class="form-control"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">分类路由：</label>
                <div class="col-sm-10"><input type="text" name="cate_route" class="form-control"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">分类图片：</label>
                <div class="col-sm-10">
                    <input type="file" name="cate_img" id="type_img" style="width:250px;height:150px;position:absolute;opacity:0;">
                    <img class="thumb" style="width:200px;height:150px;border-radius:25px;" src="" alt="">
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">父级权限：</label>
                <div class="col-sm-10">
                    <select name="parent_id" id=""  class="form-control">
                        <option value="0">请选择父级权限</option>
                        @foreach($cates as $key => $cate)
                            <option value="{{$cate->cate_id}}">{{str_repeat('|—',substr_count($cate->path,'-'))}}{{$cate->cate_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">分配属性：</label>
                <label for="exampleInputEmail1" class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                    @foreach($attrs as $key => $attr)
                        <input type="checkbox" name="attr_id[]" value="{{$attr->attr_id}}"><b>{{$attr->attr_name}}</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endforeach
                </div>
            </div>
            <label for="exampleInputEmail1" class="col-sm-2 control-label"></label>
            <input type="submit" value="添加分类" class="btn btn-primary">
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
            var TypeImg = $('input:file').attr('img');
            if (TypeImg) {
                $('.thumb').attr('src','/mi/images/cates/'+TypeImg);
            } else {
                $('.thumb').attr('src','/mi/images/inputfile.png');
            }
            $("#type_img").change(function(){
                $(".thumb").attr("src",URL.createObjectURL($(this)[0].files[0]));
            });
        });
    </script>
@stop
