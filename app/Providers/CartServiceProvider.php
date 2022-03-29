<?php

namespace App\Providers;

use App\Contracts\CartContract;
use App\Services\CartService;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */

    public function register()
    {
        $this->app->bind(CartContract::class, function () {
            return new CartService();
        });
    }

    public function provides()
    {
        return [CartContract::class];
    }
}
