<?php

namespace App\Listeners;

use App\Events\InviteEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteAnInviteListener
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
    public function handle(InviteEvent $event)
    {
        if (!in_array($event->status, ['accepted', 'declined'])) {
            return;
        }

        $event->invite->delete();
    }
}
