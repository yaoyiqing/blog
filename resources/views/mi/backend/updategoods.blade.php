@extends('adminlte::page')

@section('title', '修改商品')

@section('content_header')
    <style>
        #goods_sku tr{
            line-height: 30px;
            background: #fff;
        }
        #value-select tr{
            line-height: 30px;
            background: #fff;
        }
        #goods_sku tr td input{
            background: #fff;
            border: none;
        }
    </style>
    <h1><b>修改商品</b></h1>
@stop

@section('content')
    <div class="box-body">
        <form action="{{url('/admin/doUpdateGoods')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="goods_id" value="{{$goods->goods_id}}">
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">商品名称：</label>
                <div class="col-sm-10"><input type="text" name="goods_name" class="form-control" value="{{$goods->goods_name}}"></div>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">商品价格：</label>
                <div class="col-sm-10">
                    <input type="text" name="goods_price" class="form-control" value="{{$goods->goods_price}}">
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">商品数量：</label>
                <div class="col-sm-10">
                    <input type="number" name="goods_count" class="form-control" value="{{$goods->goods_count}}">
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">商品货号：</label>
                <div class="col-sm-10">
                    <input type="text" name="goods_number" class="form-control" value="{{$goods->goods_number}}">
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">是否上架：</label>
                <div class="col-sm-10">
                    @if($goods->is_sale == 1)
                        <input type="radio" name="is_sale" value="1" checked>是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="is_sale" value="0">否
                    @else
                        <input type="radio" name="is_sale" value="1">是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="is_sale" value="0" checked>否
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">是否新品：</label>
                <div class="col-sm-10">
                    @if($goods->is_new == 1)
                        <input type="radio" name="is_new" value="1" checked>是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="is_new" value="0">否
                    @else
                        <input type="radio" name="is_new" value="1">是&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="is_new" value="0" checked>否
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">商品描述：</label>
                <div class="col-sm-10">
                    <div id="editor"></div>
                    <textarea name="goods_desc" id="text1" class="form-control" style="height:200px;">{{$goods->goods_desc}}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">商品分类：</label>
                <div class="col-sm-10">
                    <select name="cate_id" id="cate_id" onchange="selectAttr()" class="form-control">
                        <option value="0">请选择商品分类</option>
                        @foreach($cates as $key => $cate)
                            @if($cate->cate_id == $goods->cate_id)
                                <option value="{{$cate->cate_id}}" selected>{{str_repeat('|—',substr_count($cate->path,'-'))}}{{$cate->cate_name}}</option>
                            @endif
                            <option value="{{$cate->cate_id}}">{{str_repeat('|—',substr_count($cate->path,'-'))}}{{$cate->cate_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2  control-label">商品属性：</label>
                <div class="col-sm-10">
                    <select id="attr-select" class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="请选择商品属性" style="width: 100%;" tabindex="-1" aria-hidden="true" onchange="selectValues()">
                        <option></option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2  control-label">商品属性值：</label>
                <div class="col-sm-10">
                    <table id="value-select"  class="table table-bordered table-hover dataTable"> </table>
                    <input type="button" value="生成货品表格" class="btn btn-primary">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2  control-label">货品组合：</label>
                <div class="col-sm-10">
                    <table id="goods_sku" class="table table-bordered table-hover dataTable"></table>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" class="col-sm-2 control-label">商品图片：</label>
                <div class="col-sm-10" id="addImg"><img src="{{$goods->goods_img}}" alt="" width="80px"><div><a href="javascript:void(0);" onclick="addImg(this)">[+]</a>图片描述 <input type="text" name="img_desc[]" value="{{$goods->img_desc}}">上传文件 <input type="hidden" name="goods_image" value="{{$goods->goods_img}}"><input type="file" name="goods_img[]" style="position:absolute;display: inline-block;" value="{{$goods->goods_img}}"></div></div>
            </div>
            <label for="exampleInputEmail1" class="col-sm-2 control-label"></label>
            <input type="submit" value="修改商品" class="btn btn-primary">
        </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script type="text/javascript" src="{{URL::asset('/js/wangEditor.min.js')}}"></script>
    <script>
        // 下拉多选
        $('.select2').select2();

        // 富文本框
        var E = window.wangEditor;
        var editor = new E('#editor');
        var $text1 = $('#text1');
        editor.customConfig.onchange = function (html) {
            // 监控变化，同步更新到 textarea
            $text1.val(html);
        };
        editor.create();
        // 初始化 textarea 的值
        // $text1.val(editor.txt.html());
        // $("#editor").val() = $text1.val();

        // 根据分类显示属性
        function selectAttr()
        {
            var cate = $("#cate_id").val();
            $.ajax({
                type: "POST",
                url: "/admin/getattrbycate",
                data: {'_token':'{{csrf_token()}}',cate:cate},
                dataType: 'json',
                success: function(msg){
                    // alert(123);
                    var option_html = '';
                    for(var i in msg){
                        option_html += '<option value="'+msg[i].attr_id+'">'+msg[i].attr_name+'</option>';
                    }
                    $('#attr-select').html(option_html);
                }
            });
        }

        // 根据属性显示属性值
        function selectValues()
        {
            var attr = $("#attr-select").val();
            $.ajax({
                type: "POST",
                url: "/admin/getvaluebyattr",
                data: {'_token':'{{csrf_token()}}',attr:attr},
                dataType: 'json',
                success: function(msg){
                    var value_html = '<tr><th>属性</th><th>属性值</th></tr>';
                    for(var i in msg){
                        value_html += '<tr><th><input type="hidden" value="' + msg[i][0].attr_id + '">' + msg[i][0].attr_name + '</th><td class="attr">';
                        for(var j in msg[i]){
                            value_html += '<input type="checkbox" value="' + msg[i][j].attr_value_id + '" class="attr_value" name="attr_value[' + msg[i][0].attr_id + '][]"><input type="hidden" value="' + msg[i][j].attr_value_name + '" class="attr_hidden">' + msg[i][j].attr_value_name + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                        }
                        value_html += '</td></tr>';
                    }
                    $("#value-select").html(value_html);
                }
            });
        }

        (function() {
            //笛卡尔积
            var Cartesian = function(a, b) {
                var ret = [];
                for (var i = 0; i < a.length; i++) {
                    for (var j = 0; j < b.length; j++) {
                        ret.push(ft(a[i], b[j]));
                    }
                }
                return ret;
            };
            var ft = function(a, b) {
                if (! (a instanceof Array)) a = [a];
                var ret = Array.call(null, a);
                ret.push(b);
                return ret;
            };
            //多个一起做笛卡尔积
            multiCartesian = function(data) {
                var len = data.length;
                if (len == 0) return [];
                else if (len == 1) return data[0];
                else {
                    var r = data[0];
                    for (var i = 1; i < len; i++) {
                        r = Cartesian(r, data[i]);
                    }
                    return r;
                }
            }
        })();

        // 根据选择的属性值生成货品
        $(":button").click(function(){
            var values = [];
            var valueIds = [];
            $(".attr").each(function(){

                var childId = [];
                $(this).find(".attr_hidden").each(function(){
                    if($(this).prev().is(":checked")){
                        childId.push($(this).val());
                    }
                });
                valueIds.push(childId);

                var child = [];
                $(this).find(".attr_value").each(function(){
                    if($(this).is(":checked")){
                        child.push($(this).val());
                    }
                });
                values.push(child);

            });

            // 调用笛卡尔积方法
            var r = multiCartesian(values);
            var v = multiCartesian(valueIds);

            var tbl = '<tr><th>组合类型</th><th>货品编号</th><th>价格</th><th>库存</th><th>操作</th></tr>';
            for (var i = 0; i < r.length; i++) {
                tbl += "<tr id='"+i+"'><td><input type='hidden' name='sku_str[]' value='" + r[i] + "'><input type='text' name='sku_name[]' value='" + v[i] + "' readonly></td><td><input type='text' placeholder='请输入货品编号' name='sku_number[]'></td><td><input type='text' placeholder='请输入货品价格（元）' name='sku_price[]'></td><td><input type='number' placeholder='请输入货品库存' name='sku_count[]' min='0'></td><td><a class='fa fa-fw fa-trash' title='删除' onclick='removeSku(" + i + ")'></td></tr>";
            }
            $("#goods_sku").html(tbl);
        });

        // 货品表删除单条货品
        function removeSku(i) {
            $("#"+i+"").remove();
        }

        function addImg(obj) {
            var goods_img = $("[type=file]");
            var len = goods_img.length;
            var imgDiv = '<div><a href="javascript:void(0);" onclick="removeImg(this)">[-] </a>图片描述 <input type="text" name="img_desc[]">上传文件 <input type="file" name="goods_img[]" style="position:absolute;display: inline-block;"></div>';
            if(len < 5){
                $("#addImg").append(imgDiv);
            }
        }

        function removeImg(obj) {
            var addImg = obj.parentNode;
            var imgDiv = '<div><a href="javascript:void(0);" onclick="removeImg(this)">[-] </a>图片描述 <input type="text" name="img_desc[]">上传文件 <input type="file" name="goods_img[]" style="position:absolute;display: inline-block;"></div>';
            addImg.remove(imgDiv);
        }

    </script>
@stop