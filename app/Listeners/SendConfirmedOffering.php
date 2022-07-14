<?php

namespace App\Listeners;

use App\Events\AcceptOrDecineProposalEvent;
use App\Mail\SendConfirmedOfferingStatusMail;
use Illuminate\Support\Facades\Mail;

class SendConfirmedOffering
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
    public function handle(AcceptOrDecineProposalEvent $event)
    {
        Mail::to($event->offer->user->email)
            ->queue(new SendConfirmedOfferingStatusMail($event->offer, $event->status));
    }
}
