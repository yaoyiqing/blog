@extends('adminlte::page')

@section('title', '修改角色')

@section('content_header')
    <h1>修改角色</h1>
@stop

@section('content')
    <form action="{{url('/admin/doupdaterole')}}" method="post" class="form-horizontal">
        <div class="box-body">
            @csrf
            <div class="form-group">
                <input type="hidden" value="{{$role['role_id']}}" name="role_id">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">角色名称：</label>
                <div class="col-sm-10"><input type="text" name="role_name" class="form-control" value="{{$role['role_name']}}"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">分配权限：</label>
                @foreach($menus as $key => $menu)
                    <label for="exampleInputEmail1" class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <input type="checkbox" name="menu_name[]" value="{{$menu['menu_id']}}" id="parent_{{$menu['menu_id']}}" onclick="parent({{$menu['menu_id']}})" @if(in_array($menu['menu_id'],$resource))checked @endif><b>{{$menu['text']}}</b>
                    </div>
                    <label for="exampleInputEmail1" class="col-sm-3 control-label"></label>
                    <div class="col-sm-9">
                        @foreach($menu['submenu'] as $k => $val)
                            <input type="checkbox" name="menu_name[]" value="{{$val['menu_id']}}" class="child_{{$val['parent_id']}}" onchange="child({{$val['parent_id']}})" @if(in_array($val['menu_id'],$resource))checked @endif>{{$val['text']}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        @endforeach
                    </div>
                @endforeach
            </div>
            <label for="exampleInputEmail1" class="col-sm-2 control-label"></label>
            <input type="submit" value="修改角色" class="btn btn-primary">
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
