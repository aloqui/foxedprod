<?php

namespace App\Listeners;

use App\Providers\Reset;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
    public function handle(Reset $event)
    {
        //
    }
}
