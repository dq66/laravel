@extends("layouts.app")

@section("css")
    <link rel="stylesheet" href="/admin/css/black/jqadmin.css">
    <link rel="stylesheet" type="text/css" href="/admin/css/main.css?v2.0.1-simple" media="all">
@endsection
@section('content')
    <div class="layui-fluid larry-wrapper">
        <div class="layui-row layui-col-space30">
            <div class="layui-col-xs24">

                <!--列表-->
                <section class="panel panel-padding">
                    <div class="group-button">
                        <button class="layui-btn layui-btn-sm layui-btn-primary">
                            <i class="layui-icon">&#x1005;</i> 状态
                        </button>
                        <button class="layui-btn layui-btn-primary layui-btn-sm modal"
                                data-params='{"content":".add-subcat","area":"750px,550px","title":"添加友情","action":"add"}'>
                            <i class="iconfont">&#xe649;</i> 添加
                        </button>
                    </div>
                    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
                        <legend>友情列表</legend>
                    </fieldset>
                    <div class="layui-form">
                        <div class="layui-form">
                            <table class="layui-table" lay-even="" lay-skin="nob">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>图片</th>
                                    <th>标题</th>
                                    <th>链接</th>
                                    <th>网站描述</th>
                                    <th>添加时间</th>
                                    <th>最后更新时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                @foreach($links as $val)
                                    <tr>
                                        <td>{{$val->id}}</td>
                                        <td><img src="../../{{$val->avatar}}" alt="图片" width="60px"></td>
                                        <td>{{$val->title}}</td>
                                        <td>{{$val->connect}}</td>
                                        <td>{{$val->describe}}</td>
                                        <td>{{$val->created_at}}</td>
                                        <td>{{$val->updated_at}}</td>
                                        <td>
                                            <a data-params='{"content": "/Admin/link/edit/{{$val->id}}","type":"2",
                                            "title": "修改友情"}'  href="javascript:;" class="layui-btn-sm modal
                                            layui-badge layui-badge layui-bg-blue">修改</a>
                                            <a href="/Admin/link/delete/{{$val->id}}" class="layui-btn-sm layui-badge">删除</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            {!! $links->links() !!}
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="add-subcat">
        <form id="form1" class="layui-form" action="/Admin/link/add" method="post" enctype="multipart/form-data">
            <div class="layui-form-item">
                <label class="layui-form-label">标题</label>
                <div class="layui-input-block">
                    <input type="text" name="title" placeholder="请输入标题" autocomplete="off" class="layui-input ">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">链接</label>
                <div class="layui-input-block">
                    <input type="text" name="connect" placeholder="请输入链接" autocomplete="off" class="layui-input ">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">图片</label>
                <div class="layui-input-inline">
                    <input type="file" name="avatar" >
                </div>
            </div>
            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
            <div class="layui-form-item">
                <label class="layui-form-label">描述</label>
                <div class="layui-input-block">
                    <textarea name="describe" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" type="submit">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section("js")
    <script src="/admin/js/common.js?v=2.0.1"></script>
    <script>
        layui.use('cat-list');
        layui.use('layer', function () {
            var layer = layui.layer;
            //提示
            @if(Session::has('message'))
            layer.msg("{{Session::get('message')}}", {icon: "{{Session::get('icon')}}"}, function () {
            });
            @endif
            //字段验证
            @if($errors->any())
            @foreach($errors->all() as $error)
            layer.msg('{{ $error }}', {icon: 5}, {anim: 1});
            @endforeach
            @endif

        });
    </script>

@endsection
