<?php

namespace App\Listeners;

use App\Events\InviteEvent;
use App\Mail\AcceptOrDeclineAnInviteMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class AcceptAnInviteListener
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

        Mail::to($event->invite->project->poster->email)
            ->queue(new AcceptOrDeclineAnInviteMail($event->invite, $event->status));
    }
}
