<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendANoteWithNewMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $student;

    public function __construct($message, $student)
    {
        $this->message = $message;
        $this->student = $student;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('A New Messsage on: ' . $this->message->project->title)
            ->from(config('support'))
            ->markdown('mail.new-message-note', [
                'message' => $this->message,
                'student' => $this->student
            ]);
    }
}
