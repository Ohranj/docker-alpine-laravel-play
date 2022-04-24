<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use App\Events\MessageRetrievedEvent;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Crypt;

class MessageRetrievedEventListener
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
     * Decrypt the appropriate encrypted fields
     *
     * @param  \App\Events\MessageRetrievedEvent  $event
     * @return void
     */
    public function handle(MessageRetrievedEvent $event)
    {
        ['message' => $message] = get_object_vars($event);

        $message['message'] =  Crypt::decryptString($message['message']);
        $message['subject'] =  Crypt::decryptString($message['subject']);
        $message['human_created_at'] = Carbon::parse($message['created_at'])->toFormattedDateString();
    }
}
