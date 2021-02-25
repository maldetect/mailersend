<?php

namespace App\Listeners;

use App\Events\NewEmailEvent;
use App\Jobs\SendEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DispatchEmail
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  NewEmail  $event
     * @return void
     */
    public function handle(NewEmailEvent $event)
    {
        SendEmail::dispatch($event->email)->onQueue('email');
    }
}
