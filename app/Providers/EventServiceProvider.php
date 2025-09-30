<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    // protected array $listen = [
    //     \Illuminate\Auth\Events\Login::class => [
    //         \App\Listeners\AttachAuthToSession::class,
    //     ],
    //     // other event => listener mappings
    // ];
    
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
