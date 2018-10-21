@extends('adminlte::page')

@section('title', '管理员列表')

@section('content_header')
    <h1><b>管理员列表</b></h1>
@stop

@section('content')
    <table  class="table table-bordered table-hover dataTable" style="background: #e3e5e7;">
        <tr>
            <th>ID</th>
            <th>管理员名称</th>
            <th>管理员邮箱</th>
            <th>管理员手机</th>
            <th>最后一次登陆时间</th>
            <th>添加人</th>
            <th>操作</th>
        </tr>
        @foreach($admins as $admin)
        <tr>
            <td>{{$admin->user_id}}</td>
            <td>{{$admin->user_name}}</td>
            <td>{{$admin->user_email}}</td>
            <td>{{$admin->mobile}}</td>
            <td>{{date("Y-m-d H:i:s",$admin->last_login_time)}}</td>
            <td>{{$admin->create_name}}</td>
            <td>
                <a href="/admin/admindetail/user_id/{{$admin->user_id}}" class="fa fa-fw fa-file-text-o" title="查看详情"></a>
                @if(session()->get('user.user_id') == $admin->user_id)
                    <a href="/admin/update/user_id/{{$admin->user_id}}" class="fa fa-fw fa-edit" title="修改资料"></a>
                @endif
                @if(session()->get('user.is_supper') == 1)
                    @if($admin->is_supper == 0)
                        <a href="{{url('')}}" class="fa fa-fw fa-edit" title="修改管理员权限"></a>
                    @endif
                    <a href="" class="fa fa-fw fa-close" title="删除管理员"></a>

                    @if($admin->is_freeze == 1)
                        <a href="javascript:void(0);" class="fa fa-fw fa-toggle-on freeze" title="冻结账号" id="{{$admin->user_id}}"></a>
                    @elseif($admin->is_freeze == 0)
                        <a href="javascript:void(0);" class="fa fa-fw fa-toggle-off freeze" title="解冻账号" id="{{$admin->user_id}}"></a>
                    @endif
                @endif
            </td>
        </tr>
            @endforeach
    </table>
@stop

{{--@section('css')--}}
    {{--<link rel="stylesheet" href="/css/admin_custom.css">--}}
{{--@stop--}}

@section('js')
    <script>
        // console.log('Hi!');
        $(".freeze").click(function(){
            var userid = $(this).attr('id');
            // alert(userid);
            $.ajax({
                'type':'post',
                'url':"freeze",
                'data':{user_id:userid,'_token':'{{csrf_token()}}'},
                success:function (msg) {
                    if(msg){
                        // $("body").html(msg);
                        history.go(0);
                    }
                }
            });
            // alert(userId);
        });
    </script>
@stop