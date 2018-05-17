<div class="bg-ovo"></div>
<div class="mdui-container mdui-typo searchData" role="main">
    <h3>友情链接</h3>
    <ul class="md-links">
        @if(isset($links))
            @foreach($links as $li)
                <li class="md-links-item">
                    <a href="{{$li->connect}}" title="neoFelhz" target="_blank">
                        <img src="{{$li->avatar}}" alt="neoFelhz" width="72px" height="72px">
                        <span class="md-links-title">{{$li->title}}</span><br>
                    </a>
                    <span>{{$li->describe}}</span>
                </li>
            @endforeach
        @endif
        {{--<li class="md-links-item">--}}
            {{--<a href="https://nfz.moe/" title="neoFelhz" target="_blank">--}}
                {{--<img src="https://alicdn.viosey.com/img/blog/f-avatars/neofelhz1.png" alt="neoFelhz" width="72px">--}}
                {{--<span class="md-links-title">二次元智障</span><br>--}}
            {{--</a>--}}
            {{--<span>拾穗者的故事</span>--}}
        {{--</li>--}}
        {{--<li class="md-links-item">--}}
            {{--<a href="https://nfz.moe/" title="neoFelhz" target="_blank">--}}
                {{--<img src="https://alicdn.viosey.com/img/blog/f-avatars/neofelhz1.png" alt="neoFelhz" width="72px">--}}
                {{--<span class="md-links-title">neoFelhz</span><br>--}}
            {{--</a>--}}
            {{--<span>拾穗者的故事</span>--}}
        {{--</li>--}}
        {{--<li class="md-links-item">--}}
            {{--<a href="https://nfz.moe/" title="neoFelhz" target="_blank">--}}
                {{--<img src="https://alicdn.viosey.com/img/blog/f-avatars/neofelhz1.png" alt="neoFelhz" width="72px">--}}
                {{--<span class="md-links-title">neoFelhz</span><br>--}}
            {{--</a>--}}
            {{--<span>拾穗者的故事</span>--}}
        {{--</li>--}}
        {{--<li class="md-links-item">--}}
            {{--<a href="https://nfz.moe/" title="neoFelhz" target="_blank">--}}
                {{--<img src="https://alicdn.viosey.com/img/blog/f-avatars/neofelhz1.png" alt="neoFelhz" width="72px">--}}
                {{--<span class="md-links-title">neoFelhz</span><br>--}}
            {{--</a>--}}
            {{--<span>拾穗者的故事</span>--}}
        {{--</li>--}}
    </ul>
</div>

{{--<div class="mdui-container sibi shadow-2 mdui-typo">--}}
    {{--<div class="pageHead" id="respond-post-1">--}}
        {{--<div class="newBB mdui-col-md-12">--}}
            {{--<form method="post" action="/comment/" style="width: 100%" role="form"--}}
                  {{--id="comment_form">--}}
                {{--<div class="userIC">--}}
                    {{--@if(is_null(session('user_info')))--}}
                        {{--<div class="mdui-col-xs-12 mdui-col-md-3 getData-input" id="userName">--}}
                            {{--<input type="text" placeholder="昵称" name="username" value="" required="">--}}
                        {{--</div>--}}
                        {{--<div class="mdui-col-xs-12 mdui-col-md-3 getData-input" id="mail">--}}
                            {{--<input type="email" placeholder="邮箱" name="email" value="" required="">--}}
                        {{--</div>--}}
                        {{--<div class="mdui-col-xs-12 mdui-col-md-4 getData-input" id="urls">--}}
                            {{--<input type="text" name="url" id="urls" placeholder="http://" value="">--}}
                        {{--</div>--}}
                    {{--@else--}}
                        {{--<p>登录身份:--}}
                            {{--<a href="#">{{session('user_info')['username']}}</a>.--}}
                            {{--<a href="/logout/" title="Logout">退出 » </a></p>--}}
                    {{--@endif--}}
                {{--</div>--}}
                {{--<div class="mdui-col-xs-12 mdui-col-md-10 getData-input" id="content">--}}
                        {{--<textarea name="content" id="textarea" class="textarea"--}}
                                  {{--placeholder="评论内容,支持Markdown语法,代码高亮请使用<pre><code class=‘language-你的语言’>你的内容</code></pre>"--}}
                                  {{--required=""></textarea>--}}
                {{--</div>--}}
                {{--{!! csrf_field() !!}--}}
                {{--<div class="mdui-col-xs-12 mdui-col-md-2" id="subBtn">--}}
                    {{--<button class="mdui-ripple shadow-1" type="submit">提交评论</button>--}}
                {{--</div>--}}
            {{--</form>--}}

        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="comments">--}}
        {{--@partial('children',['collections'=>'Hello'])--}}
        {{--children--}}
        {{--{{dump($commentss->id)}}--}}

    {{--</div>--}}
{{--</div>--}}
