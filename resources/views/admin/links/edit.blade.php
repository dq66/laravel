@extends("layouts.app")

@section("css")
    <link rel="stylesheet" href="/admin/css/black/jqadmin.css">
    <link rel="stylesheet" type="text/css" href="/admin/css/main.css?v2.0.1-simple" media="all">
@endsection
@section('content')
    <section class="panel panel-padding">
        <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
            <legend>修改友情</legend>
        </fieldset>
        <div class="layui-fluid larry-wrapper">
            <div class="update-subcat">
                <form id="form1" class="layui-form" action="/Admin/link/edit/{{$links->id}}" method="post" enctype="multipart/form-data">
                    <div class="layui-form-item">
                        <label class="layui-form-label">标题</label>
                        <div class="layui-input-block">
                            <input type="text" name="title" value="{{$links->title}}" autocomplete="off" class="layui-input ">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">链接</label>
                        <div class="layui-input-block">
                            <input type="text" name="connect" value="{{$links->connect}}" autocomplete="off" class="layui-input ">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">图片</label>
                        <div class="layui-input-inline">
                            @if(isset($links->avatar))
                                <img src="../../../{{$links->avatar}}" alt="图片" width="60px" height="60px">
                            @endif
                            <input type="file" name="avatar" style="margin-top: 10px">
                        </div>
                    </div>
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                    <input type="hidden" name="yimg" value="{{$links->avatar}}">
                    <div class="layui-form-item">
                        <label class="layui-form-label">描述</label>
                        <div class="layui-input-block">
                            <textarea name="describe" class="layui-textarea">{{$links->describe}}</textarea>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <button class="layui-btn" id="btnsave" type="submit">立即提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section("js")
    <script src="/admin/js/common.js?v=2.0.1"></script>
    <script>
        layui.use('cat-list');
        layui.use('layer', function () {
            var layer = layui.layer;
            //字段验证
            @if($errors->any())
            @foreach($errors->all() as $error)
            layer.msg('{{ $error }}', {icon: 5}, {anim: 1});
            @endforeach
            @endif

        });
    </script>
@endsection