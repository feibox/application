<?php

namespace App\Mail;

use App\User;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationConfirmation extends Mailable
{
    use SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('emails.registration');
    }
}
