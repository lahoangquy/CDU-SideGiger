<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendProposalSubmimissionMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $projectOffer;

    public function __construct($offer)
    {
        $this->projectOffer = $offer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('support'))
            ->subject('A new proposal on project: ' . $this->projectOffer->project->title)
            ->markdown('mail.send-proposal-submission', [
                'url' => route('staff.manage.project') . '#' . $this->projectOffer->project->id,
                'offer' => $this->projectOffer,
            ]);
    }
}
