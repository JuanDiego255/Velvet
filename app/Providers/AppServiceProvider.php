<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);
        view()->composer('*', function ($view) {
            $view_name = str_replace('.', '_', $view->getName());
            $cartNumber = count(Cart::where('user_id', Auth::id())->where('sold', 0)->get());
            view()->share([
                'view_name' => $view_name,
                'cartNumber' => $cartNumber
            ]);
        });
    }
}
