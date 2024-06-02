<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetToken extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $reset_token;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $reset_token)
    {
        //
        $this->user = $user;
        $this->reset_token = $reset_token;
    }


    public function build()
    {
        return $this->subject('Reset password token')
                    ->view('emails.reset_token')
                    ->with([
                        'user' => $this->user,
                        'reset_token' => $this->reset_token
                    ]);
    }

}
