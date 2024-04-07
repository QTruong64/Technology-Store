<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('User.index', function ($view) {
            \Carbon\Carbon::setLocale('vi');
            $sanpham = Product::join('galleries as a', 'a.id', 'products.galleryId')->get();
            $categoriesParent = Category::whereNull('parent_id')->take(10)->orderBy('id', 'ASC')->get();
            $categoriesNext = Category::whereNull('parent_id')->skip(10)->take(count($categoriesParent))->orderBy('id', 'ASC')->get();
            $categoriesSearch = Category::whereNull('parent_id')->get();

            $view->with(compact('sanpham', 'categoriesParent', 'categoriesNext', 'categoriesSearch'));

        });

        view()->composer('User.inc.left_post', function ($view) {
            $left_tags = Tag::inRandomOrder()->take(10)->get();
            $view->with(compact('left_tags'));

        });
    }
}
