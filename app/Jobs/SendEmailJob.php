<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mailInfo;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $mailTo = '';
    public $subject = '';
    public $body = '';
    public $userName = '';

    public function __construct($mailInfo)
    {
        $this->mailTo = $mailInfo['mailTo'];
        $this->subject = $mailInfo['subject'];
        $this->body = $mailInfo['body'];
        $this->userName = $mailInfo['userName'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->mailTo)->send(new SendMail($this->subject,$this->body, $this->userName));
    }
}
