<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

// class SendMail extends Mailable implements ShouldQueue//need to run [php artisan queue:work] for queue
class SendMail extends Mailable

{
    use Queueable, SerializesModels;

    public $subject = '';
    public $body = '';
    public $userName = '';

    public function __construct($subject, $body, $userName)
    {

        $this->subject = $subject;
        $this->body = $body;
        $this->userName = $userName;
    }

    public function build()
    {

        $subject = $this->subject;
        $logo = '';

        return $this->subject($subject)
            ->view('emails.mailTemplate')
            ->with([
                'subject' => $this->subject,
                'body' => $this->body,
                'userName' => $this->userName,
                'logo' => $logo,
            ]);
    }

}
