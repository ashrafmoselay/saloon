<?php

namespace App\Providers;

use App\Observers\OrderObserver;
use App\Order;
use Illuminate\Database\Events\QueryExecuted;
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
        /*\DB::listen(function(QueryExecuted $query){
            \Log::info($query->sql, $query->bindings);
        });*/

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
