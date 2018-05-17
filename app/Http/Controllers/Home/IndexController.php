<?php

namespace App\Http\Controllers\Home;

use App\Model\Comment;
use App\Model\Content;
use App\Model\Link;
use App\Model\Metas;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    /**
     * Notes:首页
     * User:Administrator
     * Date:2018/4/26
     * Time:13:30
     * @return \View
     */
    public function index()
    {
        $content = Content::with('metas')
            ->with('tags')
            ->with('user')
            ->where("types","=",1)
            ->paginate(2);
        $comments_desc = Comment::with("comment_content")->orderBy('created_at', 'desc')->get();
        $content_desc = Content::where("types","=",1)->orderBy('created_at', 'desc')->get();

        \SEOMeta::setTitle(env("SITE_NAME"));
        \SEOMeta::setDescription(env('SITE_describe'));
        \SEOMeta::setCanonical(env('SITE_address'));
        \SEOMeta::addKeyword([env('SITE_KEY')]);

        \OpenGraph::setDescription(env('SITE_describe'));
        \OpenGraph::setTitle(env("SITE_NAME"));
        \OpenGraph::setUrl(env('SITE_address'));
        \OpenGraph::addProperty('type', 'articles');

        \OpenGraph::addProperty('type', 'article');
        \OpenGraph::addProperty('locale', 'pt-br');
        \OpenGraph::addProperty('locale:alternate', ['pt-pt', 'en-us']);

        return \Theme::view('index', compact('content', 'comments_desc', 'content_desc'));
    }

    /**
     * Notes:文章详情
     * User:Administrator
     * Date:2018/4/26
     * Time:13:29
     * @param Request $request
     * @param $slug
     * @return \View
     */
    public function archives(Request $request, $slug)
    {
        $content = Content::where("slug", "=", $slug)
            ->with('metas')
            ->with('tags')
            ->with('user')
            ->first();
//        dump($content);
//        dump($content->id);
        $commentss = Comment::where("content_id", "=", $content->id)->get()->toTree();
        $key = collect($content->tags)->map(function ($k) {
            return $k['name'];
        });

        \SEOMeta::setTitle($content->title);
        \SEOMeta::setDescription(str_limit($content->text, "100", "... ..."));
        \SEOMeta::setCanonical(env('SITE_address'));
        \SEOMeta::addKeyword($key);

        \OpenGraph::setDescription(str_limit($content->text, "100", "... ..."));
        \OpenGraph::setTitle($content->title);
        \OpenGraph::setUrl(env('SITE_address'));
        \OpenGraph::addProperty('type', 'articles');
        \OpenGraph::addProperty('type', 'article');
        \OpenGraph::addProperty('locale', 'pt-br');
        \OpenGraph::addProperty('locale:alternate', ['pt-pt', 'en-us']);

        \OpenGraph::setTitle($content->title)
            ->setDescription(str_limit($content->text, "100", "... ..."))
            ->setType('article')
            ->setArticle([
                'published_time' => $content->created_at,
                'modified_time' => $content->updated_at,
                'author' => $content->user->name,
                'tag' => implode("/", $key->toArray())
            ]);

        return \Theme::view("archives", compact('content', 'commentss', 'key'));

    }

    /**
     * Notes:提交评论
     * User:Administrator
     * Date:2018/4/26
     * Time:13:26
     * @param Request $request
     * @param $post_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Jiaxincui\ClosureTable\Exceptions\ClosureTableException
     */
    public function comment_create(Request $request, $post_id)
    {
        $parent = $request->post('parent') ?? 0;
        $input = $request->except(['_token', 'content']);
        $string = string_remove_xss($request->post('content')) == $request->post('content') ? $request->post('content') : string_remove_xss($request->post('content')) . '<img src="/themes/snow/assets/img/xss.jpg" alt="友情提示,这兄弟玩xss被我捉住了！！">';
        if (is_null(session('user_info'))) {
            $request->session()->put('user_info', [
                    'username' => $request->post('username'),
                    'email' => $request->post('email'),
                    'url' => $request->post('url'),
                ]
            );
        }
        if ($parent != 0) {
            $c = Comment::where("id", "=", $parent)->first();
            $collect = collect(
                [session('user_info') ?? $input,
                    [
                        'parent' => $request->post('parent'),
                        'content_id' => $post_id,
                        'content' => $string,
                        'is_blog' => 0
                    ]
                ]);
            $collapsed = $collect->collapse();
//            dump($collapsed->toArray());
            $child = $c->createChild($collapsed->toArray());

            Content::where("id", "=", $post_id)->update(["commentsNum" => Comment::where("content_id", "=", $post_id)->count()]);


            $da = Comment::where("id", "=", $child->id)->with("comment_content")->first();

            reply_em($da, $c);


            return redirect("archives/{$da->comment_content->slug}.html#comments-{$child->id}");


        } else {
            $collect = collect(
                [
                    ["parent" => $parent], session('user_info') ?? $input,
                    [
                        'content_id' => $post_id,
                        'content' => $string,
                        'is_blog' => 0
                    ]
                ]);
            $collapsed = $collect->collapse();
            $comm = Comment::create($collapsed->toArray());
            if ($comm) {
                //更新评论条数
                Content::where("id", "=", $post_id)->update(["commentsNum" => Comment::where("content_id", "=", $post_id)->count()]);


                $da = Comment::where("id", "=", $comm->id)->with("comment_content")->first();

                $us = User::find($da->comment_content->user_id);

                send_em($da, $us);

                return redirect("archives/{$da->comment_content->slug}.html#comments-{$comm->id}");
            }
        }
    }


    /**
     * Notes:分类下的文章
     * User:Administrator
     * Date:2018/4/28
     * Time:10:20
     * @param $id
     * @return \View
     */
    public function typelist($id){

        //分类下的文章
        $content = Content::with('metas')
            ->with('tags')
            ->with('user')
            ->where("metas_id","=",$id)
            ->get();

        $typename = Metas::find($id);

        \SEOMeta::setTitle(env("SITE_NAME"));
        \SEOMeta::setDescription(env('SITE_describe'));
        \SEOMeta::setCanonical(env('SITE_address'));
        \SEOMeta::addKeyword([env('SITE_KEY')]);

        \OpenGraph::setDescription(env('SITE_describe'));
        \OpenGraph::setTitle(env("SITE_NAME"));
        \OpenGraph::setUrl(env('SITE_address'));
        \OpenGraph::addProperty('type', 'articles');

        \OpenGraph::addProperty('type', 'article');
        \OpenGraph::addProperty('locale', 'pt-br');
        \OpenGraph::addProperty('locale:alternate', ['pt-pt', 'en-us']);
        $state = 1;
        return \Theme::view('cs',compact('content','typename','state'));

    }

    /**
     * Notes:搜索
     * User:Administrator
     * Date:2018/4/28
     * Time:14:48
     * @param Request $request
     * @return \View
     */
    public function search(Request $request){
        //dd($request->all());
        $data = $request->get('data');
        $content = Content::where("title","like","%".$data."%")
            ->orwhere("html","like","%".$data."%")->get();

        $state = 0;

        return \Theme::view('cs',compact('content','data','state'));

    }

    /**
     * Notes:文章归档
     * User:Administrator
     * Date:2018/5/2
     * Time:14:05
     * @param $year
     * @param $month
     * @return \View
     */
    public function inbox($year,$month){

        $content = \DB::select("select `content`.`title`,`content`.`slug`,`users`.`name`,`content`.`created_at`,`content`.`commentsNum`,`content`.`text` from `content`,`users` where `content`.`types` = 1 and `content`.`user_id` = `users`.`id` and month(`content`.`created_at`) = '".$month."' and `content`.`deleted_at` is null order by `content`.`created_at` desc
");


        return \Theme::view('inbox',compact('content','year','month'));

    }

    /**
     * Notes:友情链接
     * User:Administrator
     * Date:2018/5/5
     * Time:11:56
     * @return \View
     */
    public function link(){

        $links = Link::all();
        return \Theme::view('link',compact('links'));
    }


    /**
     * Notes:退出登录
     * User:Administrator
     * Date:2018/4/26
     * Time:13:30
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request, $id)
    {
        $request->session()->flush();
        return redirect("archives/{$id}.html#comments-1");
    }
}
