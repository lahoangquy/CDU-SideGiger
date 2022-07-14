<?php

namespace App\Providers;

use App\Events\AcceptOrDecineProposalEvent;
use App\Events\InviteEvent;
use App\Events\NewMessageEvent;
use App\Events\ProposalProcessed;
use App\Events\RequestCompleteEvent;
use App\Listeners\AcceptAnInviteListener;
use App\Listeners\DeclineAnInviteListener;
use App\Listeners\DeleteAnInviteListener;
use App\Listeners\InviteListener;
use App\Listeners\NewMessageListener;
use App\Listeners\RequestCompleteListener;
use App\Listeners\SendConfirmedOffering;
use App\Listeners\SendProposalSubmittion;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ProposalProcessed::class => [
            SendProposalSubmittion::class,
        ],
        AcceptOrDecineProposalEvent::class => [
            SendConfirmedOffering::class
        ],
        NewMessageEvent::class => [
            NewMessageListener::class
        ],
        InviteEvent::class => [
            InviteListener::class,
            AcceptAnInviteListener::class,
            DeclineAnInviteListener::class,
            DeleteAnInviteListener::class,
        ],
        RequestCompleteEvent::class => [
            RequestCompleteListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
