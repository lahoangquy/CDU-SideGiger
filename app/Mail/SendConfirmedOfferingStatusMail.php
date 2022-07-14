<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendConfirmedOfferingStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $offer;
    public $status;

    public function __construct($offer, $status)
    {
        $this->offer = $offer;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->status === 'approved' ? 'Congratulation: Your application has been approved' : 'Your application has been declined';
        return $this->from(config('support'))
            ->subject($subject)
            ->markdown('mail.confirm-offering-status', [
                'url' => route('dashboard.manage.contract'),
                'offer' => $this->offer,
                'status' => $this->status,
            ]);
    }
}
