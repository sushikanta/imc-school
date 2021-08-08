<?php

namespace App\Mail;

use App\MailToken;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Password Change Request for Time2Staff';
        return $this->subject($subject)
            ->view('emails.forgot_password', [
                'type' => MailToken::TYPE_FORGOT_PASSWORD,
                'user_id' => $this->user['id']
            ]);
    }
}
