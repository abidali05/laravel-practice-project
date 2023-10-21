<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        $userName = $this->user['name'];
        $userEmail = $this->user['email'];

        return $this->subject('New Message Notification')
            ->view('Mail.user_register')
            ->with([
                'userName' => $userName,
                'userEmail' => $userEmail,
            ]);
    }
}
