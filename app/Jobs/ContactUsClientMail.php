<?php

namespace App\Jobs;

use App\Mail\ContactUsClientConfirm;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ContactUsClientMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $details;
    private $recipient;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details, string $email)
    {
        $this->details = $details;
        $this->recipient = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('emails.contactUsClientConfirm', ['details' => $this->details], function ($message) {
            $message->to($this->recipient);
            $message->subject('We\'ve received your message');
        });
    }
}
