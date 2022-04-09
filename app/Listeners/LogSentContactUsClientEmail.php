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
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Mail\Events\MessageSent  $event
     * @return void
     */
    public function handle(MessageSent $event)
    {
        $dbRecord = json_encode($event->data['details']['ID']);

        DB::table('contact_us')
            ->where('id', $dbRecord)
            ->update(['email_sent' => 1]);

        Log::info("Amended email_sent row {$dbRecord} for contact_us table");
    }
}
