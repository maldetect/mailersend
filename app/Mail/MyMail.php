<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MyMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */



    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $response = $this->from($this->email->from)
            ->subject($this->email->subject);
        if ($this->email->attachments) {
            foreach ($this->email->attachments as $attachment) {
                $response->attachData(base64_decode($attachment->base64), $attachment->filename);
            }
        }

        return $response->view('vendor.mail.html.layout');
    }
}
