<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordUserEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $passwordTemp;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $passwordTemp)
    {
        $this->user = $user;
        $this->passwordTemp = $passwordTemp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.passwordEmail')
            ->subject('Contraseña de cuenta - El Androide Paranóico');
    }
}
