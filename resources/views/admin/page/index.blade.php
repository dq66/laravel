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
                                data-params='{"content": "/Admin/page/add","type":"2", "title": "添加页面"}'>
                            <i class="iconfont">&#xe649;</i> 添加
                        </button>
                    </div>
                    <div class="layui-form">
                        <div class="layui-form">
                            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
                                <legend>页面列表</legend>
                            </fieldset>
                            <table class="layui-table" lay-even="" lay-skin="nob">
                                <colgroup>
                                    <col width="20">
                                    <col width="15%">
                                    <col width="20%">
                                    <col width="15%">
                                    <col width="">
                                    <col width="18%">
                                    <col width="16%">
                                </colgroup>
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>标题</th>
                                    <th>作者</th>
                                    <th>发表时间</th>
                                    <th>最后更新时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                @foreach($contents as $val)
                                    <tr>
                                        <td>
                                            <a href=""><span title="{{$val->commentsNum}}条评论"
                                                             class="layui-badge">{{$val->commentsNum}}</span></a>
                                        </td>
                                        <td>
                                            <a href="/Admin/page/edit/{{$val->id}}">{{$val->title}}</a>
                                            <a href="/Admin/page/edit/{{$val->id}}" title="编辑 {{$val->title}}"><i
                                                        class="icon-bianji-copy-copy iconfont"></i></a>
                                            <a href="" title="浏览 {{$val->title}}"><i
                                                        class="icon-liulan1 iconfont"></i></a>
                                        </td>
                                        <td><a href="">{{$val->user->name}}</a></td>
                                        <td>{{$val->created_at}}</td>
                                        <td>{{$val->updated_at->diffForHumans()}}</td>
                                        <td>
                                            @if(is_null($val->deleted_at))
                                                <a href="/Admin/page/destroy/{{$val->id}}" class="layui-badge">删除</a>
                                            @else
                                                <a href="/Admin/page/restore/{{$val->id}}" class="layui-btn-sm layui-bg-blue">恢复</a>
                                                <a href="/Admin/page/delete/{{$val->id}}" class="layui-btn-sm  layui-badge">彻底删除</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            {!! $contents->links() !!}
                        </div>
                    </div>
                </section>
            </div>
        </div>
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
