<?php

namespace App\Listeners;

use App\Mail\ResetPasswordEmail;
use App\Events\ResetPassword;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendResetConfirmationRequest
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
     * @param  Reset  $event
     * @return void
     */
    public function handle(ResetPassword $event)
    {
        Mail::to($event->user)->send(new ResetPasswordEmail($event->user));
    }
}
