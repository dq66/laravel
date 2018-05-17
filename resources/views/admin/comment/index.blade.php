@extends("layouts.app")

@section("css")
    <link rel="stylesheet" href="/admin/css/black/jqadmin.css">
    <link rel="stylesheet" type="text/css" href="/admin/css/main.css?v2.0.1-simple" media="all">
@endsection
@section('content')
    <div class="layui-fluid larry-wrapper">
        <div class="layui-row layui-col-space30">
            <div class="layui-col-xs24">
                <section class="panel panel-padding">
                    <div class="group-button">
                        <button class="layui-btn layui-btn-sm layui-btn-primary">
                            <i class="iconfont">&#xe626;</i> 删除
                        </button>

                        <button class="layui-btn layui-btn-sm layui-btn-primary">
                            <i class="layui-icon">&#x1005;</i> 状态
                        </button>
                        <button class="layui-btn layui-btn-primary layui-btn-sm modal"
                                data-params='{"content": "/Admin/content/add","type":"2", "title": "添加文章"}'>
                            <i class="iconfont">&#xe649;</i> 添加
                        </button>
                    </div>
                    <div class="layui-form">
                        <div class="layui-form">
                            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
                                <legend>评论列表</legend>
                            </fieldset>
                            <table class="layui-table" lay-even="" lay-skin="nob">
                                <thead>
                                <tr>
                                    <th>文章标题</th>
                                    <th>评论作者</th>
                                    <th>内容</th>
                                    <th>邮箱地址</th>
                                    <th>评论时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                @foreach($comment as $val)
                                    <tr>
                                        <td>{{$val->comment_content->title}}</td>
                                        <td>{{$val->username}}</td>
                                        <td>
                                            {{ str_limit($val->content,60,'......')}}
                                            <a href="">查看详情</a>
                                        </td>
                                        <td><a href="">{!! $val->email !!}</a></td>
                                        <td>{{$val->created_at->diffForHumans()}}</td>
                                        <td>

                                            <a data-id="{{$val->id}}" data-content="{{$val->content}}" data-params='{"content": ".edit-subcat","area":"500px,350px", "title": "编辑评论"}'
                                               href="javascript:;" class="layui-badge layui-badge layui-bg-blue modal edit">编辑</a>
                                            <a data-id="{{$val->id}}" data-params='{"content": ".reply-subcat","area":"500px,350px", "title": "回复: {{$val->username}}"}'
                                               href="javascript:;" class="layui-badge layui-bg-cyan modal reply">回复</a>
                                            <a href="/Admin/comment/delete/{{$val->id}}" class="layui-btn-sm  layui-badge">删除</a>


                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            {!! $comment->links() !!}
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    {{--编辑评论--}}
    <div class="edit-subcat" style="display: none;padding: 20px">
        <form id="form1" class="layui-form" action="/Admin/comment/edit" method="post">
            <div class="layui-form-item">
                <label class="layui-form-label">编辑内容</label>
                <div class="layui-input-block">
                    <textarea name="content" id="content"  style="height: 10rem;" placeholder="编辑内容" class="layui-input"></textarea>
                </div>
            </div>
            <input type="hidden" id="id" name="id">
            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" type="submit">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>
    {{--回复评论--}}
    <div class="reply-subcat" style="display: none;padding: 20px">
        <form id="form1" class="layui-form" action="/Admin/comment/Reply" method="post">
            <div class="layui-form-item">
                <label class="layui-form-label">回复内容</label>
                <div class="layui-input-block">
                    <textarea name="content"  style="height: 10rem;" placeholder="回复内容" class="layui-input"></textarea>
                </div>
            </div>
            <input type="hidden" id="replyid" name="id">
            <input type="hidden" name="_token" value="{{csrf_token()}}"/>
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
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <script src="/admin/js/common.js?v=2.0.1"></script>
    <script>
        $(function () {
            //编辑
            $('.edit').click(function () {
                var id = $(this).data("id");
                var content = $(this).data("content");
                //console.log(id,content);
                $("#id").val(id);
                $("#content").val(content);
            });
            //回复
            $('.reply').click(function () {
                var id = $(this).data("id");
                $("#replyid").val(id);
            });
        });
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
