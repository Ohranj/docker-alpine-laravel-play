<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LogSentContactUsClientEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     * @return void
     */
    public function handle($event)
    {
        DB::table('contact_us')
            ->where('id', $event->dbRecord['rowID'])
            ->update(['email_sent' => 1]);

        Log::info("Amended email_sent row {$event->dbRecord['rowID']} for contact_us table. Email sent to {$event->dbRecord['receiver']}");
    }
}
