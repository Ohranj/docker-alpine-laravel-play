<?php

namespace App\Jobs;

use App\Mail\ContactUsClientConfirm;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ContactUsClientMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $details;
    public $recipient;

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
        //Listener applied to email sent
        Mail::to($this->recipient)->send(new ContactUsClientConfirm($this->details));
    }
}
