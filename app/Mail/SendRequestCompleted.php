<?php

namespace App\Mail;

use App\Models\Project;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendRequestCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public $project;
    public $sender;
    public $owner;

    public function __construct(Project $project, User $sender, User $owner)
    {
        $this->project = $project;
        $this->sender = $sender;
        $this->owner = $owner;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('support'))
            ->subject('A request completed for ' . $this->project->title)
            ->markdown('mail.send-request-completed', [
                'url' => route('dashboard.show.contract', [$this->project->contract->id])
            ]);
    }
}
