@extends('adminlte::page')

@section('title', '添加按钮')

@section('content_header')
    <h1><b>添加按钮</b></h1>
@stop

@section('content')
    <form action="{{url('/admin/doAddButton')}}" method="post" class="form-horizontal">
        <div class="box-body">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">按钮名称：</label>
                <div class="col-sm-10"><input type="text" name="button_name" class="form-control"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">所属菜单：</label>
                <div class="col-sm-10">
                    <select name="menu_id" id=""  class="form-control">
                        <option value="0">请选择所属菜单</option>
                        @foreach($menus as $key => $menu)
                            <option value="{{$menu->menu_id}}">{{str_repeat('|—',substr_count($menu->path,'-'))}}{{$menu->text}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <label for="exampleInputEmail1" class="col-sm-2 control-label"></label>
            <input type="submit" value="添加按钮" class="btn btn-primary">
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
