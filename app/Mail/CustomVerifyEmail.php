<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class CustomVerifyEmail extends Mailable
{
    use SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @param $user
     */
    public function __construct(MustVerifyEmail $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return \Illuminate\Mail\Mailable
     */
    public function build()
    {
        return $this->subject('Xác minh tài khoản của bạn')
                    ->view('emails.custom_verify')
                    ->with([
                        'url' => route('verification.verify', ['id' => $this->user->getKey(), 'hash' => sha1($this->user->getEmailForVerification())]),
                        'name' => $this->user->name,
                    ]);
    }
}
