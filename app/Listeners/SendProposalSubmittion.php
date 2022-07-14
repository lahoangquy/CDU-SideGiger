<?php

namespace App\Listeners;

use App\Events\ProposalProcessed;
use App\Mail\SendProposalSubmimissionMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendProposalSubmittion
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
     * @param  \App\Events\ProposalProcessed  $event
     * @return void
     */
    public function handle(ProposalProcessed $event)
    {
        Mail::to($event->projectOffer->project->poster->email)
            ->queue(new SendProposalSubmimissionMail($event->projectOffer));
    }
}
