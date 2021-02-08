<?php

namespace App\Listeners;

use App\Events\UserUpdatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserUpdatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserUpdatedEvent  $event
     * @return void
     */
    public function handle(UserUpdatedEvent $event)
    {
        //
    }
}
