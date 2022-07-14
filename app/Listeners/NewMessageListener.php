<?php

namespace App\Listeners;

use App\Events\NewMessageEvent;
use App\Mail\SendANoteWithNewMessageMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NewMessageListener
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
    public function handle(NewMessageEvent $event)
    {
        Mail::to($event->student->email)
            ->queue(new SendANoteWithNewMessageMail($event->message, $event->student));
    }
}
