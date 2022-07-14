<?php

namespace App\Listeners;

use App\Events\InviteEvent;
use App\Mail\NotifyInvitedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class InviteListener
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
        if ($event->status !== 'invited') {
            return;
        }

        Mail::to($event->invite->user->email)
            ->queue(new NotifyInvitedMail($event->invite));
    }
}
