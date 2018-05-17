<?php

namespace App\Providers;

use App\Model\Content;
use App\Model\Metas;
use Illuminate\Cache\DatabaseStore;
use Illuminate\Foundation\Testing\Constraints\HasInDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //左边的分类
        \Carbon\Carbon::setLocale('zh');
        if (Schema::hasTable('metas')) {
            $metas = Metas::where("status","=",0)->get();
            if ($metas) {
                view()->share('metas', $metas);
            }
        }
        //左边的归档
        if(Schema::hasTable('content')){
            $content = \DB::select('select year(created_at)  year,month(created_at) month,count(*) published 
                        from content where types=1 group by year, month order by min(created_at) desc');

            if($content){
                view()->share('inbox',$content);

            }
        }
        //左边的页面
        if(Schema::hasTable('content')){
            $pages = Content::where("types","=",2)->get();
            if($pages){
                view()->share('pages',$pages);
            }
        }

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
