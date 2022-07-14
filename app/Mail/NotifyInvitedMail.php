<?php

namespace App\Mail;

use App\Events\InviteEvent;
use App\Models\Invite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyInvitedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invite;

    public function __construct(Invite $invite)
    {
        $this->invite = $invite;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('support'))
            ->subject('You have been invited to a project')
            ->markdown('mail.invite.notify', [
                'url' => route('student.project.invited')
            ]);
    }
}
