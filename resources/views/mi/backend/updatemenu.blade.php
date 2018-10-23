@extends('adminlte::page')

@section('title', '修改权限')

@section('content_header')
    <h1><b>修改权限</b></h1>
@stop

@section('content')
    <form action="{{url('/admin/doUpdateMenu')}}" method="post" class="form-horizontal">
        <div class="box-body">
            <input type="hidden" name="menu_id" value="{{$menu->menu_id}}">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">权限名称：</label>
                <div class="col-sm-10"><input type="text" name="text" class="form-control" value="{{$menu->text}}"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">权限路由：</label>
                <div class="col-sm-10"><input type="text" name="url" class="form-control" value="{{$menu->url}}"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">是否展示：</label>
                @if($menu->is_menu == 1)
                <div class="col-sm-10"><input type="radio" name="is_menu" value="1" checked>是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="is_menu" value="0">否</div>
                    @endif
                @if($menu->is_menu == 0)
                    <div class="col-sm-10"><input type="radio" name="is_menu" value="1">是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="is_menu" value="0" checked>否</div>
                @endif
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">父级权限：</label>
                <div class="col-sm-10">
                    <select name="parent_id" id=""  class="form-control">
                        <option value="0">请选择父级权限</option>
                        @foreach($menu->menus as $key => $menus)
                            @if($menu->parent_id == $menus->menu_id)
                            <option value="{{$menus->menu_id}}" selected>{{str_repeat('|—',substr_count($menus->path,'-'))}}{{$menus->text}}</option>
                            @endif
                            <option value="{{$menus->menu_id}}">{{str_repeat('|—',substr_count($menus->path,'-'))}}{{$menus->text}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <label for="exampleInputEmail1" class="col-sm-2 control-label"></label>
            <input type="submit" value="修改权限" class="btn btn-primary">
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
