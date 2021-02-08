<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\UserCreatedEvent::class => [
            \App\Listeners\UserCreatedListener::class,
        ],
        \App\Events\UserUpdatedEvent::class => [
            \App\Listeners\UserUpdatedListener::class,
        ],
        \App\Events\UserDeletedEvent::class => [
            \App\Listeners\UserDeletedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
