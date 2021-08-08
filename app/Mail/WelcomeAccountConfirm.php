<?php

namespace App\Mail;

use App\MailToken;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeAccountConfirm extends Mailable
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
        $subject = 'Welcome to Time2Staff! Confirm Your Email';
        return $this->subject($subject)
            ->view('emails.welcome_confirm', [
                'type' => MailToken::TYPE_MAIL_CONFIRMATION,
                'user_id' => $this->user['id']
            ]);
    }
}
