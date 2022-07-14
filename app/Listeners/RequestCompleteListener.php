<?php

namespace App\Listeners;

use App\Events\RequestCompleteEvent;
use App\Mail\SendRequestCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class RequestCompleteListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(RequestCompleteEvent $event)
    {
        Mail::to($event->owner->email)
            ->queue(new SendRequestCompleted($event->project, $event->sender, $event->owner));
    }
}
