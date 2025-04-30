<?php

namespace App\Listeners;

use App\Events\SendDonationConfirmation;
use App\Mail\DonationEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DonationConfirmation
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
    public function handle(SendDonationConfirmation $event): void
    {
        Log::info('SendDonationConfirmation Event Triggered');
        Mail::to($event->user->email)->send(new DonationEmail($event->user, $event->donation, $event->campaign));
    }
}
