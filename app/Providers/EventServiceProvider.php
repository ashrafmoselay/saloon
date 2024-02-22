<?php

namespace App\Providers;

use App\Events\OrderCreated;
use App\Events\ReturnCreated;
use App\Listeners\UpdateProductQuantity;
use App\Listeners\UpdateProductQuantityReturn;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        OrderCreated::class => [
            UpdateProductQuantity::class,
        ],
        ReturnCreated::class => [
            UpdateProductQuantityReturn::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
