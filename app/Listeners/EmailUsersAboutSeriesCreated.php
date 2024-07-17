<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\SeriesCreated;
use App\Events\SeriesCreated as SeriesCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmailUsersAboutSeriesCreated implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SeriesCreatedEvent $event): void
    {
        $users = User::all();

        foreach($users as $user)
        {
            $email = new SeriesCreated(
                $event->serieName,
                $event->serieId,
                $event->serieSeasonsQty,
                $event->serieEpsiodeQty
            );

            //Mail::to($user)->send($email); Enviar direto
            Mail::to($user)->queue($email);
        } 
    }
}
