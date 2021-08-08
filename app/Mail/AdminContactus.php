<?php

namespace App\Mail;

use App\MailToken;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminContactus extends Mailable
{
    use Queueable, SerializesModels;
    protected $obj;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($obj)
    {
        $this->obj = $obj;
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'A new message from Realtyninfra.com - '.date('d-m-y H:i:s');
        return $this->subject($subject)
            ->view('emails.admin_contactus', [
                'type' => MailToken::TYPE_MAIL_CONTACTUS,
                'obj' => $this->obj
            ]);
    }
}
