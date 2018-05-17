<div class="bg-ovo"></div>
<div class="mdui-container mdui-typo searchData" role="main">

    <h3>{{$year}}年{{$month}}月 的文章</h3>

    @if(is_null($content))
        <div style="text-align: center;font-size: 2rem;color: white">暂时没有数据！请稍后。。。</div>
    @else
        @foreach($content as $con)
            <article class="s-data-card mdui-col-md-4" style="height: 288px!important;">
                <div class="s-data-card-con shadow-2">
                    <div class="colorHi"></div>
                    <h5>{{$con->title}}</h5>
                    <p>
                        作者: <a itemprop="name" href="/archives/{{$con->slug}}.html" rel="author">{{$con->name}}</a>
                        &nbsp;时间: <time datetime="2018-04-21T20:01:00+08:00" itemprop="datePublished">{{$con->created_at}}</time>
                    </p>
                    <p>
                        <a href="/archives/{{$con->slug}}.html">{{$con->commentsNum}} 条评论</a>
                    </p>
                    <div class="mdui-divider" style="margin-bottom: 10px"></div>
                    <p class="mdui-text-truncate" style="width: 280px;">{!! $con->text !!}</p>
                </div>
            </article>
        @endforeach
    @endif

</div>