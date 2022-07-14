<?php

namespace App\Mail;

use App\Models\Invite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AcceptOrDeclineAnInviteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invite;
    public $status;

    public function __construct(Invite $invite, string $status)
    {
        $this->invite = $invite;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = $this->status === 'accepted' ? 'Your invitation has been accepted' : 'Your invitation has been declined';
        return $this->from(config('support'))
            ->subject($subject)
            ->markdown('mail.invite.acceptOrDecline', [
                'url' => route('dashboard.manage.contract')
            ]);
    }
}
