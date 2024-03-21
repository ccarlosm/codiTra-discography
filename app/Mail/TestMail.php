<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
        // Initialization code here if needed
    }

    public function build()
    {
        return $this->from('example@example.com')
            ->view('emails.test');
    }
}
