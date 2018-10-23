@extends('adminlte::page')

@section('title', '添加角色')

@section('content_header')
    <h1>添加角色</h1>
@stop

@section('content')
    <form action="{{url('/admin/doAddRole')}}" method="post" class="form-horizontal">
        <div class="box-body">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">角色名称：</label>
                <div class="col-sm-10"><input type="text" name="role_name" class="form-control"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">分配权限：</label>
                @foreach($menus as $key => $menu)
                    <label for="exampleInputEmail1" class="col-sm-2 control-label"></label>
                    <div class="col-sm-10"><input type="checkbox" name="menu_name[]" value="{{$menu['menu_id']}}" id="parent_{{$menu['menu_id']}}" onclick="parent({{$menu['menu_id']}})"><b>{{$menu['text']}}</b></div>
                        <label for="exampleInputEmail1" class="col-sm-3 control-label"></label>
                        <div class="col-sm-9">
                        @foreach($menu['submenu'] as $k => $val)
                                <input type="checkbox" name="menu_name[]" value="{{$val['menu_id']}}" class="child_{{$val['parent_id']}}" onchange="child({{$val['parent_id']}})">{{$val['text']}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endforeach
                        </div>
                @endforeach
            </div>
            <label for="exampleInputEmail1" class="col-sm-2 control-label"></label>
            <input type="submit" value="添加角色" class="btn btn-primary">
        </div>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        // $(function(){
        //     alert(123);
        // })
        // console.log('Hi!');
        function parent(menuId)
        {
            var status = $("#parent_"+menuId).is(":checked");
            $(".child_"+menuId).prop("checked",status);
            // alert(status);
        }
        function child(menuId)
        {
            var status = $(".child_"+menuId).is(":checked");
            $("#parent_"+menuId).prop("checked",status);
        }
    </script>
@stop
